<?php

require('../helpers.php');

$conn = get_connection();

$teams = ["Paris Saint-Germain" => ["Mason Slaetsdochter", "Normie Brouwer", "Ryan Vierdag", "Murpadurp Pauwels", "Hanzo Verbeek", "Lorenzo Kort", "Badonkadonk Welf-Berendse", "David Pierson", "Furmurdurp Lamore-van Hemert", "Angelo Verheij", "Bram Beijring"],
  "Real Madrid" => ["David Coleman",
    "Douglas Melton",
    "Shane Watson",
    "Robert Short",
    "William Hensley",
    "Christopher Rodriguez",
    "Michael Knight",
    "Robert Weber",
    "Glen James",
    "Mike Gonzalez",
    "Benjamin Brown"],
  "Tottenham Hotspur" => ['Michael Becker', 'Chad Collins', 'Kevin Gilbert', 'Joseph Smith', 'Randy Reynolds', 'Patrick Moore', 'Adam Scott', 'Marcus Cole', 'Mark Jones', 'Barry Mullen', 'Michael Shields'],
  "Dinamo Zagreb" => ['Kenneth Pratt', 'Sean Gray', 'Timothy Salazar', 'Eric Summers', 'David Ramirez', 'Eric Bailey', 'Samuel Allison', 'Aaron Chen MD', 'William Thomas', 'Scott Benson', 'Larry Gamble'],
  "Atletico Madrid" => ['Joshua Clark', 'John Williams', 'Steven Archer', 'Martin Morales', 'Ronald Bradshaw', 'Patrick Young', 'Ricardo Dixon', 'Ricky Stuart', 'Aaron Chavez', 'Matthew Dunn', 'Eugene Flynn'],
  "Lokomotiv Moscow" => ['Michael Chavez', 'Joseph Hampton', 'Roger Smith', 'David Collins', 'Thomas Valdez', 'Matthew Hogan', 'Michael Wilson', 'Michael Singh', 'Jeremy Branch', 'Cory Allen', 'Robert Ellis'],
  "Liverpool" => ['Anthony Pierce', 'James Love', 'William Castaneda', 'Andrew Johnson', 'Marcus Hays', 'Aaron Harris', 'James Sawyer', 'Hayden Murphy', 'Randy Buckley', 'Thomas Anderson', 'Ralph Combs'],
  "Barcelona" => ['Joshua Hicks', 'Timothy Yang', 'Joseph Chase', 'Joshua Davis', 'Scott Robinson', 'Andrew Flores', 'Christopher Gomez', 'Andrew Torres', 'Daniel Branch', 'Vincent Robles', 'Jacob Williamson'],
  "Ajax" => ['Richard Perez', 'Mr. Matthew Roy', 'James White', 'Douglas Gomez', 'Derrick Carter', 'Robert Kelley', 'Nicholas Gilmore', 'Kevin Jenkins', 'Andrew Drake', 'Mark Patel', 'Joshua Harris'],
  "Chelsea" => ['Nathan Gomez', 'Nicholas Hill', 'Brandon Hall', 'Benjamin Newton', 'Bradley Silva', 'Frank Gutierrez', 'Mark Schwartz', 'Juan Clayton', 'Richard Thomas', 'Gregory Rhodes', 'Shawn Lloyd']
];

try {
  foreach ($teams as $team=>$players) {
    // Get team id from table 'teams'
    $stmt = $conn->query("SELECT (`id`) FROM `teams` WHERE name = '$team';");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    // echo "<p>";
    // var_dump($result) . "</p>";
    $team_id = $result[0]["id"];
    foreach ($players as $player) {
      // insert player with team_id
      $sql = "INSERT INTO `players` (`id`, `name`, `team_id`) VALUES (NULL, '$player', '$team_id');";
      $conn->exec($sql);
    }
  }
} catch(PDOException $e) {
  echo "Insert failed: " . $e->getMessage();
}

$conn = null;

?>
