<?php

/*
 * Advanced Topics in Web Development
 * Darren Williams - 12039763
 *
 * functions.php
 * Contains all main functions
 *
*/

/*
 * Database insert functions
 * insertCountry()
 * insertPlayer()
 * insertDate()
 * insertFK()
 *
*/

//Insert Country data
function insertCountry($country_name, $country_url, $country_flag = NULL, $conn){
	//Check for existing entry
	$sql = "SELECT id_country, country_name FROM country WHERE country_name = '$country_name'";	
	$result = mysqli_query($conn,$sql);
	$entry = mysqli_fetch_assoc($result);
	//If no entry add new and return id
	if (empty($entry)) {
		$sql = "INSERT INTO country (country_name, country_url, country_flag)
		VALUES ('$country_name', '$country_url', '$country_flag')";
		mysqli_query($conn,$sql);
		$country_id = mysqli_insert_id($conn);
		return $country_id;
	}else{
		//Else return existing id
		$country_id = $entry['id_country'];
		return $country_id;
	}
	$result->close();
} //End insertCountry

// Insert player data
function insertPlayer($full_name, $name_url, $conn){
	//Check for existing entry
	$sql = "SELECT id_player, full_name FROM player WHERE full_name = '$full_name'";	
	$result = mysqli_query($conn,$sql);
	$entry = mysqli_fetch_assoc($result);
	//If no entry add new and return id
	if (empty($entry)) {
		$sql = "INSERT INTO player (full_name, name_url)
		VALUES ('$full_name', '$name_url')";
		mysqli_query($conn,$sql);
		$player_id = mysqli_insert_id($conn);
		return $player_id;
	}else{
		//Else return existing id
		$player_id = $entry['id_player'];
		return $player_id;
	}
	$result->close();
} //End insert player

// Insert date data
function insertDate($startDate, $endDate = NULL, $notes = NULL, $player_id, $conn){
	//Check for existing entry
	$sql = "SELECT start_year, end_year, player_id_player FROM dates 
	WHERE start_year = '$startDate' AND end_year = '$endDate' AND player_id_player = '$player_id'";	
	$result = mysqli_query($conn,$sql);
	$entry = mysqli_fetch_assoc($result);
	//If no entry add new 
	if (empty($entry)) {
		$sql = "INSERT INTO dates (start_year, end_year, notes, player_id_player)
		VALUES ($startDate, $endDate, '$notes', $player_id)";
		mysqli_query($conn,$sql);
	}
	$result->close();
} //End insert date

//Insert foreign key data
function insertFk($player_id, $country_id, $conn){
	//Check for existing entry
	$sql = "SELECT name_idname, country_idcountry FROM name_has_country 
	WHERE name_idname = '$player_id' AND country_idcountry = '$country_id'";	
	$result = mysqli_query($conn,$sql);
	$entry = mysqli_fetch_assoc($result);
	//If no entry add new 
	if (empty($entry)) {
		$sql = "INSERT INTO name_has_country (name_idname, country_idcountry)
		VALUES ($player_id,$country_id)";
		mysqli_query($conn,$sql);
	}else{
		//Else return existing error message
		$error = TRUE;
		return $error;
	}
	$result->close();
}//End insert FK

/*
 * Database select function
 * getPlayerData()
*/

//Get all player data
function getPlayerData($conn){
	$sql = "SELECT * 
	FROM player p
	LEFT JOIN name_has_country f ON p.id_player = f.name_idname
	LEFT JOIN country c ON f.country_idcountry = c.id_country
	";
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}else{
		return $result;
	}
	$result->close();
}

//Get all date data
function getDateData($id_player, $conn){
	$sql = "SELECT * 
	FROM dates
	WHERE player_id_player = $id_player";
	$result = mysqli_query($conn,$sql);
	//If no results show error
	if (!mysqli_query($conn, $sql)) {
		printf(mysqli_error($conn));
	}else{
		return $result;
	}
	$result->close();
}

/*
 * Create functions
 * createTable()
 * createXML()
 * createJson()
*/

/*
 * Generates HTML table and microformat attributes
 * Returns RDFa or Microdata attributed markup
 * depending on URL query string i.e output.php?data=rdfa
 * Defaults to standard HTML table
 *
 * createTable()
*/

//create Table
function createTable($conn, $microformat){

		if($microformat == 'rdfa'){
			//Set RDFa Microformat attributes
			$nameData = 'property="performer"';
			$urlNameData = 'property="name url"';
			$eventData = 'vocab="http://schema.org/" typeof="Event"';
			$subEventData = 'property="subEvent" typeof="Event"';
			$personData = 'typeof="Person"';
			$startDate = 'property="startDate" content="';
			$endDate = 'property="endDate" content="';
			$countryData = 'typeof="PostalAddress"';
			$addressData = 'property="addressLocality url"';
			$locationData = 'property="location"';
			$imageData = 'property="image"';
		}else if($microformat == 'md'){
			//Set microdata Microformat attributes
			$nameData = 'itemprop="performer"';
			$urlNameData = 'itemprop="name url"';
			$eventData = 'itemscope itemtype="http://schema.org/Event"';
			$subEventData = 'itemprop="subEvent" itemscope itemtype="http://schema.org/Event"';
			$personData = 'itemscope itemtype="http://schema.org/Person"';
			$startDate = 'itemprop="startDate" content="';
			$endDate = 'itemprop="endDate" content="';
			$countryData = 'itemscope itemtype="http://schema.org/PostalAddress"';
			$addressData = 'itemprop="addressLocality url"';
			$locationData = 'itemprop="location"';
			$imageData = 'itemprop="image"';
		}else{
			//Empty variables
			$nameData = '';
			$urlNameData = '';
			$eventData = '';
			$subEventData = '';
			$personData = '';
			$startDate = '';
			$endDate = '';
			$countryData = '';
			$addressData = '';
			$locationData = '';
			$imageData = '';
		}
		//Get data
		$result = getPlayerData($conn);
		//Create table
		$table = '<table>
					<tr>
						<th>Name</th>
						<th>Year</th>
						<th>Country</th>
					</tr>';
		//Reset prev_id
		$prev_id = '';
		while($row = mysqli_fetch_array($result)){
			//Extract returned data
			extract($row);

			if($prev_id != $id_player){
			//If not first player
				if($prev_id != ''){
					$table .= '</td></tr><tr '.$eventData.'>';
				}else{
					$table .= '<tr '.$eventData.'>';
				}

				$table .= '<td '.$nameData .' '. $personData.'>';
				$table .= '<a '.$urlNameData.' href="'.$name_url.'" title="'.$full_name.'" >'.$full_name.'</a></td>';
				$table .= '<td>';
				//Get date data
				$innerResult = getDateData($id_player, $conn);
				//Loop through returned data
				while($innerRow = mysqli_fetch_array($innerResult)){
					extract($innerRow);

					$table .= '<div '.$subEventData.'><span '.$startDate.checkDt($start_year).'">'.$start_year.'</span>';
					$table .= '-<span '.$endDate.checkDt($end_year).'">'.$end_year.'</span></div><br>';

				}
				$table .= '</td>';
				//Country
				$table .= '<td><div ' .$locationData.' '.$countryData.'><img '.$imageData.' src="'.$country_flag.'" width="30px" /><a '.$addressData.' href="'.$country_url.'" title="'.$country_name.'">' . $country_name. '<a/></div>';
			}else{
				//Second and third country
				if(!$country_flag){
					$table .= ' (<div ' .$locationData.' '.$countryData.'><a '.$addressData.' href="'.$country_url.'" title="'.$country_name.'">' . $country_name. '<a/></div>)';
				}else{
					$table .= '<br /><div ' .$locationData.' '.$countryData.'><img '.$imageData.' src="'.$country_flag.'" width="30px" /><a '.$addressData.' href="'.$country_url.'" title="'.$country_name.'">' . $country_name. '<a/></div>';
				}
			}
			$prev_id = $id_player;
			$second_date = '';
		}
		$table .= '</td></tr></table>';
		return $table;
	} //End create table

/*
 * Generates XML markup, is initialised when
 * the URL query string is output.php?data=xml
 *
 * createXML()
*/

//Create XML
function createXML($conn){

		//Get all player data
		$result = getPlayerData($conn);
		//Instatiate new XML object
		$xml = new SimpleXMLElement('<players/>');
		//Reset prev_id
		$prev_id = '';
		while($row = mysqli_fetch_array($result)){
			extract($row);
			//If previous player id == to new player id
			
			if($prev_id != $id_player){
				//Create new player entry
				$ent = $xml->addChild('player');
				$name = $ent->addChild('name',$full_name);
				$name->addAttribute('player_url',$name_url);
				$dates = $ent->addChild('dates');
				//Get date data
				$innerResult = getDateData($id_player, $conn);
				//Loop through returned data
				while($innerRow = mysqli_fetch_array($innerResult)){
					extract($innerRow);
					$date = $dates->addChild('date');
					$date->addAttribute('notes',$notes);
					$date->addChild('startdate',$start_year);
					$date->addChild('enddate',$end_year);
				}
				//Add country data
				$country = $ent->addChild('countries');
				$cname = $country->addChild('first_country',$country_name);
				$cname->addAttribute('country_url',$country_url);
				$cname->addAttribute('flag',$country_flag);
			}else{
				//Check if country flag is set
				if(!$country_flag){
					//Add country data
					$cname = $country->addChild('second_country',$country_name);
					$cname->addAttribute('country_url',$country_url);
				}else{
					//Add country data + flag
					$cname = $country
					->addChild('third_country',$country_name);
					$cname->addAttribute('country_url',$country_url);
					$cname->addAttribute('flag',$country_flag);
				}
			}
			//Set previous id to current player id
			$prev_id = $id_player;
			//Clear second date
			$second_date = '';
		}
		//Create and echo xml out
		$xml = $xml->asXML();
		return $xml;
	} //End createXML

/*
 * Generates JSON-LD markup, is initialised when
 * the URL query string is output.php?data=jsonld
 *
 * createJson()
*/

//Create JSONLD
function createJson($conn){

		//Get all player data
		$result = getPlayerData($conn);
		//Create json-ld - Begin by defining context and types
		$jsonld = '{"@context": {
					    "event": {
					      "@id": "http://schema.org/Event",
					      "@type": "@id"
					    },
					    "date": {
					      "@id": "http://schema.org/Date",
					      "@type": "@id"
					    },
					       "startdate":{
					      "@id":"http://schema.org/Date",
					      "@type":"http://schema.org/startDate"
					    },
					    "enddate":{
					      "@id":"http://schema.org/Date",
					      "@type":"http://schema.org/endDate"
					    },
					    "place": {
					      "@id": "http://schema.org/Place",
					      "@type": "@id"
					    },
					    "location": {
					      "@id": "http://schema.org/postalAddress",
					      "@type": "http://schema.org/addressLocality"
					    },
					    "name": "http://schema.org/Person",
					    "image": {
					      "@id": "http://schema.org/image"
					    },
					    "homepage": {
					      "@id": "http://schema.org/url",
					      "@type": "@id"
					    }
					  },
					  "event": [{';
		//Clear whitespace to tidy conext string
		$jsonld = preg_replace('/\s+/', '', $jsonld);
		//Reset prev_id
		$prev_id = '';
		while($row = mysqli_fetch_array($result)){
			//Extract returned data
			extract($row);

			if($prev_id != $id_player){
				//If not first player
				if(!empty($prev_id)){
					$jsonld .= '}]},{';
				}
				$jsonld .= '"name":"'.$full_name.'","homepage":"'.$name_url.'",';
				$jsonld .= '"date":[';
				//Get date data
				$innerResult = getDateData($id_player, $conn);
				$i = 1;
				//Loop through returned data
				while($innerRow = mysqli_fetch_array($innerResult)){
					extract($innerRow);
					if($i > 1){
						$jsonld .= ',{"startdate":"'.checkDt($start_year).'"';
					}else{
						$jsonld .= '{"startdate":"'.checkDt($start_year).'"';
					}
					$jsonld .= ',"enddate":"'.checkDt($end_year).'"}';
					$i++;
				}	
				$jsonld .= '],';
				//Set first country
				$jsonld .= '"place":[{"location":"'.$country_name.'",';
				$jsonld .= '"homepage":"'.$country_url.'","image":"'.$country_flag.'"';
			}else{
				//Second and third country
				if(!$country_flag){
					$jsonld .= '},{"location":"'.$country_name.'",';
					$jsonld .= '"homepage":"'.$country_url.'"';
				}else{
					$jsonld .= '},{"location":"'.$country_name.'",';
				    $jsonld .= '"homepage":"'.$country_url.'","image":"'.$country_flag.'"';
				}
			}
			//Set previous id to current player id
			$prev_id = $id_player;
			//clear second date to prevent repeating data
			$second_date = '';
		}
		//Close everything off
		$jsonld .= '}]}]}';
		//Return all json-ld
		return indent($jsonld);
} //End createJSONLD

/*
 * Helper functions
 * checkDt()
 * splitDt()
 * indent()
 *
*/

//Checks the date is formatted correctly for Microformat
function checkDt($date){
	//If date is only 2 digits add 19
	if(strlen($date) == 2){
		$newDate = '19'.$date;
		return $newDate . '-01-01';
	}else{
		return trim($date) . '-01-01';
	}
}

//Splits start date, end date and notes
// Returns an array
function splitDt($dates, $i){
	$endDate = '';
	$notes = '';
	//Split date by - 
	if(strrpos($dates[$i], '-')){
		$a = explode('-',$dates[$i]);
		$startDate = $a[0];
	}else{
		$startDate = $dates[$i];
	}
	//If date[1] isset (end date)
	//Split date and notes
	if(isset($a[1])){
		if(strrpos($a[1], '(')){
			$b = explode('(',$a[1]);
			$endDate = $b[0];
			//Trim trailing )
			$notes = trim(substr($b[1], 0, strrpos($b[1], ')')));
		}else{
			$endDate = $a[1];
		}
	}
	return array($startDate, $endDate, $notes);
}

/**
 * Indents a flat JSON string to make it more human-readable.
 *
 * @param string $json The original JSON string to process.
 *
 * @return string Indented version of the original JSON string.
 *
 * Taken from http://www.daveperrett.com/articles/2008/03/11/format-json-with-php/
 */
function indent($json) {

    $result      = '';
    $pos         = 0;
    $strLen      = strlen($json);
    $indentStr   = '  ';
    $newLine     = "\n";
    $prevChar    = '';
    $outOfQuotes = true;

    for ($i=0; $i<=$strLen; $i++) {

        // Grab the next character in the string.
        $char = substr($json, $i, 1);

        // Are we inside a quoted string?
        if ($char == '"' && $prevChar != '\\') {
            $outOfQuotes = !$outOfQuotes;

        // If this character is the end of an element,
        // output a new line and indent the next line.
        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
            $result .= $newLine;
            $pos --;
            for ($j=0; $j<$pos; $j++) {
                $result .= $indentStr;
            }
        }

        // Add the character to the result string.
        $result .= $char;

        // If the last character was the beginning of an element,
        // output a new line and indent the next line.
        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
            $result .= $newLine;
            if ($char == '{' || $char == '[') {
                $pos ++;
            }

            for ($j = 0; $j < $pos; $j++) {
                $result .= $indentStr;
            }
        }

        $prevChar = $char;
    }

    return $result;
}

?>