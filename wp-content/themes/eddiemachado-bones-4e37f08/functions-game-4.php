<?php

function r2f_action_get_leaderboard_page()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$raceId = get_param("raceId");
	$day = get_param("day");
	$hour = get_param("hour");
	
	$q = get_param("q");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $raceId;
	
	if ($day == "") {
		$race = get_race($raceId);
		$day = $race["rows"][0]->curDay;
		$hour = $race["rows"][0]->curHour;
	}

	if (intval($day) < 0) $day = "0"; 
	
	// Validate params
	if ($raceId == "" || $day == "" || $hour == "") $result["error"] .= "You must supply a race id and a day and an hour.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	

	$rows = $wpdb->get_results( $wpdb->prepare( 
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
		", 
			array(
				$raceId, $day, $hour
			) 
	) );
	
	$count = count($rows);
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "race leaderboard found.";
		
		for ($i=0;$i<count($rows);$i++) {
			if ($rows[$i]->playerName == "")
				$rows[$i]->name = get_user_meta($rows[$i]->playerId, 'main_contact_name', true);
			else
				$rows[$i]->name = $rows[$i]->playerName;
		}
		
		for ($i=0;$i<count($rows);$i++) {
			if (strpos($rows[$i]->name, $q) !== FALSE) {
				// work out what page
			}
			
		}
		
		$result["rows"] = $rows;
		$result["total_pages"] = $total_pages;
		
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the leaderboard";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}


function r2f_action_get_leaderboard()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$raceId = get_param("raceId");
	$day = get_param("day");
	$hour = get_param("hour");
	
	$page = get_param("page");
	$limit = get_param("rows");
	
	$q = get_param("q");
	
	if (!$page) $page = 1;
	if (!$limit) $limit = 10;
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = $raceId;
	
	if ($day == "") {
		$race = get_race($raceId);
		$day = $race["rows"][0]->curDay;
		$hour = $race["rows"][0]->curHour;
	}

	if (intval($day) < 0) $day = "0"; 
	
	
	
	// Validate params
	if ($raceId == "" || $day == "" || $hour == "") $result["error"] .= "You must supply a race id and a day and an hour.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	$where = "";
	if (isset($q) && $q != "") {
		$where = " AND playerName LIKE '%$q%'";
	}
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
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
			WHERE raceId = %d AND day = %d AND hour = %d AND r2f_racecharacters.`status` = 1$where
			ORDER BY ((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) ASC
		", 
			array(
				$raceId, $day, $hour
			) 
	) );
	
	$count = count($rows);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start < 0) $start = 0;
	
	// Select
	$rows = $wpdb->get_results( $wpdb->prepare( 
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
			WHERE raceId = %d AND day = %d AND hour = %d AND r2f_racecharacters.`status` = 1$where
			ORDER BY ((finishGridX - gridX)*(finishGridX - gridX))+((finishGridY - gridY)*(finishGridY - gridY)) ASC
			LIMIT %d, %d
		", 
			array(
				$raceId, $day, $hour, $start, $limit
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
		$result["total_pages"] = $total_pages;
		
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

function get_raceweather($raceId, $day)
{
	global $wpdb;
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_raceweather
			WHERE raceId = %d AND day = %d
			ORDER BY day
		", 
			array(
				$raceId, $day
			) 
	) );
	
	if ($rows)
		return $rows[0];
	else {
		$row["weather"] = 0;
		$row["weatherForecast"] = 0;
		return $row;
	}
}


function r2f_action_get_raceweather()
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
	if ($raceId == "") $result["error"] .= "You must supply a raceId.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_raceweather
			WHERE raceId = %d
			ORDER BY day
		", 
			array(
				$raceId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "raceweather found.";
		$result["rows"] = $rows;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the raceweather";
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
		$password = $choosePassword;
		$user_id = wp_create_user( $user_login, $password, $user_email );
		
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
			
			// Send email
			$data["name"] = $name;
			$data["insertusername"] = $user_login;
			$data["insertpassword"] = $password;
			
			send_html_email($user_email, "Welcome to Race2Fundraise", "PlayerRegEmail", $data);
		}	
	} else {
		$result["error"] = 'User already exists.';
		$result["message"] = 'User already exists.';
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

add_action('wp_ajax_r2f_action_get_mapgrids', 'r2f_action_get_mapgrids');
add_action('wp_ajax_nopriv_r2f_action_get_mapgrids', 'r2f_action_get_mapgrids');

add_action('wp_ajax_r2f_action_upsert_mapgrid', 'r2f_action_upsert_mapgrid');
add_action('wp_ajax_nopriv_r2f_action_upsert_mapgrid', 'r2f_action_upsert_mapgrid');

add_action('wp_ajax_r2f_action_get_mapgridtokenoffsets', 'r2f_action_get_mapgridtokenoffsets');
add_action('wp_ajax_nopriv_r2f_action_get_mapgridtokenoffsets', 'r2f_action_get_mapgridtokenoffsets');

add_action('wp_ajax_r2f_action_get_mapgridtokenoffsets_bymap', 'r2f_action_get_mapgridtokenoffsets_bymap');
add_action('wp_ajax_nopriv_r2f_action_get_mapgridtokenoffsets_bymap', 'r2f_action_get_mapgridtokenoffsets_bymap');

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

add_action('wp_ajax_r2f_action_get_charities', 'r2f_action_get_charities');
add_action('wp_ajax_nopriv_r2f_action_get_charities', 'r2f_action_get_charities');

add_action('wp_ajax_r2f_action_get_fundraisers', 'r2f_action_get_fundraisers');
add_action('wp_ajax_nopriv_r2f_action_get_fundraisers', 'r2f_action_get_fundraisers');

add_action('wp_ajax_r2f_action_get_charity', 'r2f_action_get_charity');
add_action('wp_ajax_nopriv_r2f_action_get_charity', 'r2f_action_get_charity');

add_action('wp_ajax_r2f_action_get_fundraiser', 'r2f_action_get_fundraiser');
add_action('wp_ajax_nopriv_r2f_action_get_fundraiser', 'r2f_action_get_fundraiser');

add_action('wp_ajax_r2f_action_upsert_raceweather', 'r2f_action_upsert_raceweather');
add_action('wp_ajax_nopriv_r2f_action_upsert_raceweather', 'r2f_action_upsert_raceweather');

add_action('wp_ajax_r2f_action_get_raceweather', 'r2f_action_get_raceweather');
add_action('wp_ajax_nopriv_r2f_action_get_raceweather', 'r2f_action_get_raceweather');

add_action('wp_ajax_r2f_action_update_race_raceStatus', 'r2f_action_update_race_raceStatus');
add_action('wp_ajax_nopriv_r2f_action_update_race_raceStatus', 'r2f_action_update_race_raceStatus');

add_action('wp_ajax_r2f_action_bulk_upsert_mapgridtokenoffset', 'r2f_action_bulk_upsert_mapgridtokenoffset');
add_action('wp_ajax_nopriv_r2f_action_bulk_upsert_mapgridtokenoffset', 'r2f_action_bulk_upsert_mapgridtokenoffset');

add_action('wp_ajax_r2f_action_test', 'r2f_action_test');
add_action('wp_ajax_nopriv_r2f_action_test', 'r2f_action_test');

add_action('wp_ajax_r2f_action_bulk_import', 'r2f_action_bulk_import');
add_action('wp_ajax_nopriv_r2f_action_bulk_import', 'r2f_action_bulk_import');

add_action('wp_ajax_r2f_action_delete_race', 'r2f_action_delete_race');
add_action('wp_ajax_nopriv_r2f_action_delete_race', 'r2f_action_delete_race');

add_action('wp_ajax_r2f_action_get_image_url', 'r2f_action_get_image_url');
add_action('wp_ajax_nopriv_r2f_action_get_image_url', 'r2f_action_get_image_url');

add_action('wp_ajax_r2f_action_update_racesponserLogo', 'r2f_action_update_racesponserLogo');
add_action('wp_ajax_nopriv_r2f_action_update_racesponserLogo', 'r2f_action_update_racesponserLogo');

add_action('wp_ajax_r2f_action_purchase_check', 'r2f_action_purchase_check');
add_action('wp_ajax_nopriv_r2f_action_purchase_check', 'r2f_action_purchase_check');

add_action('wp_ajax_r2f_action_get_subs', 'r2f_action_get_subs');
add_action('wp_ajax_nopriv_r2f_action_get_subs', 'r2f_action_get_subs');

add_action('wp_ajax_r2f_action_sub_check', 'r2f_action_sub_check');
add_action('wp_ajax_nopriv_r2f_action_sub_check', 'r2f_action_sub_check');

add_action('wp_ajax_r2f_action_get_vouchers', 'r2f_action_get_vouchers');
add_action('wp_ajax_nopriv_r2f_action_get_vouchers', 'r2f_action_get_vouchers');

add_action('wp_ajax_r2f_action_upsert_voucher', 'r2f_action_upsert_voucher');
add_action('wp_ajax_nopriv_r2f_action_upsert_voucher', 'r2f_action_upsert_voucher');

add_action('wp_ajax_r2f_action_get_voucher', 'r2f_action_get_voucher');
add_action('wp_ajax_nopriv_r2f_action_get_voucher', 'r2f_action_get_voucher');

add_action('wp_ajax_r2f_action_use_voucher', 'r2f_action_use_voucher');
add_action('wp_ajax_nopriv_r2f_action_use_voucher', 'r2f_action_use_voucher');

add_action('wp_ajax_r2f_action_add_race_maxNoOfPlayers', 'r2f_action_add_race_maxNoOfPlayers');
add_action('wp_ajax_nopriv_r2f_action_add_race_maxNoOfPlayers', 'r2f_action_add_race_maxNoOfPlayers');






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
	$user = wp_get_current_user();
	$raceId = $_GET["raceId"];
	
	$race = get_race($raceId);
	$createdBy = $race["rows"][0]->createdBy;
	
	if (appthemes_check_user_role("administrator")) return true;
	
	if ($createdBy != $user->ID) return false;
	
	// need also to do sec check on createdBy
	return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
	
}

function user_can_bulk_import_race() {

	$user = wp_get_current_user();
	$raceId = $_GET["raceId"];
	
	$race = get_race($raceId);
	$createdBy = $race["rows"][0]->createdBy;
		
	if ($race["rows"][0]->offline != 1) return false;
	if (appthemes_check_user_role("administrator")) return true;
	
	if ($createdBy != $user->ID) return false;
	
	// need also to do sec check on createdBy
	return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");


}

function user_can_enter_race() {
	
	$raceId = $_GET["raceId"];
	$race = get_race($raceId);
	return user_can_enter_race_id($race);
	
}

function get_player_name() {
	$user = wp_get_current_user();

	if ($user->ID) return get_user_meta($user->ID, 'main_contact_name', true);	
	
	return "";
	
}

function user_can_enter_race_id($race) {
	$user = wp_get_current_user();
	
	// Race is 'Active'  - raceStatus == 0
	// Race has not yet started startDate + startTime > now
	// Race max limit has not been exceeded
	// Race is not offline and user not the person who created the game
		
	
	
	if ($race["rows"][0]->offline == 1 && $race["rows"][0]->createdBy != $user->ID) return false;
	if ($race["rows"][0]->raceStatus != 0) return false;
	$rt = strtotime($race["rows"][0]->startDate." ".$race["rows"][0]->startTime);
	$now = time();
	if ($rt < $now) return false;
	
	$playerCount = get_race_player_count($race["rows"][0]->id);
	if ($playerCount >= $race["rows"][0]->maxNoOfPlayers) return false;
	
	return true;
	
}



/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	
	global $user;
	//print_r($user->roles);
	//die();
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return home_url()."/master-admin-dashboard";
		} else if ( in_array( 'contributor', $user->roles ) ) {
			return home_url()."/admin-dashboard";
		} else
			return home_url()."/user-dashboard";
	} else {
		return home_url()."/user-dashboard";
	}
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

$fundraiser = appthemes_check_user_role("contributor");
$charity = appthemes_check_user_role("contributor");

function check_security($pageName) {

	switch ($pageName) {
    case "pagetemplate-admin-dashboard":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-creategamefive":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
    case "pagetemplate-creategamefour":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-creategamethree":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-creategametwo":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-creategameone":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-createofflinegamefive":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
    case "pagetemplate-createofflinegamefour":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-createofflinegamethree":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-createofflinegametwo":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-createofflinegameone":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-editonlinerace":
        return (appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator")) && user_can_edit_race();
        break;
	case "pagetemplate-map-admin":
        return appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-maps-admin":
        return appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-master-dashboard":
        return appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-token-admin":
        return appthemes_check_user_role("administrator");
        break;
	case "pagetemplate-bulkimport":
        return appthemes_check_user_role("contributor") || appthemes_check_user_role("administrator");
        break;		
	}
	return true;
}
 
add_action('wp_logout','go_home');
function go_home(){
  wp_redirect( home_url() );
  exit();
}

function get_url_id() {
$url = $_SERVER["REQUEST_URI"];
$urlparts = explode("/", $url);
$urlId = $urlparts[count($urlparts)-2];
return $urlId;
}
?>
