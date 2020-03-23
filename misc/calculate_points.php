<?php

require('../helpers.php');

$conn = get_connection();

// Get ids for all teams
try {
  $sql = "SELECT `id` FROM `teams`;";
  $stmt = $conn->query($sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $teams_rows = $stmt->fetchAll();
} catch(PDOException $e) {
  echo "Selecting all teams failed: " . $e->getMessage();
}

// Create array with team_id as keys; values will be points totals
$teams = [];
foreach ($teams_rows as $row) {
  $teams[$row["id"]] = 0;
}

// Get all matches
try {
  $sql = "SELECT * FROM `matches`;";
  $stmt = $conn->query($sql);
  $stmt->setFetchMode(PDO::FETCH_ASSOC);
  $matches = $stmt->fetchAll();
} catch(PDOException $e) {
  echo "Selecting all teams failed: " . $e->getMessage();
}

// Determine the winner for each match and grant points accordingly
foreach ($matches as $match) {
  $team1_id = $match["team1_id"];
  $team2_id = $match["team2_id"];

  if ($match["team1_score"] > $match["team2_score"]) {
    $teams[$team1_id] += 3;
  } elseif ($match["team2_score"] > $match["team1_score"]) {
    $teams[$team2_id] += 3;
  } else {
    $teams[$team1_id] += 1;
    $teams[$team2_id] += 1;
  }
}

// Update all teams with new points total
$num_updates = 0;
foreach ($teams as $team_id=>$points) {
  $sql = "UPDATE `teams` SET points = $points WHERE id = $team_id;";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $num_updates += $stmt->rowCount();
}

echo $num_updates . " records UPDATED successfully";
