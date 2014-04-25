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
                        
                        <p>Table of active races</p>
                        
                        <h2 class="highlight">Completed Races</h2>
                        
                        <p>Table of completed races</p>
                    </div>
                    
                    <aside id="race-excerpt" class="fivecol last">
                        <div><h3 class="highlight">Enter Our Race</h3></div>
                        <div><p class="highlight">Race to the North Pole</p></div>
                        <div><p class="highlight">North Pole</p></div>
                        <div><p class="highlight">Terrain: Icy, Rough</a></p></div>
                        <div><p class="highlight">Weather: Cold, Snowy</p></div>
                        <div class="headings"><p class="highlight">Start</p><p class="highlight">Finish</p></div>
			<div class="dates"><time class="highlight">08/08/13</time><time class="highlight">08/08/13</time></div>
                        <div class="profile-view"><a class="btn small center" href="#">View More</a></div>
		    </aside>
                </div>
            </div>	
        </section>
		<?php get_footer(); ?>
		<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>