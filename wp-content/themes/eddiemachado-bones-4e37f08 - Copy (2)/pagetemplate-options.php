<?php
/*
Template Name: Options
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
	<div class="fences wrap"></div>
	<div id="result" class="boxShadow"></div>
	<section>
	    <div class="container sand bot-bg-grass">
		<div class="inner-container wrap">
		    <h1 class="highlight"><?php the_title(); ?></h1>
		    
		    
		    
		</div>
	    </div>
	</section>
	
	<section>
	    <div class="container grit bot-bg bot-bg-alt clearfix">
		<div class="inner-container wrap">
		    <div id="tabs">
			<div class="tabbed_content active">
			    <form id="">
					<input type="hidden" id="join_type" value="charity"/>
					<div class="form-elements">			     
					<div>
						<label for="weather"><span>Weather:</span></label>
						<div>
						<input name="weather" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" />
						  <div class="status">
							<p class="left-status">Cold</p><p class="right-status">Hot</p>
						  </div>
						  
						</div>
					</div>
					</div>
					<div>
					    <label for="weatherForecast"><span>Weather Forecast</span></label>
					    <div>
					    <input id="weatherForecast" name="weatherForecast" type="text" value="" size="8" tabindex="8"/>
					    </div>
					</div>
					<div>
					    <label for="energyRequired"><span>Energy Required</span></label>
					    <div>
					    <input id="energyRequired" name="energyRequired" type="text" value="" tabindex="9"/>
					    </div>
					</div>
					<div>
					    <label for="courseAggressiveness"><span>Course Aggressiveness</span></label>
					    <div>
							<input id="courseAggressiveness" name="courseAggressiveness" type="text" value="" tabindex="9"/>
					    </div>
					</div>
					<div>
					    <label for="terrain"><span>Terrain</span></label>
					    <div>
					    <input id="terrain" name="terrain" type="text" value="" tabindex="12"/>
					    </div>
					</div>
					<div>
					    <label for="courseDistance"><span>Course Distance</span></label>
					    <div>
					    <input id="courseDistance" name="courseDistance" type="text" tabindex="13"/>
					    </div>
					</div>
					<div>
					    <label for="speed"><span>Speed</span></label>
					    <div>
					    <input id="speed" name=speed"" type="text" tabindex="13"/>
					    </div>
					</div>
					
					
					<div class="text-center signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
				   
			    </form>
			</div>
		</div>
	</section>
	
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>