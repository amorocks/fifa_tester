<?php

require('../helpers.php');

$conn = get_connection();

$teams = ["Paris Saint-Germain", "Real Madrid", "Tottenham Hotspur", "Dinamo Zagreb", "Atletico Madrid", "Lokomotiv Moscow", "Liverpool", "Barcelona", "Ajax", "Chelsea"];

try {
  foreach ($teams as $team) {
    // Note: if you want all this data to be correct, you will need to update points after generating all matches
    $sql = "INSERT INTO `teams` (`id`, `name`, `points`) VALUES (NULL, '$team', '0');";
    $conn->exec($sql);
  }
} catch(PDOException $e) {
  echo "Insert failed: " . $e->getMessage();
}

$conn = null;

?>




