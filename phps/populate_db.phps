<?php 
/*
 * Advanced Topics in Web Development
 * Darren Williams - 12039763
 *
 * populate_db.php
 *
 * Pulls all data from source URL 
 * and populates database tables
 *
*/

/*
 * I gave students assistance with this assignment
 * during PAL Espresso Programming sessions.
 * I asked the students to annotate this
 * within their code but for reference here
 * is a list of the students helped from my
 * PAL reflection sheet.
 *
 * Tegan Male
 * Shakira Damji
 * Asma Fayaz
 * Thomas Reed
 * Emmanuel Forson
 * Emma Lucas
 * Jessica Corbel
 * Katie Burt
 * Tim Purser
 * Adrian Nowak
 *
 */

//Create connection
require_once("includes/config.php"); 
//Get functions
require_once('includes/functions.php');
//Require simple html dom
//Downloaded from http://simplehtmldom.sourceforge.net/
require_once('includes/simple_html_dom.php');
//Character encoding
header('Content-type:text/html; charset=utf-8');
//Set URL
$url = 'http://www.cems.uwe.ac.uk/~p-chatterjee/2014-15/modules/atwd1/assignment/chess_world_champions.html';
// Create DOM
$html = file_get_html($url);

//As long as HTML is not empty
if(!empty($html)){

	//Foreach loop through the table rows - skip first header row
	foreach(array_slice($html->find('tr'), 1) as $row){ 
		//Set error to FALSE
		$error = FALSE;
		//Find td data - td[0] = names, td[1] = dates, td[2] = countries
		$td = $row->find('td');
		//Find name
		$full_name = trim($td[0]->plaintext);
		//Find name link
		$link = $td[0]->find('a');
		$name_url = $link[0]->href;
		//Insert player data
		$player_id = insertPlayer($full_name, $name_url, $conn);

		//Find dates and split by <br> or <br/>
		//Replace smaller hyphens with normal ones
		$dates = preg_split('/<br[^>]*>/i', str_replace('–','-',$td[1]->innertext));
		//Split first date and notes
		$first_date = splitDt($dates, 0);
		//Set values from returned array
		$startDate = $first_date[0];
		$endDate = $first_date[1];
		$notes = $first_date[2];
		//Insert dates and notes
		insertDate($startDate, $endDate, $notes, $player_id, $conn);

		//Empty second date
		$second_date = '';
		//If second date is set
		if(isset($dates[1])){
			//Split second date and notes
			$second_date = splitDt($dates, 1);
			//Set values from returned array
			$startDate = $second_date[0];
			$endDate = $second_date[1];
			$notes = $second_date[2];
			//Insert dates and notes
			insertDate($startDate, $endDate, $notes, $player_id, $conn);
		}
		//Empty empty third date
		$third_date = '';
		//If third date is set
		if(isset($dates[2])){
			//Split third date and notes
			$third_date = splitDt($dates, 2);
			//Set values from returned array
			$startDate = $third_date[0];
			$endDate = $third_date[1];
			$notes = $third_date[2];
			//Insert dates and notes
			insertDate($startDate, $endDate, $notes, $player_id, $conn);
		}
		
		//Find flag
		$img = $td[2]->find('img');
		$country_flag = $img[0]->src;
		
		//Find first country data
		$cLink = $td[2]->find('a');
		//Get country name and url
		$country_url = $cLink[0]->href;
		$country_name = $cLink[0]->plaintext;
		//Insert country and return id
		$country_id = insertCountry($country_name, $country_url, $country_flag, $conn);
		//Insert played id and country id into fk table
		$error = insertFk($player_id,$country_id,$conn);
		//Empty Country Flag
		$country_flag = '';
		//Find second country data
		if(isset($cLink[1])){
			//Find flag
			if(!isset($cLink[2])){
				if(isset($img[1])){
					$country_flag = $img[1]->src;
				}
			}
			//Get country name and url
			$country_url = $cLink[1]->href;
			$country_name = $cLink[1]->plaintext;
			//Insert country and return id
			$country_id = insertCountry($country_name, $country_url, $country_flag, $conn);
			//Insert played id and country id into fk table
			$error = insertFk($player_id,$country_id,$conn);
		}
		//Find third country data
		if(isset($cLink[2])){
			//Find flag
			if(isset($img[1])){
				$country_flag = $img[1]->src;
			}
			//Get country name and url
			$country_url = $cLink[2]->href;
			$country_name = $cLink[2]->plaintext;
			//Insert country and return id
			$country_id = insertCountry($country_name, $country_url, $country_flag, $conn);
			//Insert played id and country id into fk table
			$error = insertFk($player_id,$country_id,$conn);
		}
		//Visual feedback for each tr
		if($error == TRUE){
			echo 'Data already inserted <br>';
		}else{
			echo 'Data successfully inserted! <br>';
		}
	} //Close foreach

	//Close connection
	$conn->close();

//Else there is an error
}else{
	echo 'Error, there is an issue with the returned data !';
}

?>

