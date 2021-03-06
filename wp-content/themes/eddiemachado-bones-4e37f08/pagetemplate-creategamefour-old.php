<?php
/*
Template Name: Create Game Four
*/
if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>
    <section>
    <div class="container sand bot-bg clearfix nav-margin">
        <div class="inner-container wrap">
            
	    <div id="logo" class="secondary">
                <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
            </div>
                            
	    <div id="create-race-header">
                <div class="text-center"><h1 class="highlight">Create: Online Game</h1></div>
                    
            </div>                                
	</div>
    </div>
    </section>  
    
    <div class="fences wrap"></div>
	
    <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
            <div class="inner-container wrap">		 
			   <div id="tabs">
			   <ul id="tab_control" class="tab_control center">
			<li><a href="#" id="startA" class="btn btn-blue large active">Start</a></li>
			<li><a href="#" id="finishA" class="btn large">Finish</a></li>
		    </ul>
					<div class="tabbed_content active">
					   
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
						</div>
					</div><!--End of tab-->
			
					<div class="tabbed_content">
						 <div class="form-elements">
						    <h3><span>Part 4</span></h3>
							<div>
								<label for="finishGridX"><span>Finish Grid X</span></label>
								<div>
								<input id="finishGridX" name="finishGridX" type="text" value="" tabindex="12"/>
								</div>
							</div>
							<div>
								<label for="finishGridY"><span>Finish Grid Y</span></label>
								<div>
								<input id="finishGridY" name="finishGridY" type="text" value="" tabindex="12"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--End Inner Container -->
			
         	<div id="paperParentSF" class="boxShadow"></div>
			
		<div class="text-left signup"><div id="result" class=""></div></div>
		<div class="text-center signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
		<div class="text-center signup"><input type="submit" value="START AGAIN" class="btn large" id="startagain"/></div>
				

	
		</div><!--End Form Elements-->



	
	
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