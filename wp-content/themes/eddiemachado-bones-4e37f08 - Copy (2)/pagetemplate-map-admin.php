<?php
/*
Template Name: Map Admin
*/
?>

<?php get_currentuserinfo(); if (!current_user_can('publish_posts')) die("Access denied");?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content">
	<br/>
	<br/>
	<h1 class="highlight">Map Setup</h1>
	<p>Setup a new map and it's attributes from this page. You can assign each grid as 'In Play' or not, and assign Token attributes to each grid which will affect movement of a token through that grid square.</p>
	<div id="viewOptions" class="boxShadow">
		<h2 class="highlight">View Options</h2>
		<label for="scale" id="scaleLabel">Scale:<input type="text" id="scale" value="0.2"/></label>
		<input type="button" value="Apply" onclick="scale = jQuery('#scale').val(); drawGrid();"/>
	</div>
	<h2  class="highlight" id="mapOptionsTitle">Map Options</h2>
	<div id="mapOptions" class="boxShadow">
		<form id="mapDataForm">
		<fieldset class="myfields">
		<div><label for="mapId" id="mapIdLabel">Map Id:</label><input type="text" id="mapId" value=""/></div>
		<div><label for="mapName" id="mapNameLabel">Map Name:</label><input type="text" id="mapName" value=""/></div>
		<div><label for="mapImageUrl" id="mapImageUrlLabel">Map Image URL:</label><input type="text" id="mapImageUrl" value=""/></div>
		<div><label for="mapWidth" id="mapWidthLabel">Map Width:</label><input type="text" id="mapWidth" value=""/></div>
		<div><label for="mapHight" id="mapHeightLabel">Map Height:</label><input type="text" id="mapHeight" value=""/></div>
		<div><label for="gridWidth" id="gridWidthLabel">Map Grid Width:</label><input type="text" id="gridWidth" value=""/></div>
		<div><label for="gridHeight" id="gridHeightLabel">Map Grid Height:</label><input type="text" id="gridHeight" value=""/></div>
		<div><label for="cellWidth" id="cellWidthLabel">Map Cell Width:</label><input type="text" id="cellWidth" value=""/></div>
		<div><label for="cellHeight" id="cellHeightLabel">Map Cell Height:</label><input type="text" id="cellHeight" value=""/></div>
		<input type="button" value="Apply" id="upsertMap"/>
		</fieldset>
		</form>
	</div>
	<div id="cellOptions" class="boxShadow">
		<form id="mapGridDataForm">
		<h2 class="highlight">Cell Options</h2>
		<fieldset class="myfields">
		<div><label for="mapgridId" id="mapgridIdLabel">Map Grid Id:</label><input type="text" id="mapgridId" value=""/></div>
		<div><label for="gridX" id="gridXLabel">Grid X:</label><input type="text" id="gridX" value="" readonly/></div>
		<div><label for="gridY" id="gridYLabel">Grid Y:</label><input type="text" id="gridY" value="" readonly/></div>
		<div><label for="inPlay" id="inPlayLabel">In Play (1=Yes, 0=No)?:</label><input type="text" id="inPlay" value=""/></div>
		<input type="button" value="Apply" id="upsertMapGrid"/>
		</fieldset>
		</form>
	</div>
	<div id="cellTokenOptions" class="boxShadow">
		<form id="mapGridTokenOffsetDataForm">
		<h2 class="highlight">Cell Token Offsets</h2>
		<fieldset class="myfields">
		<table id="tokenOffsetResults">
		
		</table>
		<input type="button" value="Apply" id="upsertMapGridTokenOffset"/>
		</fieldset>
		</form>
	</div>
	<div id="paperParent" class="boxShadow">
	</div>
	<div id="result" class="boxShadow"></div>
</div>
</section>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>