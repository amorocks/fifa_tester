<?php
require('helpers.php');
$key = check_key();

$conn = get_connection();

// Geef een array terug met resultaten voor 0-10 wedstrijden.
$num_matches = rand(0, 10);
if ($num_matches === 0) {
  return null;
}

// get the required number of matches; random from the connected db
$match_ids = get_session($conn, $key);
$matches = get_random_matches($conn, $num_matches, true, $match_ids);

foreach ($matches as &$match) {
  if ($match["team1_score"] > $match["team2_score"]) {
    $winner = $match["team1_id"];
  } elseif ($match["team2_score"] > $match["team1_score"]) {
    $winner = $match["team2_id"];
  } else {
    $winner = null;
  }

  $match["winner_id"] = $winner;
}

json_print($matches);
?>