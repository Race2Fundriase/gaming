<?php
/*
 Template Name: Create Game Two
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
                                <div class="text-center"><h1 class="highlight">Create: Online Game</h1></div>
                                
                                <div class="text-center"><p class="highlight">Select your online game payment method below:</p></div>
                                
                                <ul id="tab_control" class="tab_control">
                                     <li><a href="#" class="btn btn-blue large active">Paypal</a></li>
                                     <!--<li><a href="#" class="btn large">Just Giving</a></li>-->
                                </ul>
                                
                               <p class="text-center orange-type">Don't have a paypal account? sign up for one <a href="#">here</a></p>
                            </div>
                                        
                    </div>
            </div>
            
             <div class="fences wrap"></div>
             
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
                <div class="inner-container wrap"> 
			<div class="tabbed_content active">
                        <form id="create-game" action=""><!--start form-->
                                        <div class="form-elements">
                                                <h3><span>Part 2</span></h3>
                                             
                                                <div>
                                                    <label for="merchantemail"><span>Merchant E-mail:</span></label>
                                                    <div>
                                                    <input name="merchantemail" id="paymentMethodEmail" type="email" value="" tabindex="1"/> 
                                                    </div>
                                                </div>
                                        </div>
                        </form>
			</div>
					
			<div class="tabbed_content">
			<form id="create-game" action=""><!--start form-->
					<div class="form-elements">
                                                <h3><span>Part 2</span></h3>
                                             
                                                <div>
                                                    <label for="merchantemail"><span>Just Giving Charity ID:</span></label>
                                                    <div>
                                                    <input name="merchantemail" id="justGivingCharityId" type="text" value="" tabindex="1"/> 
                                                    </div>
                                                </div>
					</div>	
			</form>                
			</div>
                       
					
					<div>
                        <form id="create-game" action=""><!--start form-->
                                <div class="form-elements">
                                                
                                                <h3><span>Part 3</span></h3>
                                             
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