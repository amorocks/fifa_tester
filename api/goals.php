<?php
require('helpers.php');
$key = check_key();

// Check whether necessary query parameter is present
if (!array_key_exists("match_id", $_GET)) {
  echo json_encode(["error"=>"no match id given"]);
  return;
}

$match_id = (is_numeric($_GET["match_id"])) ? $_GET["match_id"] : rand(1, 100);

// db connection from helpers.php
$conn = get_connection();

// Get goals for requested match; for each goal, join player and team name
try {
  $sql = "SELECT g.id, g.player_id, g.match_id, g.minute, 
                 p.name AS player_name, t.name AS player_team
          FROM `goals` AS g
          LEFT JOIN players p ON p.id = g.player_id
          LEFT JOIN teams t ON p.team_id = t.id
          WHERE match_id = $match_id;
          ";
  $stmt = $conn->query($sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $goals = $stmt->fetchAll();
} catch(PDOException $e) {
  echo "<p>Selecting goal failed: " . $e->getMessage() . "</p>";
}

json_print($goals);
?>