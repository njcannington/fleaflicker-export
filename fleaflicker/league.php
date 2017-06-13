<?php
class League extends Fleaflicker
{
	protected $league_id;
	protected $team_ids = array();

	/**
	* Builds league object by extracting team ids 
	* from fleaflicker team pages
	*
	* @param string $league_id
	* 
	*/
	public function __construct($league_id){
		$base = "https://www.fleaflicker.com/nfl/leagues/";
		$url = $base."$league_id";

		$this->league_id = $league_id;
		$this->team_ids = self::extractTeamIDs($league_id,$url);
	}

	/**
	* Extracts anchor tags containg team ids and stors id in array
	*
	* @param string $league_id
	* @param string $url
	* 
	* @return array
	*/
	private static function extractTeamIDs($league_id,$url){
		$html = self::getHTML($url);
		$needle = "<a href=\"/nfl/leagues/{$league_id}/teams/";
		$last_pos = 0;
		$positions = array();

		while (($last_pos = strpos($html, $needle, $last_pos))!== false) {
		    $positions[] = $last_pos;
		    $last_pos = $last_pos + strlen($needle);
		}

		foreach ($positions as $value) {
			$team_link = substr($html,$value,44)."\n";
			$team_link = explode("/", $team_link);
			$team_id = substr($team_link[5], 0, -3);
			$team_ids[] = $team_id;
		}

		return $team_ids;
	}

	/**
	* Returns team ids
	* 
	* @return array
	*/
	public function getTeamIDs(){
		return $this->team_ids;
	}
}