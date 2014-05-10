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
								
								<div class="info">
									
								</div>
							</div>
                            <div id="paperParentAR2">
								<div id="frame"></div>
							</div>          
                </div>
        </div>
		
<div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content active">
                <div class="inner-container wrap">
						<form id="enterRaceForm">
								<div class="form-elements">
												<h3><span>The Race</span></h3>
												<div>
													<div>
													<div style="width: 50%; float: left; color: white">Forecast</div>
													</div>

												</div>	
												<div id="weatherResults">

												</div>	
							
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
         
                                            <div class="text-center continue"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
	<div id="templateDiv" style="display: none">
		<div class="fourcol token" id="wrapper_{index}">
			<a href="#" class="optionselect" data-selection="{tokenId}" id="token_{tokenId}">
				<img src="{imageUrl}"/>
			</a>
			<div class="text-center"><p class="highlight">{tokenName}</p></div>
		</div>
	</div>
	<div id="templateDiv2" style="display: none">
		
	<label for="weatherDay{day}" style="padding: 12px 12px 12px 12px"><span>Weather Day {day}</span></label>
		<div>
			<div style="width: 50%; float: left;">
			<select id="weatherForecastDay{day}">
			<option value="1">Icy</option>
				<option value="2">Snow</option>
				<option value="3">Thunderstorm</option>
				<option value="4">Heavy Rain</option>
				<option value="5">Rain</option>
				<option value="6">Overcast</option>
				<option value="7">Light cloud</option>
				<option value="8">Clear skies</option>
				<option value="9">Sunny</option>
				<option value="10">Heat wave</option>
			</select></div>
		</div>
	
	</div>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>