<?php
/*
Template Name: Enter Race Part 2
*/
?>

<?php get_header(); ?>
<div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Choose a Route</h1>
								<p style="width: 400px; margin: auto">Click on the map to highlight the route you will take. You must start at the green starting grid position and finish at the red finish grid position</p>                                            
								</div>

                        </div>
                                        
                </div>
        </div>
		<div class="fences wrap"></div>
		
<div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content active">
                <div class="inner-container wrap">
						<form id="enterRaceForm">
								<div class="form-elements">
							
                                                <h3><span>Part 3</span></h3>
												<div class="text-center continue"><input type="submit" value="RANDOM ROUTE" class="btn large" id="random"/></div>
                                                <input name="token" type="hidden" value="a"/>
                                                          <div class="text-left signup"><div id="feedback" class=""></div></div>                              
														<div id="paperParent1">
														</div>                                                
         
                                            <div class="text-center continue"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->

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
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>