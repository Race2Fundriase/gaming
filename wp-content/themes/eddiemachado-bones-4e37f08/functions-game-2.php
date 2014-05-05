<?php

function r2f_action_join()
{
	global $wpdb;
	
	// Check security
	
	// Get Params
	$join_type = $_POST["join_type"];
	$official_charity_name = $_POST["official_charity_name"];
	$profile_name = $_POST["profile_name"];
	$main_contact_name = $_POST["main_contact_name"];
	$telephone_number = $_POST["telephone_number"];
	$email = $_POST["email"];
	$building_no_or_name = $_POST["building_no_or_name"];
	$road_name = $_POST["road_name"];
	$town_city = $_POST["town_city"];
	$county = $_POST["county"];
	$postcode = $_POST["postcode"];
	$country = $_POST["country"];
	$gift_aid = $_POST["gift_aid"];
	$website_address = $_POST["website_address"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($join_type == "charity") {
		if ($official_charity_name == "" || $profile_name == "" || $main_contact_name == "")
			$result["error"] .= "You must enter an official charity name and a profile name and a main contact name.";
	}
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	$user_login = $profile_name;
	$user_email = $email;
	$password = wp_generate_password();
	$errors = wp_create_user( $user_login, $password, $user_email );//register_new_user($user_login, $user_email);
	if ( is_wp_error($errors) ) {
		$result["message"] = "There was an error registering the user $profile_name with email $email.";
		$result["error"] = $errors->get_error_message();
	} else {
		$result["message"] = "User $profile_name with email $email registered OK as $join_type.";
		
		$role = "contributor";
		if ($join_type == "charity") $role = "contributor";
		
		$user_id = $errors;
		wp_update_user( array ( 'ID' => $user_id, 'role' => $role ) ) ;
		
		// add extra fields
		
		add_user_meta( $user_id, 'join_type', $join_type);
		add_user_meta( $user_id, 'first_name', $main_contact_name);
		add_user_meta( $user_id, 'official_charity_name', $official_charity_name);
		add_user_meta( $user_id, 'profile_name', $profile_name);
		add_user_meta( $user_id, 'main_contact_name', $main_contact_name);
		add_user_meta( $user_id, 'telephone_number', $telephone_number);
		add_user_meta( $user_id, 'building_no_or_name', $building_no_or_name);
		add_user_meta( $user_id, 'road_name', $road_name);
		add_user_meta( $user_id, 'town_city', $town_city);
		add_user_meta( $user_id, 'county', $county);
		add_user_meta( $user_id, 'postcode', $postcode);
		add_user_meta( $user_id, 'country', $country);
		add_user_meta( $user_id, 'gift_aid', $gift_aid);
		add_user_meta( $user_id, 'website_address', $website_address);
		
		// Send email
		$data["name"] = $main_contact_name;
		$data["insertusername"] = $user_login;
		$data["insertpassword"] = $password;
		
		if ($join_type == "charity")
			send_html_email($user_email, "Welcome to Race2Fundraise", "CharityRegEmail", $data);
		else
			send_html_email($user_email, "Welcome to Race2Fundraise", "FundraiserRegEmail", $data);
	}
		
	// Return result
	echo json_encode($result);
	
	die();
}

function send_html_email($email, $subject, $email_type, $data) {
	$headers[] = 'From: Race2Fundraise <noreply@race2fundraise.com>';
	$headers[] = 'Content-type: text/html';
	$headers[] = 'Bcc: adge@discobeatsoftware.com';

	$html = file_get_contents($_SERVER['DOCUMENT_ROOT']."/email/$email_type.html");
	
	foreach($data as $key => $value) {
		$html = str_replace("[$key]", $value, $html);
	}

	return wp_mail( $email, $subject, $html, $headers ); 

}

function r2f_action_upsert_race()
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
	$id = $_POST["id"];
	$maxNoOfPlayers = $_POST["maxNoOfPlayers"];
	$raceName = stripslashes_deep($_POST["raceName"]);
	$raceDescription = stripslashes_deep($_POST["raceDescription"]);
	$mapId = $_POST["mapId"];
	$startDate = $_POST["startDate"];
	$startTime = $_POST["startTime"];
	$finishDate = $_POST["finishDate"];
	$finishTime = $_POST["finishTime"];
	$entryPrice = $_POST["entryPrice"];
	$raceTokens = $_POST["raceTokens"];
	$createdBy = $_POST["createdBy"];
	$finishGridX = $_POST["finishGridX"];
	$finishGridY = $_POST["finishGridY"];
	$startGridX = $_POST["startGridX"];
	$startGridY = $_POST["startGridY"];
	$locationDescription = $_POST["locationDescription"];
	$terrainDescription = $_POST["terrainDescription"];
	$weatherDescription = $_POST["weatherDescription"];
	$curDay = $_POST["curDay"];
	$curHour = $_POST["curHour"];
	$paymentMethodEmail = $_POST["paymentMethodEmail"];
	$justGivingCharityId = $_POST["justGivingCharityId"];
	$raceStatus = $_POST["raceStatus"];
	if ($raceStatus == "") $raceStatus = -1;
	$private = $_POST["private"];
	$prizeDesc = $_POST["prizeDesc"];
	$offline = $_POST["offline"];
	$refreshScores = $_POST["refreshScores"];
	
	if (!$offline || $offline == "") $offline = 0;
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($raceName == "") $result["error"] .= "You must enter a race name.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	if ($id == "") {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_races
				( id, maxNoOfPlayers, raceName, raceDescription, mapId, startDate, startTime,
					finishDate, finishTime, entryPrice, createdBy, raceStatus, finishGridX, finishGridY, startGridX, startGridY,
					locationDescription, terrainDescription, weatherDescription, curDay, curHour, paymentMethodEmail, justGivingCharityId,
					private, prizeDesc, offline)
				VALUES ( %d, %d, %s, %s, %d, %s, %s, %s, %s, %f, %d, %d, %d, %d, %d, %d, %s, %s, %s, %d, %d, %s, %s, %d, %s, %d )
			", 
				array(
				$id, $maxNoOfPlayers, $raceName, $raceDescription, $mapId, $startDate, $startTime, $finishDate, $finishTime, $entryPrice, 
				$createdBy, $raceStatus, $finishGridX, $finishGridY, $startGridX, $startGridY,
				$locationDescription, $terrainDescription, $weatherDescription, $curDay, $curHour, $paymentMethodEmail, $justGivingCharityId,
				$private, $prizeDesc, $offline
				) 
		) );
		
		if ($rows == 1) {
			$id = $wpdb->insert_id;
			$result["id"] = $id;
			$result["error"] = "";
			$result["message"] = "A new Race called $raceName was created.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem creating the race.";
		}
		
	} else {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_races
				SET maxNoOfPlayers = %d, raceName = %s, raceDescription = %s, mapId = %d, 
				startDate = %s, startTime = %s, finishDate = %s, finishTime = %s, entryPrice = %f,
				finishGridX = %d, finishGridY = %d, startGridX = %d, startGridY = %d,
				locationDescription = %s, terrainDescription = %s, weatherDescription = %s, curDay = %d, curHour = %d,
				paymentMethodEmail = %s, justGivingCharityId = %s, raceStatus = %d, private = %d, prizeDesc = %s,
				offline = %d, refreshScores = %d
				WHERE id = %d
			", 
				array(
				$maxNoOfPlayers, $raceName, $raceDescription, $mapId, $startDate, $startTime, $finishDate, $finishTime, $entryPrice, 
				$finishGridX, $finishGridY, $startGridX, $startGridY,
				$locationDescription, $terrainDescription, $weatherDescription, $curDay, $curHour,
				$paymentMethodEmail, $justGivingCharityId, $raceStatus, $private, $prizeDesc, $offline,
				$refreshScores,
				$id
				) 
		) );
		
		if ($wpdb->last_error == "" ) {
			$result["error"] = "";
			$result["message"] = "Race '$raceName' was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the race.";
		}
	}
	
	if ($id != "") {
		$wpdb->query( $wpdb->prepare("DELETE FROM r2f_racetokens WHERE raceId = %d", array( $id ) ) );
		for($i=0;$i<count($raceTokens);$i++) {
			$wpdb->query( $wpdb->prepare("INSERT INTO r2f_racetokens (raceId, tokenId) VALUES (%d, %d)", array( $id, $raceTokens[$i] ) ) );
		}
		
		update_LengthInDays($id);
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_upsert_race_options()
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
	$id = $_POST["id"];
	$weather = $_POST["weather"];
	$weatherForecast = $_POST["weatherForecast"];
	$energyRequired = $_POST["energyRequired"];
	$courseAggressiveness = $_POST["courseAggressiveness"];
	$terrain = $_POST["terrain"];
	$courseDistance = $_POST["courseDistance"];
	$speed = $_POST["speed"];
		
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
	
	// Insert or Update
		
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET weather = %d, weatherForecast = %d, energyRequired = %d, courseAggressiveness = %d, 
			terrain = %d, courseDistance = %d, speed = %d
			WHERE id = %d
		", 
			array(
			$weather, $weatherForecast, $energyRequired, $courseAggressiveness, $terrain, $courseDistance, $speed, 
			$id
			) 
	) );
	
	if ($rows == 1) {
		$result["error"] = "";
		$result["message"] = "Race '$id' was updated.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race $id. $rows";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_update_race_startfinish()
{
	global $wpdb;
	
	// Get Params
	$id = $_POST["id"];
	$startGridX = $_POST["startGridX"];
	$startGridY = $_POST["startGridY"];
	$finishGridX = $_POST["finishGridX"];
	$finishGridY = $_POST["finishGridY"];
		
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
	
	// Insert or Update
		
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET startGridX = %d, startGridY = %d, finishGridX = %d, finishGridY = %d
			WHERE id = %d
		", 
			array(
			$startGridX, $startGridY, $finishGridX, $finishGridY,
			$id
			) 
	) );
	
	if ($rows == 1) {
		$result["error"] = "";
		$result["message"] = "Race '$id' was updated.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race $id. $rows";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_update_race_featured()
{
	global $wpdb;
	
	// Get Params
	$id = $_POST["id"];
	$featured = $_POST["featured"];
		
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
	
	// Insert or Update
		
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET featured = %d
			WHERE id = %d
		", 
			array(
			$featured,
			$id
			) 
	) );
	
	if ($rows == 1) {
		$result["error"] = "";
		$result["message"] = "Race '$id' was updated.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race $id. $rows";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_update_race_raceStatus()
{
	global $wpdb;
	
	// Get Params
	$id = $_POST["id"];
	$raceStatus = $_POST["raceStatus"];
		
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
	
	$race = get_race($id);
	$race = $race["rows"][0];
	$oldstatus = $race->raceStatus;
	
	// Insert or Update
		
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_races
			SET raceStatus = %d
			WHERE id = %d
		", 
			array(
			$raceStatus,
			$id
			) 
	) );
	
	if ($rows == 1) {
		$result["error"] = "";
		$result["message"] = "Race '$id' was updated.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race $id. $rows";
	}
	
	if ($raceStatus == 0 && $oldStatus == -1) {
		$user = wp_get_current_user();
		$name = get_user_meta( $user->ID, "main_contact_name", true );
		$join_type = get_user_meta( $user->ID, "join_type", true);
		$data["name"] = $name;
		$data["insertracename"] = $race->raceName;
		$data["inserttokenlimit"] = $race->maxNoOfPlayers;
		$data["linktorace"] = "http://race2fundraise.com/active-race/?raceId=$id";
		
		if ($join_type == "charity")
			send_html_email($user_email, "Race2Fundraise Race Created", "CharityRaceCreated", $data);
		else
			send_html_email($user_email, "Race2Fundraise Race Created", "FundraiserRaceCreated", $data);
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_upsert_racetokens()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change race tokens";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$raceId = $_POST["raceId"];
	$tokenId = $_POST["tokenId"];
	$speed = $_POST["speed"];
	$noOfPitstops = $_POST["noOfPitstops"];
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($raceId == "") $result["error"] .= "You must enter a race id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
		
	$rows = $wpdb->query( $wpdb->prepare( 
		"
			UPDATE r2f_racetokens
			SET speed = %d, noOfPitstops = %d
			WHERE raceId = %d AND tokenId = %d
		", 
			array(
			$speed, $noOfPitstops, $raceId, $tokenId
			) 
	) );
	
	if ($rows == 1) {
		$result["error"] = "";
		$result["message"] = "Race token was updated.";
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race token.";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_racetoken()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$raceId = $_POST["raceId"];
	$tokenId = $_POST["tokenId"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($raceId == "" && $tokenId == "") $result["error"] .= "You must supply a race id and a token id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, raceId, tokenId, speed, noOfPitstops
			FROM r2f_racetokens t
			WHERE raceId = %d AND tokenId = %d
		", 
			array(
				$raceId,
				$tokenId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race token found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the race token.";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_races()
{
	global $wpdb;
	
	$page = $_POST['page']; // get the requested page
	$limit = $_POST['rows']; // get how many rows we want to have into the grid	
	$sidx = $_POST['sidx']; // get index row - i.e. user click to sort
	$sord = $_POST['sord'];
	$raceStatus = $_POST['raceStatus'];
	$q = $_POST['q'];
	$createdBy = $_POST['createdBy'];
	$private = $_POST['private'];
	
	if(!$sidx) $sidx =1;
	if(!$page) $page = 1;
	if(!$start) $start = 0;
	if(!$limit) $limit = 100;
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["results"] = "";
	
	$where = "";
	
	if (isset($raceStatus))
		$where .= " AND raceStatus = $raceStatus";
	if (isset($q) && $q != "")
		$where .= " AND raceName LIKE '%$q%'";
	if (isset($createdBy) && $createdBy != "")
		$where .= " AND createdBy = $createdBy";
	if (isset($private))
		$where .= " AND private = $private";
	
	
	$queryResult = $wpdb->get_results("select `id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, `finishDate`, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY` from `r2f_races` where 1=1$where");

				
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start < 0) $start = 0;
	$queryResult = $wpdb->get_results("select `r2f_races`.`id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, startTime, `finishDate`, finishTime, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY`, mapName, raceStatus, createdBy, mapImageUrl, terrainDescription, locationDescription, weatherDescription from `r2f_races` 
				join `r2f_maps` ON mapId = `r2f_maps`.id where 1=1$where
				LIMIT $start, $limit");
	
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$responce->raceStatus = $raceStatus;
	$i=0;
	foreach($queryResult as $row) {
		$charityName = get_user_meta( $row->createdBy, "official_charity_name", true );
		$playerCount = get_race_player_count($row->id);
		$responce->rows[$i]['id']=$row->id;
		$responce->rows[$i]['cell']=array($row->id,$row->raceName,$row->mapName,$row->raceStatus,
			'<a href="'.site_url().'/create-online-race/?raceId='.$row->id.'">Edit</a>',
			$charityName, $row->startDate, $row->startTime, $row->finishDate, $row->finishTime, $row->mapImageUrl, $row->maxNoOfPlayers, $playerCount);
		$i++;
	}        
	$responce->records = count($responce->rows);
	
	echo json_encode($responce);
	die();
}

function get_race_player_count($raceId)
{
	global $wpdb;
	
	// Check security
	// Public
	

	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT COUNT(*) AS playerCount
			FROM r2f_racecharacters
			WHERE raceId = %d AND status = 1
			GROUP BY raceId
		", 
			array(
				$raceId
			) 
	) );
	
	if ($rows) {
		return $rows[0]->playerCount;
	} else {
		return 0;
	}
}

function r2f_action_get_user_races()
{
	global $wpdb;
	
	$page = $_POST['page']; // get the requested page
	$limit = $_POST['rows']; // get how many rows we want to have into the grid	
	$sidx = $_POST['sidx']; // get index row - i.e. user click to sort
	$sord = $_POST['sord'];
	
	
	if(!$sidx) $sidx =1;
	if(!$page) $page = 1;
	if(!$start) $start = 0;
	if(!$limit) $limit = 100;
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["results"] = "";
	
	$userid = get_current_user_id();
	
		
	$queryResult = $wpdb->get_results("select r2f_races.`id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, `finishDate`, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY`, raceStatus from `r2f_races` 
				join r2f_racecharacters on r2f_races.id = r2f_racecharacters.raceId where playerId = $userid and r2f_racecharacters.status = 1");
			
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start < 0) $start = 0;
	$queryResult = $wpdb->get_results("select `r2f_races`.`id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, startTime, `finishDate`, finishTime, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY`, mapName, raceStatus, createdBy, 
				mapImageUrl, terrainDescription, locationDescription, weatherDescription ,
				tokenName
				from `r2f_races` 
				join `r2f_maps` ON mapId = `r2f_maps`.id join r2f_racecharacters on r2f_races.id = r2f_racecharacters.raceId 
				join r2f_tokens ON r2f_racecharacters.tokenId = r2f_tokens.id
				where playerId = $userid 
				and r2f_racecharacters.status = 1
				LIMIT $start, $limit");
	//print_r($wpdb->last_error);
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;

	$i=0;
	foreach($queryResult as $row) {
		$charityName = get_user_meta( $row->createdBy, "official_charity_name", true );
		$pos = get_leaderboard_pos($row->id, $userid);
		
		$responce->rows[$i]['id']=$row->id;
		$responce->rows[$i]['cell']=
			array(
				$row->id,
				$row->raceName,
				$row->mapName,
				$row->raceStatus,
				'<a href="'.site_url().'/active-race/?raceId='.$row->id.'">View</a>',
				$charityName, 
				$row->startDate, 
				$row->startTime, 
				$row->finishDate, 
				$row->finishTime, 
				$row->mapImageUrl, 
				$row->tokenName, 
				$pos
			);
		$i++;
	}        
	echo json_encode($responce);
	die();
}

function get_param($p) {
	$v = $_POST[$p];
	if (!isset($v)) $v = $_GET[$p];
	return $v;
}

function r2f_action_get_race()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$id = get_param("id");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($id == "") $result["error"] .= "You must supply a race id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			select `r2f_races`.`id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, startTime, `finishDate`, finishTime, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY`, mapName, raceStatus, createdBy, mapImageUrl,
				locationDescription, terrainDescription, weatherDescription, curDay, curHour, featured, justGivingCharityId, lengthInDays, private, 
				prizeDesc, sponserLogoUrl, sponserUrl
				from `r2f_races` 
				join `r2f_maps` ON mapId = `r2f_maps`.id
				WHERE `r2f_races`.`id` = %d
		", 
			array(
				$id
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the race";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_racetokens()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$raceId = $_POST["raceId"];
	
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
			SELECT r2f_racetokens.id, tokenId, tokenName, tokenDescription, tokenImageUrl, tokenTip
			FROM r2f_racetokens
			JOIN r2f_tokens
			ON r2f_racetokens.tokenId = r2f_tokens.id
			WHERE raceId = %d
		", 
			array(
				$raceId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race tokens found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the race tokens";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_charities()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$q = get_param("q");
	$page = get_param('page'); // get the requested page
	$limit = get_param('rows'); // get how many rows we want to have into the grid	
	
	if (!isset($page)) $page = 0;
	if (!isset($limit)) $limit = 100;
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
		
	
	// Select

	if(!isset($q) || $q == "")

		$rows = get_users(array('meta_query' => array(
			array(
				'key' => 'join_type',
				'value' => 'charity',
				'compare' => '='
			)
		)));
	else
		$rows = get_users(array('meta_query' => array(
			array(
				'key' => 'join_type',
				'value' => 'charity',
				'compare' => '='
			),
			array(
				'key' => 'official_charity_name',
				'value' => $q,
				'compare' => 'LIKE'
			)
		)));	
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "charity users found.";
		
		
		
		$i=0;
		$prev = 0;
		foreach($rows as $row) {
			
			$charityName = get_user_meta( $row->data->ID, "official_charity_name", true );
			$row->data->charityName = $charityName;
			
			if ($row->data->ID != $prev) {
				$charities[$i] = $row;
				$i++;
			}
			
			$prev = $row->data->ID;
		}    

		$count = count($charities);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start < 0) $start = 0;
		
		$i = 0;
		$j = 0;
		foreach($charities as $row) {
			
			if ($j >= $start && $i < $limit) {
				$result["rows"][$i] = $row;
				$i++;
			}
			
			$j++;
		}    
		
		$result["total_pages"] = $total_pages;
				
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting charity users";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_charity()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$id = $_POST["id"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($id == "") $result["error"] .= "You must supply a user id.";
	
	// Select
	$user = get_userdata( $id );

	if ($user) {
		$result["error"] = "";
		$result["message"] = "charity user found.";
		
		$user->charityName = get_user_meta( $id, "official_charity_name", true );
		$user->website = get_user_meta( $id, "website_address", true );
		$user->description = get_the_author_meta('description', $id);
		
		$result["user"] = $user;
		
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting charity user";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_fundraiser()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$id = $_POST["id"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($id == "") $result["error"] .= "You must supply a user id.";
	
	// Select
	$user = get_userdata( $id );

	if ($user) {
		$result["error"] = "";
		$result["message"] = "charity user found.";
		
		$user->charityName = get_user_meta( $id, "main_contact_name", true );
		$user->website = get_user_meta( $id, "website_address", true );
		$user->description = get_the_author_meta('description', $id);
		
		$result["user"] = $user;
		
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting fundraiser user";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_get_fundraisers()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$q = get_param("q");
	$page = get_param('page'); // get the requested page
	$limit = get_param('rows'); // get how many rows we want to have into the grid	
	
	if (!isset($page)) $page = 1;
	if (!isset($limit)) $limit = 100;
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
		
	
	// Select
	if(!isset($q) || $q == "")

		$rows = get_users(array('meta_query' => array(
			array(
				'key' => 'join_type',
				'value' => 'fundraiser',
				'compare' => '='
			)
		)));
	else
		$rows = get_users(array('meta_query' => array(
			array(
				'key' => 'join_type',
				'value' => 'fundraiser',
				'compare' => '='
			),
			array(
				'key' => 'main_contact_name',
				'value' => $q,
				'compare' => 'LIKE'
			)
		)));	
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "fundraiser users found.";
		
		$i=0;
		$prev = 0;
		foreach($rows as $row) {
			
			$charityName = get_user_meta( $row->data->ID, "main_contact_name", true );
			$row->data->charityName = $charityName;
			
			if ($row->data->ID != $prev) {
				$charities[$i] = $row;
				$i++;
			}
			
			$prev = $row->data->ID;
		}    

		$count = count($charities);
		if( $count >0 ) {
			$total_pages = ceil($count/$limit);
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages) $page=$total_pages;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		if ($start < 0) $start = 0;
		
		$i = 0;
		$j = 0;
		foreach($charities as $row) {
			
			if ($j >= $start && $i < $limit) {
				$result["rows"][$i] = $row;
				$i++;
			}
			
			$j++;
		}    
		
		$result["total_pages"] = $total_pages;
		
		
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting fundraiser users";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}


  
?>
