<?php
/*
Template Name: Profile
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
		    <h1 class="highlight" id="charityProfileName">Charity/Fundraiser Profile Name</h1>
			<br/><p class="highlight" id="linkTo">Link to this charity:</p>
                    </div>
                    
                    <div class="fivecol first">
                        <h3 class="highlight" id="charityProfileWebsite">Charity/Fundraiser Website</h3>
                    </div>
					
		    
		    <div class="sixcol last picture-wooden">
			
			    <img src="<?php echo get_template_directory_uri(); ?>/library/images/enter-a-race.jpg" alt="" />
			
                    </div>
                </div> 
	    </div>
	</section>
        
        <section>
            <div class="container grit bot-bg-alt pad-bot">
                <div class="inner-container wrap clearfix">
                    <div class="sevencol first">
                        <h2 class="highlight"  id="charityProfileName2"></h3>
                        
                        <p id="charityProfileDesc"></p>
                        
                        <h2 class="highlight">Active Races</h2>
                        
                        <div class="headings-3-col"><p class="highlight">Name</p><p class="highlight">Start</p><p class="highlight">Finish</p></div> 
						<div class="activeRaces" id="activeRaces">
							
						
						</div>
                        
                        <h2 class="highlight">Completed Races</h2>
                        
						 <div class="headings-3-col"><p class="highlight">Name</p><p class="highlight">Start</p><p class="highlight">Finish</p></div> 
						<div class="activeRaces" id="completeRaces">
							
						
						</div>
                    </div>
                    
		    <aside id="profile-excerpt" class="fivecol last charities-info" class="myhidden">
                        <div class="{enterRaceClass}" class="myhidden" align="center" style="margin-bottom: 10px">
							<a style="position: relative;" class="btn small center" id="featureenterRace">Enter Our Race</a>
						</div>
						<div align="center">
							<img src="" id="featureImage"/>
						</div>
						<div>
                        <p class="highlight" id="featureRaceName"></p><br/>
						<p class="highlight" id="featureRaceData"></p><br/>
						<p class="highlight" id="featureRaceDescription"></p><br/>
						</div>
                        <div class="headings"><p class="highlight">Start</p><p class="highlight">Finish</p></div>
						<div class="dates"><time id="featurestartDate" datetime="" class="highlight"></time><time id="featurefinishDate" datetime="" class="highlight"></time></div>
						<div class="dates"><time class="highlight" id="featurestartTime"></time><time class="highlight" id="featurefinishTime"></time></div>
						
                    </aside>
                    
                </div>
            </div>	
        </section>
		<?php get_footer(); ?>
		<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>