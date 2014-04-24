<?php
/*
 Template Name: Create Offline Game Two
 */
 
 if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>
        
            <div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Create: Offline Game</h1></div>
                                
                            </div>
                                        
                    </div>
            </div>
            
             <div class="fences wrap"></div>
             
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
                <div class="inner-container wrap"> 
			                      
					
					<div>
                        <form id="create-game" action=""><!--start form-->
                                <div class="form-elements">
                                                
                                                <h3><span>Part 2</span></h3>
												<input id="maxNoOfPlayers" name="maxNoOfPlayers" type="hidden" value="" tabindex="3"/> 
                                                <div>
                                                    <label for="nameofrace"><span>Name Of Race:</span></label>
                                                    <div>
                                                    <input id="raceName" name="nameofrace" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="desc"><span>Description Of Race:</span></label>
                                                    <div>
                                                    <textarea id="raceDescription" name="desc" value="" tabindex="2"></textarea>
                                                    </div>
                                                </div>
												
												<div>
                                                    <label for="prizeDesc"><span>Prize:</span></label>
                                                    <div>
                                                    <textarea id="prizeDesc" name="prizeDesc" value="" tabindex="2"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="courseselection"><span>Course Selection:</span></label>
                                                    <div>
														<select id="mapId" name="mapId">
															
														</select>
													</div>
                                                </div>
                                                <div>
                                                <label for="startDateTime"><span>Start Date</span></label>
                                                    <div>
													<input id="startDateTime" name="startDateTime" type="text" value="" tabindex="12" readonly/>
													</div>
                                                </div>
                                                <input id="startDate" name="startDate" type="hidden" value="" tabindex="12"/>
												<input id="startTime" name="startTime" type="hidden" value="" tabindex="12"/>
												
												<div>
                                                <label for="finishDateTime"><span>Finish Date</span></label>
                                                   <div>
													<input id="finishDateTime" name="finishDateTime" type="text" tabindex="13" readonly/>
													</div>
                                                </div>
                                                
												<input id="finishDate" name="finishDate" type="hidden" tabindex="13" readonly/>
												<input id="finishTime" name="finishTime" type="hidden" tabindex="13"/>
												<div>
                                                    <label for="entryprice"><span>Entry Price:</span></label>
                                                    <div>
                                                    <input id="entryPrice" name="entryprice" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
												<div>
                                                    <label for="nameofrace"><span>Private?:</span></label>
                                                    <div>
                                                    <select id="private" name="private">
														<option value="0">No</option>
														<option value="1">Yes</option>
													</select>
                                                    </div>
                                                </div>
												
												<div>
													<label for="raceTokens"><span>Select Tokens</span></label>
													<div>
														<select multiple id="raceTokens" name="raceTokens">
														</select>
													</div>
												</div>
												<div class="clearfix" id="raceTokenResults">
													
												</div>

                                            <input name="token" type="hidden" value="a2"/>
                                            
                                           
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue" class="btn large"/></div>
												
                                </div>
                        </form>
					</div>
                 </div>

            </div>
					<div id="templateDiv" style="display: none">
						<div class="fourcol token" id="wrapper_{index}">
							<a href="#" class="optionselect" data-selection="{tokenId}" id="token_{tokenId}">
								<img src="{imageUrl}"/>
							</a>
							<div class="text-center"><p class="highlight">{tokenName}</p></div>
						</div>
					</div>
					

		   
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>