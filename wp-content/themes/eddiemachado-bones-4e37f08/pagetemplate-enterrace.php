<?php
/*
Template Name: Enter Race
*/
?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content" class="container grit bot-bg bot-bg-alt clearfix">
	<div class="inner-container wrap">
	<br/>
	<br/>
	<h1 class="highlight">Enter Race</h1>
	<p>Trace your route on the map by selecting grid squares. Choose your character and enter the race.</p>
	<div id="viewOptions" class="boxShadow" style="display: none;">
		<h2 class="highlight">View Options</h2>
		<label for="scale" id="scaleLabel">Scale:<input type="text" id="scale" value="0.2"/></label>
		<input type="button" value="Apply" onclick="scale = jQuery('#scale').val(); drawGrid();"/>
	</div>
	<div id="mapOptions" class="boxShadow" style="display: none;">
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
	<div id="cellOptions" class="boxShadow" style="display: none;">
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
	<div id="cellTokenOptions" class="boxShadow" style="display: none;">
		<form id="mapGridTokenOffsetDataForm">
		<h2 class="highlight">Cell Token Offsets</h2>
		<fieldset class="myfields">
		<table id="tokenOffsetResults">
		
		</table>
		<input type="button" value="Apply" id="upsertMapGridTokenOffset"/>
		</fieldset>
		</form>
	</div>
	<div id="chooseCharacter" class="boxShadow">
		<form id="raceTokensDataForm">
       
		<h2 class="highlight">Choose a Character</h2>
		<fieldset class="myfields">
		<div>
			<select id="tokenId" name="tokenId" style="width: 350px">
			</select>
		</div>
		</fieldset>
       
		</form>
	</div>

	
	<div id="cellOptions" class="boxShadow">
		<form id="mapGridDataForm">
		<h2 class="highlight">Character Options</h2>
		<fieldset class="myfields">
		<div><label style="color: black" for="drivingStyleWeight" id="drivingStyleWeightLabel">Driving Style (0-1):</label><input type="text" id="drivingStyleWeight" value=""/></div>
		<div><label style="color: black" for="noOfPitstops" id=noOfPitstopsLabel">No Of Pitstops:</label><input type="text" id="noOfPitstops" value=""/></div>
		</fieldset>
		</form>
	</div>
	
	<div id="chooseRoute" class="boxShadow">
	<h2 class="highlight">Choose a Route</h2>
	<p>Click on the map to highlight the route you will take. You must start at the green starting grid position and finish at the red finish grid position</p>
	</div>
	<div class="text-left signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
	<div class="text-left signup"><div id="feedback" class=""></div></div>
	<div id="paperParent1" class="boxShadow">
	</div>
	
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<div class="text-left signup"><div id="result" class=""></div></div>
    </div>
</div>
</section>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>