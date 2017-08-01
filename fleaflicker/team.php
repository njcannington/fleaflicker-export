<?php
class Team extends Fleaflicker
{
	private $team_id;
	private $team_name;
	private $players = array();

	/**
	* Builds team object by extracting name 
	* and players from fleaflicker team pages
	*
	* @param string $league_id
	* @param string $team_id
	*/
	public function __construct($league_id,$team_id){
		$base = "https://www.fleaflicker.com/nfl/leagues/{$league_id}/teams/";
		$url = $base."$team_id";
		$data = self::prepData($url);

		$this->team_id 	 = $team_id;
		$this->team_name = self::extractTeamName($data);
		$this->players 	 = self::extractPlayers($data);
	}

	/**
	* Removes the status of each player 
	* (questionable, suspended, injured reserve)
	* 
	* @param string $html
	*
	* @return string
	*/
	public static function cleanupHTML($html){
		$html = str_replace("Q</span>","",$html);
		$html = str_replace("SUS</span>","",$html);
		$html = str_replace("IR</span>","",$html);
		$html = preg_replace("#<[^>]+>#","",$html);
		$html = str_replace("&#39;","'",$html);
		$html = str_replace("PUP","",$html);

		return $html;

	}

	/**
	* Runs the raw HTML through a few cleanup methods 
	* to return an array of data that contains the team names and players
	*
	* @param string $url
	* 
	* @return array
	*/
	private static function prepData($url){
		$html = self::getHTML($url);
		$teams = self::convertRowstoArray($html);
		$teams = self::cleanupHTML($teams);

		return $teams;
	}

	/**
	* Extracts the team name from the array of data
	*
	* @param array $data
	* 
	* @return string
	*/
	private static function extractTeamName($data){
		$parts = explode("-", $data[0]);
		$team_name = trim($parts[0]);

		return $team_name;
	}

	/**
	* Extracts the player names and positions from the array of data
	*
	* @param array $data
	* 
	* @return array
	*/
	private static function extractPlayers($data){
		$players = array();
		$count = count($data);
		$positions = array("QB","RB","WR","TE");
		$ii = 0;
		for ($i=1; $i<$count; $i++){
			$parts = explode(" ", $data[$i]);
			if (isset($parts[2]) && in_array($parts[2], $positions)){
				$players[$ii]["name"] = $parts[0]." ".$parts[1];
				$players[$ii]["position"] = $parts[2];
				$ii++;
			}
		}

		return $players;
	}

	/**
	* Returns team name
	* 
	* @return string
	*/
	public function getTeamName(){
		return $this->team_name;
	}

	/**
	* Returns array of players name and positions
	* 
	* @return array
	*/
	public function getPlayers(){
		return $this->players;
	}

}