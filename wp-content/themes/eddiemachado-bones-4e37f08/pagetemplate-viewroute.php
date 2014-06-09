<?php
/*
Template Name: View Route
*/
?>

<?php get_header(); ?>
<div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Confirmation Screen</h1>
								</div>

                        </div>
                                        
                </div>
        </div>
		<div class="fences wrap"></div>
	<div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content active">
                <div class="inner-container wrap">
						<form id="enterRaceForm">
								<div class="form-elements">
							
                                                 <h3><span>Part 1</span></h3>
                                                
                                                <input name="token" type="hidden" value="a"/>
                                                                                        
                                                <div>
                                                    <label for="playerName"><span>Player Name:</span></label>
                                                    <div>
                                                    <input type="text" name="playerName" id="playerName" value=""/>
                                                    </div>
                                                </div>
												
												<div>
                                                    <label for="playerName"><span>Choose a Character:</span></label>
                                                    <div>
                                                    <select id="tokenId" name="tokenId" style="width: 350px">
														
													</select>
                                                    </div>
                                                </div>
												<div class="clearfix" id="raceTokenResults">
													
												</div>
												<h3><span>Part 2</span></h3>
												
												<div>
                                                    <label for="playerName"><span>Driving Style:</span></label>
                                                    <div><input type="text" id="drivingStyleWeight" value="0.5" data-slider-highlight="true" data-slider-theme="control" data-slider="true"/>
														<div class="status">
															<p class="left-status">Careful</p><p class="right-status">Agressive</p>
														</div>
													</div>
                                                </div>
												<div>
                                                    <label for="playerName"><span>Pitstops:</span></label>
                                                    <div><input type="text" id="noOfPitstops" value="1" data-slider-highlight="true" data-slider-theme="control" data-slider="true" data-slider-range="1,10"/>
														<div class="status">
															<p class="left-status">Fewer Pitsops</p><p class="right-status">More Pitstops</p>
														</div>
													</div>
                                                </div>
         <div id="paperParent1" class="boxShadow">
						</div>
                                            
						<div class="text-left signup"><div id="feedback" class=""></div></div>
						
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
	
	
	
	
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<div class="text-left signup"><div id="result" class=""></div></div>
    </div>
</div>
</section>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>