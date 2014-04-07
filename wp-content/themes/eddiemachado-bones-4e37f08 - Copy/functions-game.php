<?php

// R2F Game Engine Code
function add_jQuery_libraries() {
 
    // Registering Scripts
    wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('jquery'));
	wp_register_script('jquery-grid-lang-plugin', get_template_directory_uri().'/library/jquery.jqGrid-4.6.0/js/grid.locale-en.js', array('jquery'));
	wp_register_script('jquery-grid-plugin', get_template_directory_uri().'/library/jquery.jqGrid-4.6.0/js/jquery.jqGrid.min.js', array('jquery-grid-lang-plugin'));
	wp_register_script('raphael', get_template_directory_uri().'/library/js/raphael-min.js', array('jquery'));

    // Enqueueing Scripts to the head section
    wp_enqueue_script('jquery-validation-plugin');
	wp_enqueue_script('jquery-grid-lang-plugin');
	wp_enqueue_script('jquery-grid-plugin');
	wp_enqueue_script('raphael');
}
 
// Wordpress action that says, hey wait! lets add the scripts mentioned in the function as well.
add_action( 'wp_enqueue_scripts', 'add_jQuery_libraries' );

function r2f_action_get_tokens()
{
	global $wpdb;
	
	$page = $_GET['page']; // get the requested page
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

	
		
	$queryResult = $wpdb->get_results("select id, tokenName, tokenDescription, tokenImageUrl, weather, weatherForecast, 
			energyRequired, courseAgressiveness, terrain, courseDistance, speed from `r2f_tokens`");
			
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)

	$queryResult = $wpdb->get_results("select id, tokenName, tokenDescription, tokenImageUrl, weather, weatherForecast, 
			energyRequired, courseAgressiveness, terrain, courseDistance, speed from `r2f_tokens` LIMIT $start, $limit");
	
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
	$weather = $_POST["weather"];
	$weatherForecast = $_POST["weatherForecast"];
	$energyRequired = $_POST["energyRequired"];
	$courseAgressiveness = $_POST["courseAgressiveness"];
	$terrain = $_POST["terrain"];
	$courseDistance = $_POST["courseDistance"];
	$speed = $_POST["speed"];
	
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
				( id, tokenName, tokenDescription, tokenImageUrl, weather, weatherForecast, 
					energyRequired, courseAgressiveness, terrain, courseDistance, speed )
				VALUES ( %d, %s, %s, %s, %d, %d, %d, %d, %d, %d, %d )
			", 
				array(
				$id, $tokenName, $tokenDescription, $tokenImageUrl, $weather, $weatherForecast, $energyRequired, $courseAgressiveness, 
				$terrain, $courseDistance, $speed
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
				weather = %d, weatherForecast = %d,	energyRequired = %d, 
				courseAgressiveness = %d, terrain = %d, courseDistance = %d, speed = %d
				WHERE id = %d
			", 
				array(
				$tokenName, $tokenDescription, $tokenImageUrl, $weather, $weatherForecast, $energyRequired, $courseAgressiveness, 
				$terrain, $courseDistance, $speed, $id
				) 
		) );
		
		if ($rows == 1) {
			$result["error"] = "";
			$result["message"] = "Token '$tokenName' was updated.";
		} else {
			$result["error"] = $wpdb->last_error;
			$result["message"] = "There was a problem updating the token.";
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
			SELECT id, tokenName, tokenDescription, tokenImageUrl, weather, weatherForecast, 
					energyRequired, courseAgressiveness, terrain, courseDistance, speed
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
		$result["message"] = "There was a problem updating the token.";
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}

function r2f_action_get_maps()
{
	global $wpdb;
	
	$page = $_GET['page']; // get the requested page
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

	
		
	$queryResult = $wpdb->get_results("select id, mapImageUrl from `r2f_maps`");
			
	$count = count($queryResult);
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)

	$queryResult = $wpdb->get_results("select id, mapImageUrl from `r2f_maps` LIMIT $start, $limit");
	
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	foreach($queryResult as $row) {
		$responce->rows[$i]['id']=$row->id;
		$responce->rows[$i]['cell']=array($row->id,$row->mapImageUrl);
		$i++;
	}        
	echo json_encode($responce);
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
?>
