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
		    <h1 class="highlight" id="charityProfileName"></h1>
                    </div>
                    
                    <div class="fivecol first">
                        <h3 class="highlight" id="charityProfileWebsite"></h3>
                    </div>
                </div> 
	    </div>
	</section>
        
        <section>
            <div class="container grit bot-bg">
                <div class="inner-container wrap clearfix">
                    <div class="fivecol first">
                        <h2 class="highlight"  id="charityProfileName2"></h3>
                        
                        <p id="charityProfileDesc"></p>
                        
                        <h2 class="highlight">Active Races</h2>
                        
                        <ol id="activeRaceResults">
						</ol>
                        
                        <h2 class="highlight">Completed Races</h2>
                        
						<ol id="completeRaceResults">
						</ol>
                    </div>
                    
                    
                </div>
            </div>	
        </section>
		<?php get_footer(); ?>
		<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>