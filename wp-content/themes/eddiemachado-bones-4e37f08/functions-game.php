<?php

// R2F Game Engine Code
function add_jQuery_libraries() {
 
    // Registering Scripts
    wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('jquery'));
	wp_register_script('jquery-grid-lang-plugin', get_template_directory_uri().'/library/jquery.jqGrid-4.6.0/js/grid.locale-en.js', array('jquery'));
	wp_register_script('jquery-grid-plugin', get_template_directory_uri().'/library/jquery.jqGrid-4.6.0/js/jquery.jqGrid.min.js', array('jquery-grid-lang-plugin'));
	wp_register_script('raphael', get_template_directory_uri().'/library/js/raphael-min.js', array('jquery'));
	wp_register_script('noty', get_template_directory_uri().'/library/js/noty/packaged/jquery.noty.packaged.min.js', array('jquery'));
	
    // Enqueueing Scripts to the head section
    wp_enqueue_script('jquery-validation-plugin');
	wp_enqueue_script('jquery-grid-lang-plugin');
	wp_enqueue_script('jquery-grid-plugin');
	wp_enqueue_script('raphael');
	wp_enqueue_script('noty');
	
}
 
// Wordpress action that says, hey wait! lets add the scripts mentioned in the function as well.
add_action( 'wp_enqueue_scripts', 'add_jQuery_libraries' );

function r2f_action_get_tokens()
{
	global $wpdb;
	
	$page = $GET['page']; // get the requested page
	$limit = $_GET['rows']; // get how many rows we want to have into the grid	
	$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
	$sord = $_GET['sord'];
	if(!$sidx) $sidx =1;
	if(!$page) $page = 1;
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["results"] = "";

	
		
	$queryResult = $wpdb->get_results("select id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops from `r2f_tokens`");
			
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)

	$queryResult = $wpdb->get_results("select id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops from `r2f_tokens` LIMIT $start, $limit");
	
	//if($queryResult) $result["results"] = $queryResult; else { $result["results"]="[]"; $result["error"] = $wpdb->last_error; }
	//$result["message"] = count($result["results"])." records returned.";
	//echo json_encode($result);
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	foreach($queryResult as $row) {
	//while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row->id;
		$responce->rows[$i]['cell']=array($row->id,$row->tokenName,$row->tokenDescription);
		$i++;
	}        
	echo json_encode($responce);
	die();
}

function r2f_action_upsert_token()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change tokens";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$id = $_POST["id"];
	$tokenName = $_POST["tokenName"];
	$tokenDescription = $_POST["tokenDescription"];
	$tokenImageUrl = $_POST["tokenImageUrl"];
	$speed = $_POST["speed"];
	$optimumNoOfPitstops = $_POST["optimumNoOfPitstops"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($tokenName == "") $result["error"] .= "You must enter a token name.";
	if ($tokenDescription == "") $result["error"] .= "You must enter a token description.";
	if ($tokenImageUrl == "") $result["error"] .= "You must enter a token image URL.";
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	if ($id == "") {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_tokens
				( id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops )
				VALUES ( %d, %s, %s, %s, %d, %d )
			", 
				array(
				$id, $tokenName, $tokenDescription, $tokenImageUrl, $speed, $optimumNoOfPitstops
				) 
		) );
		
		if ($rows == 1) {
			$id = $wpdb->insert_id;
			$result["id"] = $id;
			$result["error"] = "";
			$result["message"] = "A new Token called $tokenName was created.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem creating the token.";
		}
		
	} else {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_tokens
				SET tokenName = %s, tokenDescription = %s, tokenImageUrl = %s,
				speed = %d, optimumNoOfPitstops = %d
				WHERE id = %d
			", 
				array(
				$tokenName, $tokenDescription, $tokenImageUrl, $speed, $optimumNoOfPitstops, $id
				) 
		) );
		
		if ($rows == 1) {
			$result["error"] = "";
			$result["message"] = "Token '$tokenName' was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the token. $rows";
		}
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_token()
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
	if ($id == "") $result["error"] .= "You must supply an id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops
			FROM r2f_tokens
			WHERE id = %d
		", 
			array(
				$id
			) 
	) );
	
	if (count($rows) == 1) {
		$result["error"] = "";
		$result["message"] = "Token '$id' found.";
		$result["result"] = $rows[0];
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the token.";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_maps()
{
	global $wpdb;
	
	$page = $_POST['page']; // get the requested page
	$limit = $_POST['rows']; // get how many rows we want to have into the grid	
	$sidx = $_POST['sidx']; // get index row - i.e. user click to sort
	$sord = $_POST['sord'];
	if(!$sidx) $sidx =1;
	if(!$page) $page = 1;
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["results"] = "";

	
		
	$queryResult = $wpdb->get_results("select id, mapImageUrl, mapName from `r2f_maps`");
			
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start<0) $start = 0;
	$queryResult = $wpdb->get_results("select id, mapName, mapImageUrl from `r2f_maps` LIMIT $start, $limit");
	
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	foreach($queryResult as $row) {
		$responce->rows[$i]['id']=$row->id;
		$responce->rows[$i]['cell']=array($row->id,$row->mapImageUrl,$row->mapName);
		$i++;
	}        
	echo json_encode($responce);
	die();
}

function r2f_action_get_map()
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
	if ($id == "") $result["error"] .= "You must supply an id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, mapName, mapImageUrl, mapWidth, mapHeight, gridWidth, gridHeight, 
					cellWidth, cellHeight
			FROM r2f_maps
			WHERE id = %d
		", 
			array(
				$id
			) 
	) );
	
	if (count($rows) == 1) {
		$result["error"] = "";
		$result["message"] = "Map '$id' found.";
		$result["result"] = $rows[0];
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the map.";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_upsert_map()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change maps";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$id = $_POST["id"];
	$mapName = $_POST["mapName"];
	$mapImageUrl = $_POST["mapImageUrl"];
	$mapWidth = $_POST["mapWidth"];
	$mapHeight = $_POST["mapHeight"];
	$gridWidth = $_POST["gridWidth"];
	$gridHeight = $_POST["gridHeight"];
	$cellWidth = $_POST["cellWidth"];
	$cellHeight = $_POST["cellHeight"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($mapImageUrl == "") $result["error"] .= "You must enter a map image url.";
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	if ($id == "") {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_maps
				( id, mapName, mapImageUrl, mapWidth, mapHeight, gridWidth, gridHeight, 
					cellWidth, cellHeight )
				VALUES ( %d, %s, %s, %d, %d, %d, %d, %d, %d )
			", 
				array(
				$id, $mapName, $mapImageUrl, $mapWidth, $mapHeight, $gridWidth, $gridHeight, $cellWidth, $cellHeight 
				) 
		) );
		
		if ($rows == 1) {
			$id = $wpdb->insert_id;
			$result["id"] = $id;
			$result["error"] = "";
			$result["message"] = "A new Map with $mapName was created.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem creating the map.";
		}
		
	} else {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_maps
				SET mapName = %s, mapImageUrl = %s, mapWidth = %d, mapHeight = %d, 
				gridWidth = %d, gridHeight = %d,
				cellWidth = %d, cellHeight = %d
				WHERE id = %d
			", 
				array(
					$mapName, $mapImageUrl, $mapWidth, $mapHeight, $gridWidth, $gridHeight, $cellWidth, $cellHeight, $id
				) 
		) );
		
		if ($rows == 1) {
			$result["error"] = "";
			$result["message"] = "Map '$mapName' was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the map.";
		}
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_mapgrid()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$mapId = $_POST["mapId"];
	$gridX = $_POST["gridX"];
	$gridY = $_POST["gridY"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($mapId == "" && $gridX = "" && $gridY = "") $result["error"] .= "You must supply a mapId, gridX and gridY.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, mapId, gridX, gridY, inPlay
			FROM r2f_mapgrids
			WHERE mapId = %d AND gridX = %d and gridY = %d
		", 
			array(
				$mapId, $gridX, $gridY
			) 
	) );
	
	if (count($rows) == 1) {
		$result["error"] = "";
		$result["message"] = "Mapgrid found.";
		$result["result"] = $rows[0];
		$result["id"] = $rows[0]->id;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem finding the mapgrid.";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_upsert_mapgrid()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change mapgrids";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$id = $_POST["id"];
	$mapId = $_POST["mapId"];
	$gridX = $_POST["gridX"];
	$gridY = $_POST["gridY"];
	$inPlay = $_POST["inPlay"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
	// Validate params
	if ($mapId == "" && $gridX == "" && $gridY = "") $result["error"] .= "You must enter a map id, grid x and grid y.";
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	if ($id == "") {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_mapgrids
				( id, mapId, gridX, gridY, inPlay )
				VALUES ( %d, %d, %d, %d, %d )
			", 
				array(
				$id, $mapId, $gridX, $gridY, $inPlay
				) 
		) );
		
		if ($rows == 1) {
			$id = $wpdb->insert_id;
			$result["id"] = $id;
			$result["error"] = "";
			$result["message"] = "A new MapGrid with $gridX, $gridY was created.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem creating the mapgrid.";
		}
		
	} else {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_mapgrids
				SET mapId = %d, gridX = %d, gridY = %d, 
				inPlay = %d
				WHERE id = %d
			", 
				array(
				$mapId, $gridX, $gridY, $inPlay, $id
				) 
		) );
		
		if ($rows == 1) {
			$result["error"] = "";
			$result["message"] = "Map Grid $gridX, $gridY was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the map grid.";
		}
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_mapgridtokenoffsets()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$mapgridId = $_POST["mapgridId"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($mapgridId == "") $result["error"] .= "You must supply a map grid id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT IFNULL(o.id, 0) AS id, %d as mapgridId, t.id AS tokenId, IFNULL(o.value,0) AS value, tokenName
			FROM r2f_tokens t
			LEFT JOIN r2f_mapgridtokenoffsets o ON t.id = o.tokenId
			WHERE mapgridId =%d
			OR mapgridId IS NULL 
			ORDER BY tokenName
		", 
			array(
				$mapgridId,
				$mapgridId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "mapgridtokenoffsets found.";
		$result["rows"] = $rows;
	} else {
		$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT 0 AS id, %d as mapgridId, t.id AS tokenId, 0 AS value, tokenName
			FROM r2f_tokens t
			ORDER BY tokenName
			 
		", 
			array(
				$mapgridId
			) 
		) );
		if ($rows) {
			$result["error"] = "";
			$result["message"] = "mapgridtokenoffsets defaults found.";
			$result["rows"] = $rows;
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem find the map grid token offsets.";
		}
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_upsert_mapgridtokenoffset()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change mapgridtokenoffsets";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$id = $_POST["id"];
	$mapgridId = $_POST["mapgridId"];
	$tokenId = $_POST["tokenId"];
	$value = $_POST["value"];
	$i = $_POST["i"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	$result["i"] = $i;
	
	// Validate params
	if ($mapgridId == "" && $tokenId == "") $result["error"] .= "You must enter a mapgrid id and token id.";
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	if ($id == "" || $id == 0) {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_mapgridtokenoffsets
				( id, mapgridId, tokenId, value )
				VALUES ( %d, %d, %d, %d )
			", 
				array(
				$id, $mapgridId, $tokenId, $value
				) 
		) );
		
		if ($rows == 1) {
			$id = $wpdb->insert_id;
			$result["id"] = $id;
			$result["error"] = "";
			$result["message"] = "A new MapGridTokenOffset with $tokenId was created.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem creating the mapgridtokenoffset.";
		}
		
	} else {
	
		$rows = $wpdb->query( $wpdb->prepare( 
			"
				UPDATE r2f_mapgridtokenoffsets
				SET value = %d
				WHERE mapgridId = %d AND tokenId = %d
			", 
				array(
				$value, $mapgridId, $tokenId
				) 
		) );
		
		if ($rows == 1) {
			$result["error"] = "";
			$result["message"] = "Map Grid Token Offset $tokenId was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the map grid token offset. $mapgridId, $tokenId";
		}
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

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
	$errors = register_new_user($user_login, $user_email);
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
		
	}
		
	// Return result
	echo json_encode($result);
	
	die();
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
	$raceName = $_POST["raceName"];
	$raceDescription = $_POST["raceDescription"];
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
	$paymentMethodEmail = $_POST["paymentMethodEmail"];
	$justGivingCharityId = $_POST["justGivingCharityId"];
	$raceStatus = $_POST["raceStatus"];
	if ($raceStatus == "") $raceStatus = 0;
		
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
					locationDescription, terrainDescription, weatherDescription, curDay, paymentMethodEmail, justGivingCharityId, raceStatus)
				VALUES ( %d, %d, %s, %s, %d, %s, %s, %s, %s, %f, %d, %d, %d, %d, %d, %d, %s, %s, %s, %d, %s, %s, %d )
			", 
				array(
				$id, $maxNoOfPlayers, $raceName, $raceDescription, $mapId, $startDate, $startTime, $finishDate, $finishTime, $entryPrice, 
				$createdBy, 0, $finishGridX, $finishGridY, $startGridX, $startGridY,
				$locationDescription, $terrainDescription, $weatherDescription, $curDay, $paymentMethodEmail, $justGivingCharityId, $raceStatus
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
				locationDescription = %s, terrainDescription = %s, weatherDescription = %s, curDay = %d,
				paymentMethodEmail = %s, justGivingCharityId = %s, raceStatus = %d
				WHERE id = %d
			", 
				array(
				$maxNoOfPlayers, $raceName, $raceDescription, $mapId, $startDate, $startTime, $finishDate, $finishTime, $entryPrice, 
				$finishGridX, $finishGridY, $startGridX, $startGridY,
				$locationDescription, $terrainDescription, $weatherDescription, $curDay,
				$paymentMethodEmail, $justGivingCharityId, $raceStatus,
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
			$startGridY, $startGridY, $finishGridX, $finishGridY,
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
	
	if(!$sidx) $sidx =1;
	if(!$page) $page = 1;
	if(!$start) $start = 0;
	if(!$limit) $limit = 100;
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["results"] = "";
	

	
	if (isset($raceStatus))
		$queryResult = $wpdb->get_results("select `id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, `finishDate`, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY` from `r2f_races` where raceStatus = $raceStatus");
	else
		$queryResult = $wpdb->get_results("select `id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, `finishDate`, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY` from `r2f_races`");
			
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)

	if (isset($raceStatus))
		$queryResult = $wpdb->get_results("select `r2f_races`.`id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, startTime, `finishDate`, finishTime, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY`, mapName, raceStatus, createdBy, mapImageUrl, terrainDescription, locationDescription, weatherDescription from `r2f_races` 
				join `r2f_maps` ON mapId = `r2f_maps`.id where raceStatus = $raceStatus
				LIMIT $start, $limit");
	else
		$queryResult = $wpdb->get_results("select `r2f_races`.`id`, `maxNoOfPlayers`, `paymentMethod`, `paymentMethodEmail`, `paymentMethodAdminEmail`, 
				`paymentMethodURL`, `raceName`, `raceDescription`, `mapId`, `startDate`, startTime, `finishDate`, finishTime, `entryPrice`, 
				`startGridX`, `startGridY`, `finishGridX`, `finishGridY`, mapName, raceStatus, createdBy, mapImageUrl, terrainDescription, locationDescription, weatherDescription from `r2f_races` 
				join `r2f_maps` ON mapId = `r2f_maps`.id 
				LIMIT $start, $limit");
	
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$responce->raceStatus = $raceStatus;
	$i=0;
	foreach($queryResult as $row) {
		$charityName = get_user_meta( $row->createdBy, "official_charity_name", true );
	
		$responce->rows[$i]['id']=$row->id;
		$responce->rows[$i]['cell']=array($row->id,$row->raceName,$row->mapName,$row->raceStatus,
			'<a href="'.site_url().'/create-online-race/?raceId='.$row->id.'">Edit</a>',
			$charityName, $row->startDate, $row->startTime, $row->finishDate, $row->finishTime, $row->mapImageUrl, $row->maxNoOfPlayers);
		$i++;
	}        
	echo json_encode($responce);
	die();
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
		$responce->rows[$i]['cell']=array($row->id,$row->raceName,$row->mapName,$row->raceStatus,
			'<a href="'.site_url().'/active-race/?raceId='.$row->id.'">View</a>',
			$charityName, $row->startDate, $row->startTime, $row->finishDate, $row->finishTime, $row->mapImageUrl, $row->tokenName, $pos);
		$i++;
	}        
	echo json_encode($responce);
	die();
}


function r2f_action_get_race()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$id = $_POST["id"];
	
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
				locationDescription, terrainDescription, weatherDescription, curDay, featured, justGivingCharityId from `r2f_races` 
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
			SELECT r2f_racetokens.id, tokenId, tokenName, tokenDescription, tokenImageUrl
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
		$result["message"] = "There was a problem getting the race";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

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
	$id = $_POST["id"];
	$raceId = $_POST["raceId"];
	$tokenId = $_POST["tokenId"];
	$playerId = $_POST["playerId"];
	$joinDate = $_POST["joinDate"];
	$route = $_POST["route"];
	$drivingStyleWeight = $_POST["drivingStyleWeight"];
	$noOfPitStops = $_POST["noOfPitStops"];
	$playerName = $_POST["playerName"];
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $id;
	
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
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem updating the race character.";
	}

	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_upsert_racecharactersScore()
{
	global $wpdb;
	
	// Check security
	if (!is_admin()) { 
		$result["message"] = "You must have admin rights to change scores";
		$result["error"] = "";
		$result["id"] = ""; 
		echo json_encode($result);
		die();
	}
	
	// Get Params
	$id = $_POST["id"];
			
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
	
	$lengthInDays = updateScores($id);
	
	$result["message"] = "Race scores updated.";
	$result["lengthInDays"] = $lengthInDays;
	// Return result
	echo json_encode($result);
	
	die();
}

function updateScores($raceId) {

	global $wpdb;

	// rebuild all daily step scores- obliterate and rebuild for now
	$race = get_race($raceId);
	
	$start = strtotime($race["rows"][0]->startDate);
	$finish = strtotime($race["rows"][0]->finishDate);
	
	if ($date < $start) $date = $start;
	if ($date > $finish) $date = $finish;
	
	$lengthInDays = ceil(abs($finish - $start) / 86400);

	updateRaceLengthInDays($raceId, $lengthInDays);
	
	// for each racecharacter
	$raceCharacters = get_racecharacters($raceId);

	for($rci=0;$rci<count($raceCharacters);$rci++) {
	
		updateScoresForRaceCharacter($raceId, $raceCharacters[$rci], $lengthInDays);
	
	}
	
	return $lengthInDays;
}

function updateScoresForRaceCharacter($raceId, $raceCharacter, $lengthInDays) {

	global $wpdb;

	$score = 0;
	$routes = explode("|",$raceCharacter->route);
	
	clearScoresForRaceCharacter($raceCharacter);
	
	$token = get_token($raceCharacter->tokenId);
	

	for($i=0;$i<count($routes)-1;$i++) {
		
		$explain = "";
		
		$ticks = 10 - $token->speed;
		$explain .= "Speed: $token->speed ($ticks); ";
		
		$xy = explode(",", $routes[$i]);
		$x = $xy[0];
		$y = $xy[1];
		$mapgridtokenoffset = get_mapgridtokenoffset($raceId, $x, $y, $raceCharacter->tokenId);
		$ticks += $mapgridtokenoffset->value * $raceCharacter->drivingStyleWeight;
		$explain .= "Grid Offset: $mapgridtokenoffset->value; Weight: $raceCharacter->drivingStyleWeight ($ticks); ";
				
		$ticks += abs($raceCharacter->noOfPitstops - $token->optimumNoOfPitstops);
		$explain .= "Pitstops: $raceCharacter->noOfPitstops Optimum: $token->optimumNoOfPitstops ($ticks); ";

		insert_racecharacterstepscore($raceCharacter, $i, $ticks, $x, $y, $explain);
	}
	
	update_racecharacterscores($raceId, $raceCharacter, $lengthInDays);
	
	return $r;

}

function update_racecharacterscores($raceId, $raceCharacter, $lengthInDays) {
	global $wpdb;
	
	// Calculate ticks per day
	// Winner ticks (least number of ticks to finish)
	$winner = get_winner($raceId);
	$ticksperday = $winner->ticks / $lengthInDays;

	// For each race character calculate which grid they are on for each day
	// by summing ticks until exceed max for that day
	$scores = get_racecharacterstepsscores($raceCharacter);
	$ticks = 0;
	$day = 0;
	for($i=0;$i<count($scores);$i++) {
		$score = $scores[$i];
		
		while($ticks < $score->ticks) {
			$ticks += $ticksperday;
			$explain = "ticks: $ticks; ticksperday: $ticksperday";
			insert_racecharacterscores($score, $day, $explain);
			$day++;
		}		

		$ticks = $ticks - $score->ticks;

	}
	
}

function insert_racecharacterscores($score, $day, $explain) {
	global $wpdb;

	$rows = $wpdb->query( $wpdb->prepare( 
		"
			INSERT INTO r2f_racecharacterscores
			( id, racecharacterId, day, gridX, gridY, explaination )
			VALUES ( %d, %d, %d, %d, %d, %s )
		", 
			array(
			0, $score->racecharacterId, $day, $score->gridX, $score->gridY, $explain
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
			( id, racecharacterId, step, ticks, gridX, gridY, 
				explaination )
			VALUES ( %d, %d, %d, %f, %d, %d, %s )
		", 
			array(
			0, $raceCharacter->id, $step, $ticks, $x, $y, $explain
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


function get_mapgridtokenoffset($raceId, $x, $y, $tokenId)
{
	global $wpdb;
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_mapgridtokenoffsets.id, mapgridId, tokenId, value
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
			SELECT 0 AS id, 0 as mapgridId, %d AS tokenId, 0 AS value
			 
		", 
			array(
				$tokenId
			) 
		) );
		return $rows[0];
	}
	
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

function r2f_action_get_leaderboard()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$raceId = $_POST["raceId"];
	$day = $_POST["day"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $raceId;
	
	if ($day == "") {
		$race = get_race($raceId);
		$day = $race["rows"][0]->curDay;
	}
	
	// Validate params
	if ($raceId == "" || $day == "") $result["error"] .= "You must supply a race id and a day.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racecharacterscores.id, playerId, playerName,
				((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) AS distance2,
				gridX, gridY, tokenImageUrl, tokenName
			FROM r2f_racecharacterscores
			JOIN r2f_racecharacters 
			ON r2f_racecharacterscores.racecharacterId = r2f_racecharacters.id
			JOIN r2f_races
			ON r2f_racecharacters.raceId = r2f_races.id
			JOIN r2f_tokens
			ON r2f_racecharacters.tokenId = r2f_tokens.id
			WHERE raceId = %d AND day = %d AND r2f_racecharacters.status = 1
			ORDER BY ((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) ASC
		", 
			array(
				$raceId, $day
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race leaderboard found.";
		
		for ($i=0;$i<count($rows);$i++) {
			if ($rows[$i]->playerName == "")
				$rows[$i]->name = get_user_meta($rows[$i]->playerId, 'main_contact_name', true);
			else
				$rows[$i]->name = $rows[$i]->playerName;
		}
		
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the leaderboard";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_products()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$productType = $_POST["productType"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($productType == "") $result["error"] .= "You must supply a product Type.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_products
			WHERE productType = %s
			ORDER BY qty
		", 
			array(
				$productType
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "products found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the products";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}


function get_leaderboard_pos($raceId, $playerId, $day = "")
{
	global $wpdb;
	
	// Check security
	// Public
	
	if ($day == "") {
		$race = get_race($raceId);
		$day = $race["rows"][0]->curDay;
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racecharacterscores.id, playerId, playerName,
				((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) AS distance2,
				gridX, gridY, tokenImageUrl, tokenName
			FROM r2f_racecharacterscores
			JOIN r2f_racecharacters 
			ON r2f_racecharacterscores.racecharacterId = r2f_racecharacters.id
			JOIN r2f_races
			ON r2f_racecharacters.raceId = r2f_races.id
			JOIN r2f_tokens
			ON r2f_racecharacters.tokenId = r2f_tokens.id
			WHERE raceId = %d AND day = %d AND r2f_racecharacters.status = 1
			ORDER BY ((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) ASC
		", 
			array(
				$raceId, $day
			) 
	) );
	
	if ($rows) {
		
		for ($i=0;$i<count($rows);$i++) {
			if ($rows[$i]->playerId == $playerId)
				return $i+1;
		}
		
	} else {
		return $wpdb->last_error;
	}
	
	
	
	die();
}


function r2f_action_token_login()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $raceId;
	
	// Validate params
	if ($username == "" || $password == "") $result["error"] .= "You must supply a username and password.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	$creds = array();
	$creds['user_login'] = $username;
	$creds['user_password'] = $password;
	$creds['remember'] = true;
	$user = wp_signon( $creds, false );
	if ( is_wp_error($user) )
		$result["error"] = $user->get_error_message();
	
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_token_register()
{
	global $wpdb;
	
	// Check security
	
	// Get Params
	$name = $_POST["name"];
	$profile_name = $_POST["profileName"];
	$email = $_POST["email"];
	$building_no_or_name = $_POST["building_no_or_name"];
	$road_name = $_POST["road"];
	$town_city = $_POST["city"];
	$county = $_POST["county"];
	$postcode = $_POST["postcode"];
	$country = $_POST["country"];
	$choosePassword = $_POST["choosePassword"];
	$confirmPassword = $_POST["confirmPassword"];
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($profile_name == "") {
		$result["error"] .= "You must enter a profile name.";
	}
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	$user_login = $profile_name;
	$user_email = $email;
	//$errors = register_new_user($user_login, $user_email);
	
	$user_id = username_exists( $user_name );
	if ( !$user_id and email_exists($user_email) == false ) {
		$user_id = wp_create_user( $user_login, $password, $user_email );
	} else {
		$result["error"] = 'User already exists.';
		$result["message"] = 'User already exists.';
	}
	
	if ( is_wp_error($user_id) ) {
		$result["message"] = "There was an error registering the user $profile_name with email $email.";
		$result["error"] = $user_id->get_error_message();
	} else {
		$result["message"] = "User $profile_name with email $email registered OK.";
		
		// add extra fields
		
		add_user_meta( $user_id, 'first_name', $name);
		add_user_meta( $user_id, 'profile_name', $profile_name);
		add_user_meta( $user_id, 'building_no_or_name', $building_no_or_name);
		add_user_meta( $user_id, 'road_name', $road_name);
		add_user_meta( $user_id, 'town_city', $town_city);
		add_user_meta( $user_id, 'county', $county);
		add_user_meta( $user_id, 'postcode', $postcode);
		add_user_meta( $user_id, 'country', $country);
		
		$creds = array();
		$creds['user_login'] = $user_login;
		$creds['user_password'] = $password;
		$creds['remember'] = true;
		$user = wp_signon( $creds, false );
		
	}
		
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_notify()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	/*if ($raceId == "") $result["error"] .= "You must supply a race id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT r2f_racetokens.id, tokenId, tokenName, tokenDescription, tokenImageUrl
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
		$result["message"] = "race found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the race";
	}
	*/
	// Return result
	echo json_encode($result);
	
	die();
}



add_action('wp_ajax_r2f_action_get_tokens', 'r2f_action_get_tokens');
add_action('wp_ajax_nopriv_r2f_action_get_tokens', 'r2f_action_get_tokens');

add_action('wp_ajax_r2f_action_upsert_token', 'r2f_action_upsert_token');
add_action('wp_ajax_nopriv_r2f_action_upsert_token', 'r2f_action_upsert_token');

add_action('wp_ajax_r2f_action_get_token', 'r2f_action_get_token');
add_action('wp_ajax_nopriv_r2f_action_get_token', 'r2f_action_get_token');

add_action('wp_ajax_r2f_action_get_maps', 'r2f_action_get_maps');
add_action('wp_ajax_nopriv_r2f_action_get_maps', 'r2f_action_get_maps');

add_action('wp_ajax_r2f_action_get_map', 'r2f_action_get_map');
add_action('wp_ajax_nopriv_r2f_action_get_map', 'r2f_action_get_map');

add_action('wp_ajax_r2f_action_upsert_map', 'r2f_action_upsert_map');
add_action('wp_ajax_nopriv_r2f_action_upsert_map', 'r2f_action_upsert_map');

add_action('wp_ajax_r2f_action_get_mapgrid', 'r2f_action_get_mapgrid');
add_action('wp_ajax_nopriv_r2f_action_get_mapgrid', 'r2f_action_get_mapgrid');

add_action('wp_ajax_r2f_action_upsert_mapgrid', 'r2f_action_upsert_mapgrid');
add_action('wp_ajax_nopriv_r2f_action_upsert_mapgrid', 'r2f_action_upsert_mapgrid');

add_action('wp_ajax_r2f_action_get_mapgridtokenoffsets', 'r2f_action_get_mapgridtokenoffsets');
add_action('wp_ajax_nopriv_r2f_action_get_mapgridtokenoffsets', 'r2f_action_get_mapgridtokenoffsets');

add_action('wp_ajax_r2f_action_upsert_mapgridtokenoffset', 'r2f_action_upsert_mapgridtokenoffset');
add_action('wp_ajax_nopriv_r2f_action_upsert_mapgridtokenoffset', 'r2f_action_upsert_mapgridtokenoffset');

add_action('wp_ajax_r2f_action_join', 'r2f_action_join');
add_action('wp_ajax_nopriv_r2f_action_join', 'r2f_action_join');

add_action('wp_ajax_r2f_action_upsert_race', 'r2f_action_upsert_race');
add_action('wp_ajax_nopriv_r2f_action_upsert_race', 'r2f_action_upsert_race');

add_action('wp_ajax_r2f_action_upsert_race_options', 'r2f_action_upsert_race_options');
add_action('wp_ajax_nopriv_r2f_action_upsert_race_options', 'r2f_action_upsert_race_options');

add_action('wp_ajax_r2f_action_upsert_racetokens', 'r2f_action_upsert_racetokens');
add_action('wp_ajax_nopriv_r2f_action_upsert_racetokens', 'r2f_action_upsert_racetokens');

add_action('wp_ajax_r2f_action_get_racetoken', 'r2f_action_get_racetoken');
add_action('wp_ajax_nopriv_r2f_action_get_racetoken', 'r2f_action_get_racetoken');

add_action('wp_ajax_r2f_action_get_races', 'r2f_action_get_races');
add_action('wp_ajax_nopriv_r2f_action_get_races', 'r2f_action_get_races');

add_action('wp_ajax_r2f_action_get_race', 'r2f_action_get_race');
add_action('wp_ajax_nopriv_r2f_action_get_race', 'r2f_action_get_race');

add_action('wp_ajax_r2f_action_get_racetokens', 'r2f_action_get_racetokens');
add_action('wp_ajax_nopriv_r2f_action_get_racetokens', 'r2f_action_get_racetokens');

add_action('wp_ajax_r2f_action_upsert_racecharacters', 'r2f_action_upsert_racecharacters');
add_action('wp_ajax_nopriv_r2f_action_upsert_racecharacters', 'r2f_action_upsert_racecharacters');

add_action('wp_ajax_r2f_action_get_leaderboard', 'r2f_action_get_leaderboard');
add_action('wp_ajax_nopriv_r2f_action_get_leaderboard', 'r2f_action_get_leaderboard');

add_action('wp_ajax_r2f_action_upsert_racecharactersScore', 'r2f_action_upsert_racecharactersScore');
add_action('wp_ajax_nopriv_r2f_action_upsert_racecharactersScore', 'r2f_action_upsert_racecharactersScore');

add_action('wp_ajax_r2f_action_token_login', 'r2f_action_token_login');
add_action('wp_ajax_nopriv_r2f_action_token_login', 'r2f_action_token_login');

add_action('wp_ajax_r2f_action_token_register', 'r2f_action_token_register');
add_action('wp_ajax_nopriv_r2f_action_token_register', 'r2f_action_token_register');

add_action('wp_ajax_r2f_action_get_user_races', 'r2f_action_get_user_races');
add_action('wp_ajax_nopriv_r2f_action_get_user_races', 'r2f_action_get_user_races');

add_action('wp_ajax_r2f_action_get_racecharacter', 'r2f_action_get_racecharacter');
add_action('wp_ajax_nopriv_r2f_action_get_racecharacter', 'r2f_action_get_racecharacter');

add_action('wp_ajax_r2f_action_activate_racecharacter', 'r2f_action_activate_racecharacter');
add_action('wp_ajax_nopriv_r2f_action_activate_racecharacter', 'r2f_action_activate_racecharacter');

add_action('wp_ajax_r2f_action_get_products', 'r2f_action_get_products');
add_action('wp_ajax_nopriv_r2f_action_get_products', 'r2f_action_get_products');

add_action('wp_ajax_r2f_action_update_race_startfinish', 'r2f_action_update_race_startfinish');
add_action('wp_ajax_nopriv_r2f_action_update_race_startfinish', 'r2f_action_update_race_startfinish');

add_action('wp_ajax_r2f_action_update_race_featured', 'r2f_action_update_race_featured');
add_action('wp_ajax_nopriv_r2f_action_update_race_featured', 'r2f_action_update_race_featured');

add_action('wp_ajax_r2f_action_get_featured_races', 'r2f_action_get_featured_races');
add_action('wp_ajax_nopriv_r2f_action_get_featured_races', 'r2f_action_get_featured_races');




function modify_contact_methods($profile_fields) {

	$profile_fields['twitter'] = 'Twitter Username';
	$profile_fields['facebook'] = 'Facebook URL';
	$profile_fields['gplus'] = 'Google+ URL';

	return $profile_fields;

}
add_filter('user_contactmethods', 'modify_contact_methods');

add_action('get_header', 'my_filter_head');

  function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }

 //add columns to User panel list page
function add_user_columns($column) {
    $column['address'] = 'Street Address';
    $column['zipcode'] = 'Zip Code';

    return $column;
}
add_filter( 'manage_users_columns', 'add_user_columns' );

//add the data
function add_user_column_data( $val, $column_name, $user_id ) {
    $user = get_userdata($user_id);

    switch ($column_name) {
        case 'address' :
            return $user->address;
            break;
        default:
    }
    return;
}
add_filter( 'manage_users_custom_column', 'add_user_column_data', 10, 3 );

/**
 * Checks if a particular user has a role. 
 * Returns true if a match was found.
 *
 * @param string $role Role name.
 * @param int $user_id (Optional) The ID of a user. Defaults to the current user.
 * @return bool
 */
function appthemes_check_user_role( $role, $user_id = null ) {
 
    if ( is_numeric( $user_id ) )
	$user = get_userdata( $user_id );
    else
        $user = wp_get_current_user();
 
    if ( empty( $user ) )
	return false;
 
    return in_array( $role, (array) $user->roles );
}

function user_can_edit_race() {

	// need also to do sec check on createdBy
	return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
	
}


$fundraiser = appthemes_check_user_role("contributor");
$charity = appthemes_check_user_role("contributor");


  
?>
