<?php

require('../helpers.php');

$conn = get_connection();

// get all teams
try {
  $sql = "SELECT (`id`) FROM `teams`;";
  $stmt = $conn->query($sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $result = $stmt->fetchAll();
} catch(PDOException $e) {
  echo "<p>Selecting all teams failed: " . $e->getMessage() . "</p>";
}

// calculate cartesian product for each team
try {
  foreach ($result as $team1) {
    foreach ($result as $team2) {
      if ($team1['id'] !== $team2['id']) {
        $team1_score = rand(0, 5);
        $team2_score = rand(0, 5);

        $sql = "INSERT INTO `matches` (`id`, `team1_id`, `team2_id`, `team1_score`, `team2_score`) VALUES (NULL, $team1[id], $team2[id], $team1_score, $team2_score);";
        $conn->exec($sql);

        echo "<p>Match: $team1[id] vs. $team2[id] | Score: $team1_score - $team2_score | INSERT DONE!</p>";
      }
    }
  }
} catch(PDOException $e) {
  echo "<p>Inserting all matches failed: " . $e->getMessage() . "</p>";
}

?>