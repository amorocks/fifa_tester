<?php

require('../helpers.php');

$conn = get_connection();

// Get all data for all matches
try {
  $sql = "SELECT * FROM `matches`;";
  $stmt = $conn->query($sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $matches = $stmt->fetchAll();
} catch(PDOException $e) {
  echo "<p>Selecting all teams failed: " . $e->getMessage() . "</p>";
}

// For each match:
foreach ($matches as $match) {
  // get all player id's for both teams
  $team1_players_sql = "SELECT (`id`) FROM `players` WHERE team_id = $match[team1_id]";
  $team2_players_sql = "SELECT (`id`) FROM `players` WHERE team_id = $match[team2_id]";

  $stmt = $conn->query($team1_players_sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $team1_players = $stmt->fetchAll();

  $stmt = $conn->query($team2_players_sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $team2_players = $stmt->fetchAll();

  for ($goal_num = 0; $goal_num < $match["team1_score"]; $goal_num++) {
    $goalmaker_id = $team1_players[array_rand($team1_players)]["id"];
    $goal_minute = rand(0, 90);
    $sql = "INSERT INTO `goals` (`id`, `player_id`, `match_id`, `minute`) VALUES (NULL, $goalmaker_id, $match[id], $goal_minute);";
    $conn->exec($sql);
  }

  for ($goal_num = 0; $goal_num < $match["team2_score"]; $goal_num++) {
    $goalmaker_id = $team2_players[array_rand($team2_players)]["id"];
    $goal_minute = rand(0, 90);
    $sql = "INSERT INTO `goals` (`id`, `player_id`, `match_id`, `minute`) VALUES (NULL, $goalmaker_id, $match[id], $goal_minute);";
    $conn->exec($sql);
  }
}

?>
