<?php

// R2F Game Engine Code
function add_jQuery_libraries() {
 
	wp_enqueue_style('qtip', get_template_directory_uri()+'/library/css/jquery.qtip.min.css', null, false, false);
	wp_enqueue_style('leaflet', 'http://cdn.leafletjs.com/leaflet-0.6.4/leaflet.css', null, false, false);
 
    // Registering Scripts
    wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('jquery'));
	wp_register_script('jquery-grid-lang-plugin', get_template_directory_uri().'/library/jquery.jqGrid-4.6.0/js/grid.locale-en.js', array('jquery'));
	wp_register_script('jquery-grid-plugin', get_template_directory_uri().'/library/jquery.jqGrid-4.6.0/js/jquery.jqGrid.min.js', array('jquery-grid-lang-plugin'));
	wp_register_script('raphael', get_template_directory_uri().'/library/js/raphael-min.js', array('jquery'));
	wp_register_script('noty', get_template_directory_uri().'/library/js/noty/packaged/jquery.noty.packaged.min.js', array('jquery'));
	wp_register_script('qtip', get_template_directory_uri().'/library/js/libs/jquery.qtip.min.js', array('jquery'));
	wp_register_script('twitter', '//platform.twitter.com/widgets.js', array('jquery'));
	wp_register_script('custom-header', get_stylesheet_directory_uri() . '/library/js/custom-header.js', array('jquery'), '', true);
	wp_register_script('leaflet', 'http://cdn.leafletjs.com/leaflet-0.6.4/leaflet.js', array('jquery'));
	wp_register_script('map', get_stylesheet_directory_uri() . '/library/js/map.js', array('leaflet'));
	
	
    // Enqueueing Scripts to the head section
    wp_enqueue_script('jquery-validation-plugin');
	wp_enqueue_script('jquery-grid-lang-plugin');
	wp_enqueue_script('jquery-grid-plugin');
	wp_enqueue_script('raphael');
	wp_enqueue_script('noty');
	wp_enqueue_script('qtip');
	wp_enqueue_script('twitter');
	wp_enqueue_script('leaflet');
	wp_enqueue_script('map');
	
	wp_enqueue_media();
	
	wp_enqueue_script( 'custom-header' );
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

	$queryResult = $wpdb->get_results("select id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops, tokenTip from `r2f_tokens` LIMIT $start, $limit");
	
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
		$responce->rows[$i]['cell']=array($row->id,$row->tokenName,$row->tokenDescription,$row->tokenImageUrl,$row->tokenTip);
		$i++;
	}        
	echo json_encode($responce);
	die();
}

function r2f_action_purchase_check()
{
	global $wpdb;
	
	$raceId = get_param("raceId");
	$playerId = get_param("playerId");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["result"] = "";

	$item_number = "TOKEN:$raceId-$playerId";
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_transactions
			WHERE item_number = %s AND used = 0
		", 
			array(
				$item_number
			) 
	) );
		
	if (count($rows) >= 1) {
		$result["error"] = "";
		$result["message"] = "Purchase '$item_number' found.";
		$result["result"] = $rows[0];
		$result["id"] = $rows[0]->id;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the purchase.";
	}
	
	echo json_encode($result);
	die();
}

function r2f_action_sub_check()
{
	global $wpdb;
	
	$subId = get_param("subId");
	$userId = get_current_user_id();
		
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["result"] = "";

	$item_number = "SUB:$userId-%";

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_transactions
			WHERE id = %d AND item_number LIKE %s
		", 
			array(
				$subId, $item_number
			) 
	) );
		
	if (count($rows) >= 1) {
		$result["error"] = "";
		$result["message"] = "Sub '$subId' found.";
		$result["result"] = $rows[0];
		$result["id"] = $rows[0]->id;
		
		$qty = explode("-", $rows[0]->item_number);
		
		$result["qty"] = $qty[1];
		
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the sub.";
	}
	
	echo json_encode($result);
	die();
}

function r2f_action_get_purchases()
{
	global $wpdb;
	
	$playerId = get_param("playerId");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["result"] = "";

	$item_number = "TOKEN:%-$playerId";
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_transactions
			WHERE item_number LIKE %s
		", 
			array(
				$item_number
			) 
	) );
		
	if (count($rows) >= 1) {
		$result["error"] = "";
		$result["message"] = "Purchases found.";
		$result["result"] = $rows;
		$result["id"] = $rows[0]->id;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the purchases.";
	}
	
	echo json_encode($result);
	die();
}

function r2f_action_get_subs()
{
	global $wpdb;
	
	$playerId = get_current_user_id();
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	$result["result"] = "";

	$item_number = "SUB:$playerId-%";
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT *
			FROM r2f_transactions
			WHERE item_number LIKE %s
		", 
			array(
				$item_number
			) 
	) );
		
	if (count($rows) >= 1) {
		$result["error"] = "";
		$result["message"] = "Subs found.";
		$result["result"] = $rows;
		$result["id"] = $rows[0]->id;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem getting the subs.";
	}
	
	echo json_encode($result);
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
	$weatherTolerance = $_POST["weatherTolerance"];
	
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
				( id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops, weatherTolerance )
				VALUES ( %d, %s, %s, %s, %d, %d, %d )
			", 
				array(
				$id, $tokenName, $tokenDescription, $tokenImageUrl, $speed, $optimumNoOfPitstops, $weatherTolerance
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
				speed = %d, optimumNoOfPitstops = %d, weatherTolerance = %d
				WHERE id = %d
			", 
				array(
				$tokenName, $tokenDescription, $tokenImageUrl, $speed, $optimumNoOfPitstops, $weatherTolerance,
				$id
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
			SELECT id, tokenName, tokenDescription, tokenImageUrl, speed, optimumNoOfPitstops, weatherTolerance
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
					cellWidth, cellHeight, mapTilesUrl, minZoom, maxZoom, boundaryX, boundaryY, mapOverlayUrl
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

function get_map($id)
{
	global $wpdb;
	
	// Check security
	// Public
	
	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT id, mapName, mapImageUrl, mapWidth, mapHeight, gridWidth, gridHeight, 
					cellWidth, cellHeight, mapTilesUrl, minZoom, maxZoom, boundaryX, boundaryY
			FROM r2f_maps
			WHERE id = %d
		", 
			array(
				$id
			) 
	) );
	
	return $rows[0];
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
	$mapTilesUrl = $_POST["mapTilesUrl"];
	$minZoom = $_POST["minZoom"];
	$maxZoom = $_POST["maxZoom"];
	$boundaryX = $_POST["boundaryX"];
	$boundaryY = $_POST["boundaryY"];
	
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
					cellWidth, cellHeight, mapTilesUrl, minZoom, maxZoom, boundaryX, boundaryY)
				VALUES ( %d, %s, %s, %d, %d, %d, %d, %d, %d, %s, %d, %d, %d, %d )
			", 
				array(
				$id, $mapName, $mapImageUrl, $mapWidth, $mapHeight, $gridWidth, $gridHeight, $cellWidth, $cellHeight, $mapTilesUrl,
				$minZoom, $maxZoom, $boundaryX, $boundaryY
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
				cellWidth = %d, cellHeight = %d,
				mapTilesUrl = %s,
				minZoom = %d, maxZoom = %d, boundaryX = %d, boundaryY = %d
				WHERE id = %d
			", 
				array(
					$mapName, $mapImageUrl, $mapWidth, $mapHeight, $gridWidth, $gridHeight, $cellWidth, $cellHeight, $mapTilesUrl,
					$minZoom, $maxZoom, $boundaryX, $boundaryY,
					$id
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
	if ($mapId == "" && $gridX == "" && $gridY == "") $result["error"] .= "You must supply a mapId, gridX and gridY.";
		
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

function r2f_action_get_mapgrids()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$mapId = get_param("mapId");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($mapId == "") $result["error"] .= "You must supply a mapId.";
		
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
			WHERE mapId = %d
		", 
			array(
				$mapId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "Mapgrid sfound.";
		$result["rows"] = $rows;
		$result["id"] = $mapId;
	} else {
		$result["error"] = $wpdb->last_error;
		$result["message"] = "There was a problem finding the mapgrids.";
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
	if ($mapId == "" && $gridX == "" && $gridY == "") $result["error"] .= "You must enter a map id, grid x and grid y.";
	
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

function upsert_mapgrid($mapId, $gridX, $gridY, $inPlay)
{
	global $wpdb;
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($mapId == "" && $gridX == "" && $gridY == "") $result["error"] .= "You must enter a map id, grid x and grid y.";
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	$row = get_mapgrid($mapId, $gridX, $gridY);
	
	if ($row) $id = $row->id; else $id = "";
	
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
	
	return $id;
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
			SELECT IFNULL(o.id, 0) AS id, %d as mapgridId, t.id AS tokenId, IFNULL(o.value,0) AS value, tokenName, IFNULL(inPlayToken,1) AS inPlayToken
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
			SELECT 0 AS id, %d as mapgridId, t.id AS tokenId, 0 AS value, tokenName, 1 AS inPlayToken
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

function r2f_action_get_mapgridtokenoffsets_bymap()
{
	global $wpdb;
	
	// Check security
	// Public
	
	// Get Params
	$mapId = get_param("mapId");
	$tokenId = get_param("tokenId");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($mapId == "") $result["error"] .= "You must supply a map id.";
		
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Select

	$rows = $wpdb->get_results( $wpdb->prepare( 
		"
			SELECT gridX, gridY, inPlay, inPlayToken
			FROM r2f_mapgrids g
			LEFT JOIN r2f_mapgridtokenoffsets o 
			ON g.id = o.mapgridId
			WHERE mapId = %d AND (tokenId = %d OR tokenId IS NULL)
		", 
			array(
				$mapId,
				$tokenId
			) 
	) );
	
	if ($rows) {
		$result["error"] = "";
		$result["message"] = "mapgridtokenoffsets found.";
		$result["rows"] = $rows;
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
	$inPlayToken = $_POST["inPlayToken"];
	
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
				( id, mapgridId, tokenId, value, inPlayToken )
				VALUES ( %d, %d, %d, %d, %d )
			", 
				array(
				$id, $mapgridId, $tokenId, $value, $inPlayToken
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
				SET value = %d, inPlayToken = %d
				WHERE mapgridId = %d AND tokenId = %d
			", 
				array(
				$value, $inPlayToken, $mapgridId, $tokenId
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

function upsert_mapgridtokenoffset($mapgridId, $tokenId, $value, $inPlayToken)
{
	global $wpdb;
	

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
	
	$mapgridtokenoffset = get_mapgridtokenoffset_bymapgridId($mapgridId, $x, $y, $raceCharacter->tokenId);
	
	if ($mapgridtokenoffset) $id = $mapgridtokenoffset->id; else $id = "";
	
	// Insert or Update
	if ($id == "" || $id == 0) {

		$rows = $wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO r2f_mapgridtokenoffsets
				( id, mapgridId, tokenId, value, inPlayToken )
				VALUES ( %d, %d, %d, %d, %d )
			", 
				array(
				$id, $mapgridId, $tokenId, $value, $inPlayToken
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
				SET value = %d, inPlayToken = %d
				WHERE mapgridId = %d AND tokenId = %d
			", 
				array(
				$value, $inPlayToken, $mapgridId, $tokenId
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
	
	
}

function r2f_action_get_image_url() {

	$file = get_param("file");
	
	$url = wp_get_attachment_url( $file );
	
	$result["url"] = $url;
	
	echo json_encode($result);
	
	die();

}

function r2f_action_bulk_upsert_mapgridtokenoffset()
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
	$mapId = get_param("mapId");
	$fromGridX = get_param("fromGridX");
	$fromGridY = get_param("fromGridY");
	$toGridX = get_param("toGridX");
	$toGridY = get_param("toGridY");
	$tokenId = get_param("tokenId");
	$value = get_param("value");
	$inPlayToken = get_param("inPlayToken");
	
	// Init results
	$result["message"] = "";
	$result["error"] = "";
	$result["id"] = "";
	
	// Validate params
	if ($mapId == "" || $fromGridX == "" || $fromGridY == "" || $toGridX == "" || $toGridY == "" || $tokenId == "") $result["error"] .= "You must enter a map id .";
	
	if ($result["error"] != "") {
		$result["message"] = "There were validation errors.";
		echo json_encode($result);
		die();
	}
	
	// Insert or Update
	for ($x=$fromGridX;$x<=$toGridX;$x++) {
	
		for ($y=$fromGridY;$y<=$toGridY;$y++) {

			$mapgridId = upsert_mapgrid($mapId, $x, $y, 1);
			
			upsert_mapgridtokenoffset($mapgridId, $tokenId, $value, $inPlayToken);
		}
		
	}
	
	// Return result
	echo json_encode($result);
	
	die();
}
  
?>
