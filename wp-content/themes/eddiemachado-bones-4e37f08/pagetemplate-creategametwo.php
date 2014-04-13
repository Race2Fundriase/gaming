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
                                     <li><a href="#" class="btn large">Just Giving</a></li>
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
                                                <label for="startdate"><span>Start Date</span></label>
                                                    <div>
													<input id="startDate" name="startDate" type="text" value="" tabindex="12"/>
													</div>
                                                </div>
												<div>
                                                <label for="startTime"><span>Start Time</span></label>
                                                    <div>
													<input id="startTime" name="startTime" type="text" value="" tabindex="12"/>
													</div>
                                                </div>
                                                <div>
                                                <label for="finishdate"><span>Finish Date</span></label>
                                                   <div>
													<input id="finishDate" name="finishDate" type="text" tabindex="13"/>
													</div>
                                                </div>
												<div>
                                                <label for="finishTime"><span>Finish Time</span></label>
                                                   <div>
													<input id="finishTime" name="finishTime" type="text" tabindex="13"/>
													</div>
                                                </div>
                                                <div>
                                                    <label for="entryprice"><span>Entry Price:</span></label>
                                                    <div>
                                                    <input id="entryPrice" name="entryprice" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                <div>
												<label for="curDay"><span>Current Day</span></label>
													<div>
													<input id="curDay" name="curDay" type="text" tabindex="13"/>
													</div>
												</div>
                                            					<div>
					    <label for="raceTokens"><span>Select Tokens</span></label>
					    <div>
							<select multiple id="raceTokens" name="raceTokens">
							</select>
					    </div>
					</div>

                                            <input name="token" type="hidden" value="a2"/>
                                            
                                            <!--<div class="clearfix">
                                            <div class="fourcol first token">
                                                <a href="#" class="vehicleselect" data-selection="a2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol token">
                                                <a href="#" class="vehicleselect active" data-selection="b2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol last token">
                                                <a href="#" class="vehicleselect" data-selection="c2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol first token">
                                                <a href="#" class="vehicleselect" data-selection="d2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol token">
                                                <a href="#" class="vehicleselect" data-selection="e2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol last token">
                                                <a href="#" class="vehicleselect" data-selection="f2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            </div>
                                                -->  
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue" class="btn large"/></div>
                        
                                </div>
                        </form>
					</div>
                 </div>

            </div>
           

		   
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>