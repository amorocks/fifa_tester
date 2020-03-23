<?php
require('api/helpers.php');
safety_check(null);
if(!isset($_SESSION['key'])) {
	$_SESSION['key'] = uniqid();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>FIFA Test API</title>
	<style>
		body{
			font-family: Arial, sans-serif;
			max-width: 960px;
			margin: 0 auto;
		}
		h2{
			margin: 25px 0px 5px 0px;
		}
		p{
			margin: 10px 0;
		}
		p+pre{
			margin-top: -10px;
		}
		pre{
			background-color: lightgrey;
			padding: 20px 10px;
			margin-top: 0px;
			margin-bottom: 25px;
		}
	</style>
</head>
<body>
	<h1>FIFA Test API</h1>
	<p>Gebruik deze API om je C#-applicatie te testen, totdat de API van je eigen groep klaar is.</p>

	<h2>1. <a href="api/matches.php" target="_blank">api/matches.php?key={user}</a></h2>
  	<p>Dit endpoint geeft informatie over 0-10 willekeurige matches.</p>

  	<p>Resultaten zien er als volgt uit:</p>
  	<pre>
[
    {
		"id": 63,
		"team1_id": 9,
		"team1_name": "Liverpool",
		"team2_id": 12,
		"team2_name": "Chelsea"
    },
    {
		"id": 12,
		"team1_id": 4,
		"team1_name": "Real Madrid",
		"team2_id": 6,
		"team2_name": "Dinamo Zagreb"
    }
]</pre>

	<h2>2. <a href="api/results.php" target="_blank">api/results.php?key={user}</a></h2>
  	<p>Dit endpoint geeft informatie over 0-10 willekeurige matches. Ten opzichte van `matches.php` wordt extra informatie gegeven: de scores van beide teams, en de id van de winnaar.</p>

  	<p>Noot; als je eerst matches ophaalt krijg je de eerstvolgende keer resultaten van precies <em>die</em> matches te zien. De keer daarna krijg je weer 0-10 willekeurige resultaten.</p>

  	<p>Resultaten zien er als volgt uit:</p>
  	<pre>
[
	{
		"id": 11,
		"team1_id": 4,
		"team1_name": "Real Madrid",
		"team1_score": 5,
		"team2_id": 5,
		"team2_name": "Tottenham Hotspur",
		"team2_score": 3,
		"winner_id": 4
	},
	{
		"id": 47,
		"team1_id": 8,
		"team1_name": "Lokomotiv Moscow",
		"team1_score": 3,
		"team2_id": 4,
		"team2_name": "Real Madrid",
		"team2_score": 1,
		"winner_id": 8
	}
]</pre>

	<h2>3. <a href="api/goals.php?match_id={match_id}" target="_blank">api/goals.php?key={user}&match_id={match_id}</a></h2>
  	<p>Dit endpoint geeft informatie over alle goals die zijn gemaakt in de match met het bijbehorende id.</p>

  	<p>Resultaten zien er als volgt uit:</p>
  	<pre>
[
	{
		"id": 1,
		"player_id": 11,
		"match_id": 1,
		"minute": 77,
		"player_name": "Bram Beijring",
		"player_team": "Paris Saint-Germain"
	},
	{
		"id": 2,
		"player_id": 16,
		"match_id": 1,
		"minute": 39,
		"player_name": "William Hensley",
		"player_team": "Real Madrid"
	}
]</pre>

</body>
</html>