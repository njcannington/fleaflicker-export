<?php
class Fleaflicker
{
	/**
	* Breaks raw HTML up by table row
	* 
	* @param string $html
	* 
	* @return array
	*/
	protected static function convertRowstoArray($html){
		$array = explode("</tr>", $html);

		return $array;
	}

	/**
	* Basic curl operation, that verifies a 
	* Fleaflicker league and returns raw HTML
	*
	* @param string $url
	* 
	* @return string
	*/
	protected static function getHTML($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		$html = curl_exec($curl);
		$status = curl_getinfo($curl,CURLINFO_HTTP_CODE);
		curl_close($curl);

		if ($status != 200){
			echo "Double check your league id.";
			exit;
		}else{
			return $html;
		}
		
		return $html;
	}
}