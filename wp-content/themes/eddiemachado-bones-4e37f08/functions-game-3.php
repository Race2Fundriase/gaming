<?php

function r2f_action_get_featured_races()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_races.*, mapImageUrl
			FROM r2f_races
			JOIN r2f_maps
			ON r2f_races.mapId = r2f_maps.id
			WHERE featured = 1
		", 
			array(
				$raceId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "featured races found.";
		
		$i=0;
		foreach($rows as $row) {
			$charityName = get_user_meta( $row->createdBy, "official_charity_name", true );
			$row->charityName = $charityName;
			$result["rows"][$i] = $row;
			
			$i++;
		}        
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the featured races";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_racecharacter()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$racecharacterId = $_POST["id"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($racecharacterId == "") $result["error"] .= "You must supply a racecharacter Id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racecharacters.*, tokenName, tokenImageUrl
			FROM r2f_racecharacters
			JOIN r2f_tokens
			ON r2f_racecharacters.tokenId = r2f_tokens.id
			WHERE r2f_racecharacters.id = %d
		", 
			array(
				$racecharacterId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race character found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the race character";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_upsert_racecharacters()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change races";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$id = get_param("id");
	$raceId = get_param("raceId");
	$tokenId = get_param("tokenId");
	$playerId = get_param("playerId");
	$joinDate = get_param("joinDate");
	$route = get_param("route");
	$drivingStyleWeight = get_param("drivingStyleWeight");
	$noOfPitStops = get_param("noOfPitStops");
	$playerName = get_param("playerName");
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	if ($route == "random") $route = get_randomRoute($raceId, $tokenId);
	
	// Validate params
	if ($raceId == "" || $tokenId == "" || $playerId == "") $result["error"] .= "You must enter a race id, token id and player id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	if ($id == "") {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_racecharacters
				( id, raceId, tokenId, playerId, joinDate, route, drivingStyleWeight, noOfPitStops, playerName
					 )
				VALUES ( %d, %d, %d, %d, %s, %s, %f, %d, %s )
			", 
				array(
				$id, $raceId, $tokenId, $playerId, $joinDate, $route, $drivingStyleWeight, $noOfPitStops, $playerName
				) 
		) );
		
		if ($rows == 1) {
			$id = $wpdb->insert_id;
			$result["id"] = $id;
			$result["error"] = "";
			$result["message"] = "A new Race Character $id was created.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem creating the race character.";
		}
		
	} else {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_racecharacters
				SET raceId = %d, tokenId = %d, playerId = %d, joinDate = %s, 
				route = %s, drivingStyleWeight = %f, noOfPitStops = %d, playerName = %s
				WHERE id = %d
			", 
				array(
				$raceId, $tokenId, $playerId, $joinDate, $route, $drivingStyleWeight, $noOfPitStops, $playerName,
				$id
				) 
		) );
		
		if ($rows == 1) {
			$result["error"] = "";
			$result["message"] = "Race Character $id was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the race character.";
		}
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_delete_race()
{
	global $wpdb;
	
		
	// Get Params
	$id = get_param("id");
			
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($id == "") $result["error"] .= "You must enter a race id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Delete
	$raceCharacters = get_racecharacters($id);
	
	for($i=0;$i<count($raceCharacters);$i++) {
		
		clearScoresForRaceCharacter($raceCharacters[$i]);
	
	}

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_racecharacters
			WHERE raceId = %d
		", 
			array(
			$id
			) 
	) );

	
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_racetokens
			WHERE raceId = %d
		", 
			array(
			$id
			) 
	) );
	
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_raceweather
			WHERE raceId = %d
		", 
			array(
			$id
			) 
	) );
	
	
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_races
			WHERE id = %d
		", 
			array(
			$id
			) 
	) );
	
	if ($rows == 1) {
		$id = $wpdb->insert_id;
		$result["id"] = $id;
		$result["error"] = "";
		$result["message"] = "A new Race Character $id was created.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem creating the race character.";
	}
		
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_bulk_import()
{
	global $wpdb;
	
	// Get Params
	$raceId = get_param("raceId");
	$playersCSV = get_param("playersCSV");
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	$race = get_race($raceId);
	$race = $race["rows"][0];
	
	$rows = explode("\n", $playersCSV);
	
	if (count($rows) > $race->maxNoOfPlayers) $result["error"] .= "The number of players exceeds the maximum for this race (".$race->maxNoOfPlayers.")";
	
	// Validate params
	if ($raceId == "" || $playersCSV == "") $result["error"] .= "You must enter a race id and players CSV.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	$inserts = 0;
	$updates = 0;
	
	for($i=0;$i<count($rows);$i++) {
	
		$data = explode(",",$rows[$i]);
	
		

		$rc = get_racecharacter_byname($raceId, $data[0]);
		$token = get_token_byname($data[1]);
		$tokenId = $token->id;
		$playerId = 0;
		$joinDate = date("Y-m-d");
		$route = get_randomRoute($raceId, $tokenId);
		$drivingStyleWeight = $data[2];
		$noOfPitStops = $data[3];
		$playerName = $data[0];
		
		if ($rc) $id = $rc[0]->id; else $id = "";
		
		// Insert or Update
		if ($id == "") {

			$rows2 = $wpdb->query( $wpdb->prepare( 
				"
					INSERT INTO r2f_racecharacters
					( id, raceId, tokenId, playerId, joinDate, route, drivingStyleWeight, noOfPitStops, playerName, status
						 )
					VALUES ( %d, %d, %d, %d, %s, %s, %f, %d, %s, 1 )
				", 
					array(
					$id, $raceId, $tokenId, $playerId, $joinDate, $route, $drivingStyleWeight, $noOfPitStops, $playerName
					) 
			) );
			$inserts++;
			
		} else {
		
			$rows2 = $wpdb->query( $wpdb->prepare( 
				"
					UPDATE r2f_racecharacters
					SET raceId = %d, tokenId = %d, playerId = %d, joinDate = %s, 
					route = %s, drivingStyleWeight = %f, noOfPitStops = %d, playerName = %s
					WHERE id = %d
				", 
					array(
					$raceId, $tokenId, $playerId, $joinDate, $route, $drivingStyleWeight, $noOfPitStops, $playerName,
					$id
					) 
			) );
			$updates++;
		}
		
		
	}
	
	// Return result
	$result["message"] = "Bulk Import Complete - $inserts inserts, $updates updates";
	echo json_encode($result);
	
	die();
}


function r2f_action_test() {
	phpinfo();
}

function get_randomRoute($raceId, $tokenId) {

	global $wpdb;
	
	return "";

	$race = get_race($raceId);
	$race = $race["rows"][0];
	
	$map = get_map($race->mapId);
	
	$startX = $race->startGridX;
	$startY = $race->startGridY;
	$finishX = $race->finishGridX;
	$finishY = $race->finishGridY;

		
	$route = "";
	
	$x = $startX;
	$y = $startY;
	$oldx = -1;
	$oldy = -1;
	
	$tries = 0;
	$tries2 = 0;
	
	while (($x != $finishX || $y != $finishY) && $tries2 < 1000) {
	tryagain:
		$tries++;
		if ($tries > 10) {
			$tries2++;
			$route = "";
			$x = $startX;
			$y = $startY;
			$oldx = -1;
			$oldy = -1;
			$tries = 0;
			
		}
		/*if ($x != $finishX) {
			if (rand(1,10) > 3)
				if ($finishX > $x) $x++; else $x--;
			else
				if ($finishX > $x) $x--; else $x++;
		} else {
			if (rand(1,10) > 3) $x++; 
			if (rand(1,10) > 5) $x--; 
		}
		
		if ($y != $finishY) {
			if (rand(1,10) > 3)
				if ($finishY > $y) $y++; else $y--;
			else
				if ($finishY > $y) $y--; else $y++;
		} else {
		
			if (rand(1,10) > 3) $y++; 
			if (rand(1,10) > 5) $y--; 
		}
		
		
		
		if ($x != $oldx && $y != $oldy)
			if (rand(1,2) == 1) $x = $oldx; else $y = $oldy;
			
		*/
			
		$c = rand(1,4);
		if ($c == 1) $y--;
		if ($c == 2) $y++;
		if ($c == 3) $x++;
		if ($c == 4) $x--;
			
		if ($x < 0) $x = 0;
		if ($y < 0) $y = 0;
		
		if ($x >= $map->gridWidth) $x = $map->gridWidth;
		if ($y >= $map->gridHeight) $y = $map->gridHeight;
		
		//echo("$x,$y|");

		if (strpos($route, "$x,$y|") !== FALSE) {
			//echo("going back on yourself");
			$x = $oldx;
			$y = $oldy;
			goto tryagain;
		}
			
		$mapgridtokenoffset = get_mapgridtokenoffset($raceId, $x, $y, $tokenId);
		
		if ($mapgridtokenoffset && $mapgridtokenoffset->inPlayToken == 0) {
			//echo("mapgridtokenoffset issue");
			$x = $oldx;
			$y = $oldy;
			goto tryagain;
		}
		
		
		$tries = 0;
		
		if ($x != $finishX || $y != $finishY)
			$route .= "$x,$y|";

		$oldx = $x;
		$oldy = $y;
			
	}
	//echo($route);
	
	return $route;
}

function r2f_action_upsert_raceweather()
{
	global $wpdb;
	
	
	// Get Params
	$raceId = $_POST["raceId"];
	$day = $_POST["day"];
	$weather = $_POST["weather"];
	$weatherForecast = $_POST["weatherForecast"];
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($raceId == "" || $day == "" ) $result["error"] .= "You must enter a race id and a day.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_raceweather
			WHERE raceId = %d and day = %d
		", 
			array(
			$raceId, $day
			) 
	) );

	
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			INSERT INTO r2f_raceweather
			( id, raceId, day, weather, weatherForecast
				 )
			VALUES ( %d, %d, %d, %d, %d )
		", 
			array(
			$id, $raceId, $day, $weather, $weatherForecast
			) 
	) );
		
	if ($rows == 1) {
		$id = $wpdb->insert_id;
		$result["id"] = $id;
		$result["error"] = "";
		$result["message"] = "A new Race weather $id was created for day $day.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem creating the race weather.";
	}
		
	
	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_activate_racecharacter()
{
	global $wpdb;
	

	// Get Params
	$id = $_POST["id"];
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($id == "") $result["error"] .= "You must enter a racecharcater id";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
		
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_racecharacters
			SET status = 1
			WHERE id = %d
		", 
			array(
				$id
			) 
	) );
	
	if ($rows == 1) {
		$result["error"] = "";
		$result["message"] = "Race Character $id was updated.";
		
		$racecharacter = get_racecharacter($id);
		$race = get_race($racecharacter->raceId);
		$race = $race["rows"][0];
		
		$data["name"] = $racecharacter->playerName;
		$data["insertracename"] = $race->raceName;
		$data["insertstartdateandtime"] =  $race->startDate." ".$race->startTime;
		$data["insertenddateandtime"] = $race->finishDate." ".$race->finishTime;
		$token = get_token($raceCharacter->tokenId);
		$data["inserttokenname"] = $token->tokenName;
		$data["insertprizeifany"] = $race->PrizeDesc;
		$data["linktorace"] = "http://race2fundraise.com/active-race/?raceId=".$racecharacter->raceId;
		
		send_html_email($user_email, "Race2Fundraise Race Entered", "PlayerRaceEntered", $data);

		
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race character.";
	}
	


	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_upsert_racecharactersScore($raceId)
{
	global $wpdb;
	
	set_time_limit ( 1200 );
	
	
	ob_flush();
	
	// Get Params
	if (!isset($raceId))
		$id = get_param("id");
	else 
		$id = $raceId;
			
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($id == "") $result["error"] .= "You must enter a race id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	updateRaceCurDayHour($id);
	
	$lengthInDays = updateScores($id);
	
	$result["message"] = "Race scores updated.";
	$result["lengthInDays"] = $lengthInDays;
	// Return result
	echo json_encode($result);
	
	//die();
}

function updateScores($raceId) {

	global $wpdb;

	// rebuild all hourly step scores- obliterate and rebuild for now
	$race = get_race($raceId);
	
	$start = strtotime($race["rows"][0]->startDate);
	$finish = strtotime($race["rows"][0]->finishDate);
	
	if ($date < $start) $date = $start;
	if ($date > $finish) $date = $finish;
	
	$lengthInDays = ceil(abs($finish - $start) / 86400) + 1;

	updateRaceLengthInDays($raceId, $lengthInDays);
	
	// for each racecharacter
	// If refreshScores == 0 then do them all
	// else only do new
	if ($race["rows"][0]->refreshScores == 0)
		$raceCharacters = get_racecharacters($raceId);
	else
		$raceCharacters = get_newracecharacters($raceId);

	for($rci=0;$rci<count($raceCharacters);$rci++) {
		echo($raceCharacters[$rci]->id);
		print_r($raceCharacters[$rci]);
		ob_flush();
		updateScoresForRaceCharacter($raceId, $raceCharacters[$rci], $lengthInDays, $start);
		echo("<br/>");
	}
	
	updaterefreshScores($raceId, 1);
	
	return $lengthInDays;
}

function update_LengthInDays($raceId) {

	global $wpdb;

	// rebuild all hourly step scores- obliterate and rebuild for now
	$race = get_race($raceId);
	
	$start = strtotime($race["rows"][0]->startDate);
	$finish = strtotime($race["rows"][0]->finishDate);
	
	if ($date < $start) $date = $start;
	if ($date > $finish) $date = $finish;
	
	$lengthInDays = ceil(abs($finish - $start) / 86400) + 1;

	updateRaceLengthInDays($raceId, $lengthInDays);
	
	return $lengthInDays;
}

function updateScoresForRaceCharacter($raceId, $raceCharacter, $lengthInDays, $start) {

	global $wpdb;

	$score = 0;
	$routes = explode("|",$raceCharacter->route);
	
	clearScoresForRaceCharacter($raceCharacter);
	//print_r("cleared scores");
	$token = get_token($raceCharacter->tokenId);
	
	for($i=0;$i<count($routes)-1;$i++) {
		echo(".");
		ob_flush();
		$explain = "";
		
		$ticks = 10 - $token->speed;
		$explain .= "Speed: $token->speed ($ticks); ";
		
		$xy = explode(",", $routes[$i]);
		$x = $xy[0];
		$y = $xy[1];
		$mapgridtokenoffset = get_mapgridtokenoffset($raceId, $x, $y, $raceCharacter->tokenId);
		//$mapgridtokenoffset = 0;
		$ticks += $mapgridtokenoffset->value * $raceCharacter->drivingStyleWeight;
		$explain .= "Grid Offset: $mapgridtokenoffset->value; Weight: $raceCharacter->drivingStyleWeight ($ticks); ";
				
		$ticks += abs($raceCharacter->noOfPitstops - $token->optimumNoOfPitstops);
		$explain .= "Pitstops: $raceCharacter->noOfPitstops Optimum: $token->optimumNoOfPitstops ($ticks); ";

		if ($ticks <= 0) $ticks = 1;
		
		insert_racecharacterstepscore($raceCharacter, $i, $ticks, $x, $y, $explain);
	}
	echo("<br/>");
	update_racecharacterscores($raceId, $raceCharacter, $lengthInDays, $start);
	
	return $r;

}

function update_racecharacterscores($raceId, $raceCharacter, $lengthInDays, $start) {
	global $wpdb;
	echo("<br/>");
	ob_flush();
	// Calculate ticks per hour
	// Winner ticks (least number of ticks to finish)
	$winner = get_winner($raceId);
	$ticksperhour = $winner->ticks / ($lengthInDays * 24);

	if ($ticksperhour == 0) return;
	
	// For each race character calculate which grid they are on for each hour
	// by summing ticks until exceed max for that hour
	$scores = get_racecharacterstepsscores($raceCharacter);
	$ticks = 0;
	$day = 0;
	
	$hour = date("G", $start);
	
	for($i=0;$i<count($scores);$i++) {
		echo(".");
		ob_flush();
		$score = $scores[$i];
		
		while($ticks < $score->ticks) {
			$ticks += $ticksperhour;
			$explain = "ticks: $ticks; ticksperhour: $ticksperhour";
			insert_racecharacterscores($score, $day, $hour, $explain);
			$hour++;
			if ($hour >= 24) {
				$day++;
				$hour = 0;
			}
			echo("$day:$hour;");
		}		

		$ticks = $ticks - $score->ticks;
		
		if ($day > $lengthInDays) break;

	}
	
}

function insert_racecharacterscores($score, $day, $hour, $explain) {
	global $wpdb;

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			INSERT INTO r2f_racecharacterscores
			( id, racecharacterId, day, hour, gridX, gridY )
			VALUES ( %d, %d, %d, %d, %d, %d )
		", 
			array(
			0, $score->racecharacterId, $day, $hour, $score->gridX, $score->gridY
			) 
	) );
	
}

function get_racecharacterstepsscores($raceCharacter) {
	global $wpdb;

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_racecharacterstepscores
			WHERE raceCharacterId = %d
		", 
			array(
				$raceCharacter->id
			) 
	) );
	
	return $rows;
	
}

function get_racesToCRON() {
	global $wpdb;

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_races
			
		"
	) );
	
	return $rows;
	
}

function get_winner($raceId) {

	global $wpdb;
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT racecharacterId, SUM(ticks) AS ticks
			FROM r2f_racecharacters 
			JOIN r2f_racecharacterstepscores
			ON r2f_racecharacters.id = r2f_racecharacterstepscores.racecharacterId
			WHERE r2f_racecharacters.raceId = %d AND r2f_racecharacters.status = 1
			GROUP BY racecharacterId
			ORDER BY SUM(ticks) 
		", 
			array(
				$raceId
			) 
	) );

	return $rows[0];
}

function insert_racecharacterstepscore($raceCharacter, $step, $ticks, $x, $y, $explain) {

	global $wpdb;

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			INSERT INTO r2f_racecharacterstepscores
			( id, racecharacterId, step, ticks, gridX, gridY )
			VALUES ( %d, %d, %d, %f, %d, %d )
		", 
			array(
			0, $raceCharacter->id, $step, $ticks, $x, $y
			) 
	) );

}

function clearScoresForRaceCharacter($raceCharacter) {

	global $wpdb;
	
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_racecharacterstepscores
			WHERE racecharacterId = %d
		", 
			array(
			$raceCharacter->id
			) 
	) );
	
		$rows = $wpdb->query( $wpdb->prepare( 
		"
			DELETE FROM r2f_racecharacterscores
			WHERE racecharacterId = %d
		", 
			array(
			$raceCharacter->id
			) 
	) );

}

function updateRaceLengthInDays($raceId, $lengthInDays) {

	global $wpdb;

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET lengthInDays = %d
			WHERE id = %d
		", 
			array(
			$lengthInDays, $raceId
			) 
	) );
}

function updaterefreshScores($raceId, $refreshScores) {

	global $wpdb;

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET refreshScores = %d
			WHERE id = %d
		", 
			array(
			$refreshScores, $raceId
			) 
	) );
}


function get_racecharacters($raceId)
{
	global $wpdb;
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racecharacters.*
			FROM r2f_racecharacters 
			WHERE r2f_racecharacters.raceId = %d AND r2f_racecharacters.status = 1
		", 
			array(
				$raceId
			) 
	) );
	
	// Return result
	return $rows;
}

function get_racecharacter($id)
{
	global $wpdb;
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racecharacters.*
			FROM r2f_racecharacters 
			WHERE id = %d
		", 
			array(
				$id
			) 
	) );
	
	// Return result
	return $rows;
}

function get_newracecharacters($raceId)
{
	global $wpdb;
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT DISTINCT r2f_racecharacters.*
			FROM r2f_racecharacters 
			LEFT JOIN r2f_racecharacterscores
			ON r2f_racecharacters.id = racecharacterId
			WHERE r2f_racecharacterscores.id IS NULL
			AND r2f_racecharacters.raceId = %d AND r2f_racecharacters.status = 1
		", 
			array(
				$raceId
			) 
	) );
	
	// Return result
	return $rows;
}

function get_racecharacter_byname($raceId, $playerName)
{
	global $wpdb;
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racecharacters.*
			FROM r2f_racecharacters 
			WHERE r2f_racecharacters.raceId = %d AND playerName = %s
		", 
			array(
				$raceId, $playerName
			) 
	) );
	
	// Return result
	return $rows;
}


function get_mapgridtokenoffset($raceId, $x, $y, $tokenId)
{
	global $wpdb;
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_mapgridtokenoffsets.id, mapgridId, tokenId, value, inPlayToken
			FROM r2f_mapgridtokenoffsets
			JOIN r2f_mapgrids
			ON mapgridId = r2f_mapgrids.id
			JOIN r2f_races 
			ON r2f_mapgrids.mapId = r2f_races.mapId
			WHERE gridX = %d AND gridY = %d 
			AND r2f_races.id = %d AND tokenId = %d
		", 
			array(
				$x, $y,
				$raceId, $tokenId
			) 
	) );
	
	if ($rows) {
		return $rows[0];
	} else {
		$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT 0 AS id, 0 as mapgridId, %d AS tokenId, 0 AS value, 1 AS inPlayToken
			 
		", 
			array(
				$tokenId
			) 
		) );
		return $rows[0];
	}
	
}

function get_mapgridtokenoffset_bymapgridId($mapgridId, $x, $y, $tokenId)
{
	global $wpdb;
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_mapgridtokenoffsets.id, mapgridId, tokenId, value
			FROM r2f_mapgridtokenoffsets
			WHERE mapgridId = %d AND tokenId = %d
		", 
			array(
				$x, $y,
				$mapgridId, $tokenId
			) 
	) );
	
	return $rows[0];
	
}


function get_mapgrid($mapId, $x, $y)
{
	global $wpdb;
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_mapgrids
			WHERE gridX = %d AND gridY = %d 
			AND mapId = %d
		", 
			array(
				$x, $y,
				$mapId
			) 
	) );
	
	if ($rows)
		return $rows[0];
}


function get_racetoken($raceTokenId)
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($raceTokenId == "") $result["error"] .= "You must supply a race token id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, raceId, tokenId, speed, noOfPitstops
			FROM r2f_racetokens
			WHERE id = %d
		", 
			array(
				$raceTokenId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "racetoken found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem find the race token.";
	}
	
	// Return result
	return $result;
}

function get_token($tokenId)
{
	global $wpdb;
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops
			FROM r2f_tokens
			WHERE id = %d
		", 
			array(
				$tokenId
			) 
	) );
	
	return $rows[0];
}

function get_token_byname($tokenName)
{
	global $wpdb;
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops
			FROM r2f_tokens
			WHERE tokenName = %s
		", 
			array(
				$tokenName
			) 
	) );
	
	return $rows[0];
}


function get_race($raceId)
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($raceId == "") $result["error"] .= "You must supply a race id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_races
			WHERE id = %d
		", 
			array(
				$raceId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem find the race.";
	}
	
	// Return result
	return $result;
}

function updateRaceCurDayHour($raceId) {

	global $wpdb;

	date_default_timezone_set("Europe/London");
	
	$race = get_race($raceId);

	// day is the difference in days from race start to now
	$now = time();
	
    $startDate = strtotime($race["rows"][0]->startDate);
    $datediff = $now - $startDate;
	
    $day = floor($datediff/(60*60*24));
	
	$hour = date("G", $now);
	
	// check limits

	if ($day == $race["rows"][0]->lengthInDays-1) {
		$finishDate = strtotime($race["rows"][0]->finishDate." ".$race["rows"][0]->finishTime);
		$maxhour = date("G", $finishDate);
		if ($hour > $maxhour) $hour = $maxhour;
	}
	
	if ($day > ($race["rows"][0]->lengthInDays-1)) {
		$day = $race["rows"][0]->lengthInDays-1;
		$finishDate = strtotime($race["rows"][0]->finishDate." ".$race["rows"][0]->finishTime);
		$hour = date("G", $finishDate);
	}
	
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET curDay = %d, curHour = %d
			WHERE id = %d
		", 
			array(
			$day, $hour, $raceId
			) 
	) );
	
	// If finish is less than now then game is complete
	$rt = strtotime($race["rows"][0]->finishDate." ".$race["rows"][0]->finishTime);
	
	if ($rt < $now) {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_races
				SET raceStatus = %d
				WHERE id = %d AND raceStatus = 0
			", 
				array(
				1, $raceId
				) 
		) );
		
		// If anything is updated
		if ($rows == 1) {
			$race = $race["rows"][0];
			$name = get_user_meta( $race->createdBy, "main_contact_name", true );
			$join_type = get_user_meta( $race->createdBy, "join_type", true);
			$data["name"] = $name;
			$data["insertracename"] = $race->raceName;
			
			$rows2 = $wpdb->get_results( $wpdb->prepare( 
				"
					SELECT r2f_racecharacterscores.id, playerId, playerName,
						((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) AS distance2,
						gridX, gridY, tokenImageUrl, tokenName, day , hour, raceId
					FROM r2f_racecharacterscores
					JOIN r2f_racecharacters 
					ON r2f_racecharacterscores.racecharacterId = r2f_racecharacters.id
					JOIN r2f_races
					ON r2f_racecharacters.raceId = r2f_races.id
					JOIN r2f_tokens
					ON r2f_racecharacters.tokenId = r2f_tokens.id
					WHERE raceId = %d AND day = %d AND hour = %d AND r2f_racecharacters.`status` = 1
					ORDER BY ((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) ASC
					LIMIT 1
				", 
					array(
						$raceId, $day, $hour, $start, $limit
					) 
			) );
			
			$data["insertwinnersname"] = $rows2[0]->playerName;
			$data["insertaddress"] = get_user_meta( $rows2[0]->playerId, "building_no_or_name", true );
			$data["insertaddress"] .= ",".get_user_meta( $rows2[0]->playerId, "road_name", true );
			$data["insertaddress"] .= ",".get_user_meta( $rows2[0]->playerId, "town_city", true );
			$data["insertaddress"] .= ",".get_user_meta( $rows2[0]->playerId, "county", true );
			$data["insertaddress"] .= ",".get_user_meta( $rows2[0]->playerId, "postcode", true );
			$data["insertaddress"] .= ",".get_user_meta( $rows2[0]->playerId, "country", true );
			
			$data["insertcontactnumber"] = get_user_meta( $rows2[0]->playerId, "telephone_number", true );
			$data["insertemailaddress"] = get_user_meta( $rows2[0]->playerId, "user_email", true );
			
			$data["insertprizeifany"] = $race->prizeDesc;
			
			$data["linktocompletedrace"] = "http://race2fundraise.com/active-race/?raceId=$raceId";
			
			if ($join_type == "charity")
				send_html_email($user_email, "Race2Fundraise Race Completed", "CharityRaceCompleted", $data);
			else
				send_html_email($user_email, "Race2Fundraise Race Completed", "FundraiserRaceCompleted", $data);
		//bookmark
		}
	}
}


  
?>
