<?php
/*
 Template Name: Create Game Three
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
                                
                                
                            </div>
                                        
                    </div>
            </div>
            
             <div class="fences wrap"></div>
             
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
                <div class="inner-container wrap"> 
			                      
					
					<div>
                        <form id="create-game" action=""><!--start form-->
                                <div class="form-elements">
                                                
                                                <h3><span>Part 3</span></h3>
                                             
                                                
                                                <div>
													<div>
													<div style="width: 50%; float: left; color: white">Weather</div><div style="width: 50%; float: right; color: white">Forecast</div>
													</div>

												</div>	
												<div id="weatherResults">

												</div>	
                                                

                                            <input name="token" type="hidden" value="a2"/>
                                            
                                           
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue" class="btn large"/></div>
												
                                </div>
                        </form>
					</div>
                 </div>

            </div>
					
					<div id="templateDiv2" style="display: none">
		
						<label for="weatherDay{day}" style="padding: 12px 12px 12px 12px"><span>Weather Day {day}</span></label>
							<div>
								<div style="width: 50%; float: left">
								<select id="weatherDay{day}">
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
								<div style="width: 50%; float: right;">
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