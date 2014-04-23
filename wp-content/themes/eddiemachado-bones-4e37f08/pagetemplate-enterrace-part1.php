<?php
/*
Template Name: Enter Race Part 1
*/
?>

<?php get_header(); ?>

		<div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Enter Race</h1></div>
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
         
                                            <div class="text-center continue"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
	
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>