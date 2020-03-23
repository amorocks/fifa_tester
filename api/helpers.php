<?php
session_start();
safety_check();

function safety_check($prefix = "../")
{
  if(isset($_GET['local'])) return;

  $errors = array();
  if(is_dir($prefix."misc")) $errors[] = "misc";
  if(is_dir($prefix."seed_scripts")) $errors[] = "seed_scripts";
  if(is_dir($prefix."sql_import")) $errors[] = "sql_import";

  if(!empty($errors))
  {
    echo "<h3>";
    echo "Verwijder a.u.b. deze mappen uit de productie-omgeving: <span style='color: red;'>";
    echo implode(', ', $errors);
    echo "</span></h3>";
    exit;
  }
}

function check_key()
{
  $key = $_GET['key'] ?? $_SESSION['key'] ?? null;
  if ($key == null) {
    echo json_encode(["error"=>"no key given (key equals username, e.g. D123456 or ab01)"]);
    exit;
  }
  return $key;
}

function json_print($json)
{
  if(isset($_SESSION['key']))
  {
    echo "<pre>";
    echo json_encode($json, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
    echo "</pre>";
  }
  else
  {
    header('Content-type: application/json');
    echo json_encode($json, JSON_NUMERIC_CHECK);
  }
}

function get_connection() {
  $servername = "localhost";
  $username = "root";
  $password = "";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=fifa_tester", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
  } catch(PDOException $e) {
    echo "<p>Connection failed: " . $e->getMessage() . "</p>";
  }

  return $conn;
}

function get_random_matches($conn, $num_matches, $get_score, $match_ids = null) {
  if ($get_score) {
    $sql = "SELECT m.id, m.team1_id, t1.name AS team1_name, m.team1_score, 
                         m.team2_id, t2.name AS team2_name, m.team2_score
            FROM matches AS m
            LEFT JOIN teams t1 ON m.team1_id = t1.id
            LEFT JOIN teams t2 on m.team2_id = t2.id ";
      if(is_array($match_ids)) {
        $sql .= "WHERE m.id IN(" . implode(',', $match_ids) . ")";
      } else {
        $sql .= "ORDER BY RAND()
            LIMIT $num_matches;";
      }
  } else {
    $sql = "SELECT m.id, m.team1_id, t1.name AS team1_name,
                         m.team2_id, t2.name AS team2_name
            FROM matches AS m
            LEFT JOIN teams t1 ON m.team1_id = t1.id
            LEFT JOIN teams t2 on m.team2_id = t2.id
            ORDER BY RAND()
            LIMIT $num_matches;";
  }
  
  // Get all matches, joining names of both teams on team id
  try {
    $stmt = $conn->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $matches = $stmt->fetchAll();
  } catch(PDOException $e) {
    echo "<p>Selecting random matches failed: " . $e->getMessage() . "</p>";
  }

  return $matches;
}

function put_session($conn, $matches, $user)
{
  $sql = "INSERT INTO requests (user_id, match_ids) VALUES(:user_id, :match_ids)";
  $match_ids = array_column($matches, 'id');
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(
    ":user_id" => $user,
    ":match_ids" => implode(',', $match_ids)
  ));
}

function get_session($conn, $user)
{
  $sql = "SELECT match_ids FROM requests WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(
    ":user_id" => $user
  ));
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $match_ids = $stmt->rowCount() ? explode(',', $result['match_ids']) : null;

  $sql = "DELETE FROM requests WHERE user_id = :user_id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(
    ":user_id" => $user
  ));

  return $match_ids;
}
