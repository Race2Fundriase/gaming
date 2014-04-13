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
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/Logo-Wooden.gif" alt="" />
                            </div>
                    </div>
                    
            </div>
	</section>
	<div class="wide-fence why wrap"></div>
        
        <section>
	    <div class="container pad-top sand bot-bg-grass">
		<div class="inner-container wrap clearfix">
                    <div>
		    <h1 class="highlight">Active Race</h1>
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
			    <div id="paperParentAR">
			    </div>
			    
			</div>
			
                        <div class="info">
                            <?php if(get_current_user_id() <> 0) { ?>
							<a class="btn large blue" href="<?=site_url()?>/purchase-token/?raceId=<?=$_GET['raceId']?>">Enter Now</a>
							<?php } ?>
							<?php if(get_current_user_id() == 0) { ?>
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

							</div>
                        <!--<img src="<?php echo get_template_directory_uri(); ?>/library/images/active-race-page-test-image.jpg" alt="" />-->
						
                    </div>

                </div> 
	    </div>
	</section>
        
        <section>
            <div class="container grit bot-bg">
                <div class="inner-container wrap clearfix">
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
								<div><span class="highlight">Day:</span><select name="day" id="day"></select></div>
                                <ol class="highlight" id="leaderboard">
								</ol>
                            
                            </div>
                        </div>
                    </div>
                    
                    <aside id="profile-excerpt" class="fivecol last">
                        <div><h3 class="highlight">Chauncy Maples Malawi Trust</h3></div>
                        <p class="highlight">Lorem ipsum dolor sit amet, maiores ornare ac fermentum, imperdiet ut vivamus a, nam lectus at nunc. Quam euismod sem, semper ut potenti pellentespellentesque quisque.</p>
                        <div><br/><p class="highlight">Find out more:</p></div>
                        <div><br/><p class="highlight">Website:<a href="#">www.url.com</a></p></div>
                        <div><p class="highlight">Facebook:<a href="#">www.facebook.com/yourfacebook</a></p></div>
                        <div><p class="highlight">Twitter:<a href="#">www.twitter.com/user</a></p></div>
                        <div class="profile-view"><a class="btn small center" href="#">Profile Page</a></div>
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
			<div class="fourcol first">
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
