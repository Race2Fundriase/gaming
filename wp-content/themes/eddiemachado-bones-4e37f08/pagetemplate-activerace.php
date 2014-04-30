<?php
/*
Template Name: Active Race
*/
?>

<?php get_header(); ?>
        <section>
            <div class="slider secondary clearfix">
                    
                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/slide1.jpg" alt=""/>
                    
                    <div class="inner-slider wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                    </div>
                    
            </div>
	</section>
	<div class="wide-fence why wrap"></div>
        
        <section>
	    <div class="container pad-top sand bot-bg-grass">
		<div class="inner-container wrap clearfix">
                    <div>
		    <h1 class="highlight" id="pageTitle">Active Race</h1>
                    </div>
                    
                    <div id="active-race-header">
			
                        <div id="other-search">
                            <?php $search_text = "Search Races"; ?> 
                            <form method="get" id="racesearch"  action=""> 
                                
                                <input type="text" value="<?php echo $search_text; ?>"  
                                name="race-s" id="race-s"  
                                onblur="if (this.value == '')  
                                {this.value = '<?php echo $search_text; ?>';}"  
                                onfocus="if (this.value == '<?php echo $search_text; ?>')  
                                {this.value = '';}" /> 
                                
                                <input type="hidden" id="racesearchsubmit" /> 
                            </form>
			</div>
			
			<div class="stretchy">
			    <div id="frame"></div>
			    <div id="paperParentAR"></div>
			</div>
			
                        <div class="info">
							<?php if(get_current_user_id() <> 0 && user_can_bulk_import_race()) { ?>
							<a class="btn large blue" href="<?=site_url()?>/bulk-import/?raceId=<?=$_GET['raceId']?>">Bulk Import</a>
							<?php } ?>
                            <?php if(get_current_user_id() <> 0 && user_can_enter_race()) { ?>
							<a class="btn large blue" href="<?=site_url()?>/purchase-token/?raceId=<?=$_GET['raceId']?>">Enter Now</a>
							<?php } ?>
							<?php if(get_current_user_id() == 0 && user_can_enter_race()) { ?>
							<a class="btn large blue" href="<?=site_url()?>/token-join">Enter Now</a>
							<?php } ?>
							<?php if(user_can_edit_race()) { ?>
							<br/><a class="btn large blue" href="<?=site_url()?>/edit-online-race/?raceId=<?=$_GET['raceId']?>">Edit Race</a>
							<?php } ?>
                            <div class="headings"><p class="highlight">Start</p><p class="highlight">Finish</p>
							<div id="scaleSlider" style="padding-left: 200px">
								<input type="text" name="mapScale" id="mapScale" value="0.2" data-slider-highlight="true" data-slider-theme="control" data-slider="true"/>
								<div class="status">
									<p class="left-status">Zoom Out</p><p class="right-status">Zoom In</p>
								 </div>
							</div>

							</div>
                            <div class="dates"><time id="startDate" datetime="" class="highlight"></time><time id="finishDate" datetime="" class="highlight"></time></div>
							<div class="dates"><time class="highlight" id="startTime"></time><time class="highlight" id="finishTime"></time></div>

							</div>
                        <!--<img src="<?php echo get_template_directory_uri(); ?>/library/images/active-race-page-test-image.jpg" alt="" />-->
						
                    </div>

                </div> 
	    </div>
	</section>
        
        <section>
            <div class="container grit bot-bg">
                <div class="inner-container wrap clearfix">
				<h1 class="winner" id="winbanner" style="display:none">WINNER:<span class="name" id="winnerName">

				</span> with the <span class="vehicle" id="winnerTokenName"></span>
				<?php if(user_can_edit_race()) { ?>
					<a href="" id="winnderDetails">More Details</a>
				<?php } ?>
				</h1>
                    <div class="fivecol first">
                        <h2 class="highlight" id="raceName"></h2>
                        
                        <div id="race-data">
                            <p class="highlight" id="raceDescription"></p>
                            <dl class="conditions">
                                <!--Removing closing /dt closes the gap between inline elements valid HTML5-->
                                <dt>Location:
                                <dd id="mapName"></dd>
                                
                            </dl>
                            <p class="highlight" id="prize">Prize:</p>
                            
                            <div class="characters clearfix">
                                
                            <div><h3 class="highlight">Characters Available</h3></div>
								<div id="charactersResults">
								</div>
                            </div>
                            
                            <div class="leaderboard clearfix">
                                <div><h3 class="highlight">Leaderboard</h3></div>
								<div style="display:none"><span class="highlight">Day:</span><select name="day" id="day"></select></div>
								<div style="display:none"><span class="highlight">Hour:</span>
								<select name="hour" id="hour">
									<option value="0">1</option>
									<option value="1">2</option>
									<option value="2">3</option>
									<option value="3">4</option>
									<option value="4">5</option>
									<option value="5">6</option>
									<option value="6">7</option>
									<option value="7">8</option>
									<option value="8">9</option>
									<option value="9">10</option>
									<option value="10">11</option>
									<option value="11">12</option>
									<option value="12">13</option>
									<option value="13">14</option>
									<option value="14">15</option>
									<option value="15">16</option>
									<option value="16">17</option>
									<option value="17">18</option>
									<option value="18">19</option>
									<option value="19">20</option>
									<option value="20">21</option>
									<option value="21">22</option>
									<option value="22">23</option>
									<option value="23">24</option>
								</select></div>
                                <ul class="highlight" id="leaderboard">
								</ul>
								<div id="pagerDiv" style="width: 500px; margin: auto">
								<input type="submit" id="prev" class="btn small" value="PREVIOUS"  >
								<div id="pager" style="width: 200px; margin:auto; display: inline;" class="highlight"></div>
								<input type="submit" id="next" class="btn small" value="NEXT" >
								</div>
                            </div>
                        </div>
                    </div>
                    
                    <aside id="profile-excerpt" class="fivecol last">
                        <div><h3 class="highlight" id="charityProfileName"></h3></div>
                        <p class="highlight" id="charityProfileDesc"></p>
                        <div><br/><p class="highlight">Find out more:</p></div>
                        <div><br/><p class="highlight">Website:<a href="#" id="charityProfileWebsite"></a></p></div>
                    </aside>
					<?php if (appthemes_check_user_role("administrator")) {?>
					<div id="featureracediv">
						Featured Race? <input type="checkbox" name="featured" id="featured"/>
					</div>
					<?php } ?>
                </div>
            </div>
			
        </section>
		<div id="templateDiv" style="display: none">
			<div class="fourcol" id="token_{index}">
				<img src="{image}" alt="" />
				<br/>
				<p class="highlight">{tokenName}</p>
			</div>
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
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>
