# FIFA test api

## seed_scripts
De seed scripts zijn gemaakt voor een database met de volgende tabellen:

```
CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0
);

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `team_id` int(11) NOT NULL
);

CREATE TABLE `matches` (
  `id` int(11) NOT NULL,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `team1_score` int(11) DEFAULT NULL,
  `team2_score` int(11) DEFAULT NULL
);

CREATE TABLE `goals` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `minute` int(11) NOT NULL
);
```

**NB:** De SQL-code hierboven geeft een beeld van de tabel en de eigenschappen van de kolommen. Het is geen import-script. Voor het import-script met volledige info over de database, zie `sql_import/fifa.sql`.

De seed scripts maken gebruik van hard coded waarden, en van waarden die uit de database gehaald worden. Om die reden is het noodzakelijk de scripts in een bepaalde volgorde uit te voeren:

1. `seed_scripts/generate_teams.php`
  Dit script heeft alleen hard-coded waarden voor de team-namen.
  Handmatige aanpassingen in dit script dienen ook doorgevoerd te worden in `generate_players`.
2. `seed_scripts/generate_players.php`
  Dit script heeft dezelfde hardcoded team-namen als `generate_teams`, en voor elk team elf hard-coded namen voor spelers.
3. `seed_scripts/generate_matches.php`
  Dit script simuleert een toernooi door ieder team uit de database twee keer tegen elkaar te laten spelen. Elk team krijgt een random score van 0-5 (inclusief) voor de wedstrijd.
  Dit script bevat geen hardcoded waarden.
4. `seed_scripts/generate_goals.php`
  Dit script haalt alle data over matches op uit de database. Vervolgens genereert het voor iedere goal in iedere match de benodigde data over die goal.
  Dit script bevat geen hardcoded waarden.
5. `misc/calculate_points.php`
  Nadat alle matches gegenereerd zijn, kan ook het puntentotaal van ieder team in de `teams` tabel aangepast worden, op basis van de resultaten van de matches. Dit script is gemaakt om dit puntentotaal per team te berekenen op basis van de matches in de database.

## endpoints

Zie index.php
