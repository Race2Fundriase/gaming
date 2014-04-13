<?php
/*
Template Name: Create Game Four
*/
if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content" class="container grit bot-bg bot-bg-alt clearfix">
	<div class="inner-container wrap">
	<br/>
	<br/>
	<h1 class="highlight">Create Game</h1>
	<form id="create-game" action=""><!--start form-->
					<div class="form-elements">
							<h3><span>Part 4</span></h3>
						 
							<div>
								<label for="startGridX"><span>Start Grid X</span></label>
								<div>
								<input id="startGridX" name="startGridX" type="text" value="" tabindex="12"/>
							</div>
							</div>
							<div>
								<label for="startGridY"><span>Start Grid Y</span></label>
								<div>
								<input id="startGridY" name="startGridY" type="text" value="" tabindex="12"/>
								</div>
							</div>
							<div>
								<label for="finishGridX"><span>Finish Grid X</span></label>
								<div>
								<input id="finishGridX" name="finishGridX" type="text" value="" tabindex="12"/>
								</div>
							</div>
							<div>
								<label for=finishGridY"><span>Finish Grid Y</span></label>
								<div>
								<input id="finishGridY" name="finishGridY" type="text" value="" tabindex="12"/>
								</div>
							</div>
								
						   
					   
					</div>
	</form>
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
	
	
	<div class="text-left signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
	<div class="text-middle signup"><input type="submit" value="START AGAIN" class="btn large" id="startagain"/></div>
	<div class="text-left signup"><div id="feedback" class=""></div></div>
	<div id="paperParentSF" class="boxShadow">
	</div>
	
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<div class="text-left signup"><div id="result" class=""></div></div>
    </div>
</div>
</section>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>