<?php
/*
Template Name: Create Online Race
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
								     
					<div>
					    <label for="maxNoOfPlayers"><span>Custom amount of tokens:</span></label>
					    <div>
					    <input id="maxNoOfPlayers" name="maxNoOfPlayers" type="text" value="" size="8" tabindex="1"/> 
					    </div>
					</div>
					
					<div>
					    <label for="raceName"><span>Name of Race</span></label>
					    <div>
					    <input id="raceName" name="raceName" type="text" value="" size="8" tabindex="8"/>
					    </div>
					</div>
					<div>
					    <label for="raceDescription"><span>Description of Race</span></label>
					    <div>
					    <input id="raceDescription" name="raceDescription" type="text" value="" tabindex="9"/>
					    </div>
					</div>
					<div>
					    <label for="locationDescription"><span>Description of Location</span></label>
					    <div>
					    <input id="locationDescription" name="locationDescription" type="text" value="" tabindex="9"/>
					    </div>
					</div>
					<div>
					    <label for="terrainDescription"><span>Description of Terrain</span></label>
					    <div>
					    <input id="terrainDescription" name="terrainDescription" type="text" value="" tabindex="9"/>
					    </div>
					</div>
					<div>
					    <label for="weatherDescription"><span>Description of Weather</span></label>
					    <div>
					    <input id="weatherDescription" name="weatherDescription" type="text" value="" tabindex="9"/>
					    </div>
					</div>					
					<div>
					    <label for="mapId"><span>Course</span></label>
					    <div>
							<select id="mapId" name="mapId">
								
							</select>
					    </div>
					</div>
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
					<div>
					    <label for="finishGridX"><span>Finish Grid X</span></label>
					    <div>
					    <input id="finishGridX" name="finishGridX" type="text" value="" tabindex="12"/>
					    </div>
					</div>
					<div>
					    <label for=finishGridY"><span>Finish Grid Y</span></label>
					    <div>
					    <input id="finishGridY" name="finishGridY" type="text" value="" tabindex="12"/>
					    </div>
					</div>
					<div>
					    <label for="startDate"><span>Start Date</span></label>
					    <div>
					    <input id="startDate" name="startDate" type="text" value="" tabindex="12"/>
					    </div>
					</div>
					<div>
					    <label for="finishDate"><span>Finish Date</span></label>
					    <div>
					    <input id="finishDate" name="finishDate" type="text" tabindex="13"/>
					    </div>
					</div>
					<div>
					    <label for="entryPrice"><span>Entry Price</span></label>
					    <div>
					    <input id="entryPrice" name=entryPrice"" type="text" tabindex="13"/>
					    </div>
					</div>
					<div>
					    <label for="raceTokens"><span>Select Tokens</span></label>
					    <div>
							<select multiple id="raceTokens" name="raceTokens">
							</select>
					    </div>
					</div>
					
					<div class="text-center signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
				   
			    </form>
			</div>
		</div>
	</section>
	
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>