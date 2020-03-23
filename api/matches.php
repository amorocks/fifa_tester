<?php
require('helpers.php');
$key = check_key();

$num_matches = rand(0, 10);
if ($num_matches === 0) {
  return null;
}

// db connection from helpers.php
$conn = get_connection();

// get the required number of matches; random from the connected db
$matches = get_random_matches($conn, $num_matches, false);
usort($matches, function($a, $b) {
    return $a['id'] <=> $b['id'];
});

put_session($conn, $matches, $key);
json_print($matches);

?>