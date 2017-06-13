<?php
require "include.php";

$league_id = $argv[1];

$league = new League($league_id);
$team_ids = $league->getTeamIDs();
$timestamp = gmdate("Y-m-d\TH:i:s\Z",time());

$csv = fopen("files/{$league_id}-{$timestamp}.csv","w");
$line_1 = array("name", "position", "owner");
fputcsv($csv, $line_1);


foreach ($team_ids as $team_id) {
	$team = new Team($league_id,$team_id);
	$team_name = $team->getTeamName();
	foreach ($team->getPlayers() as $player){
		$new_line = array($player["name"],$player["position"],$team_name);
		fputcsv($csv, $new_line);
	}
}

