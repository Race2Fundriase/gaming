<?php
/*
Template Name: Races
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
		    <h1 class="highlight"><?php the_title(); ?></h1>
                    </div>
		    <ul id="tab_control" class="tab_control left">
			<li><a href="#" class="btn btn-blue large active">Active Races</a></li>
			<li><a href="#" class="btn large">Finished Races</a></li>
		    </ul>
                    
                    <div id="other-search">
                        <?php $search_text = "Search"; ?> 
                        <form method="get" id="racesearch"  action=""> 
                            
                            <input type="text" value="<?php echo $search_text; ?>"  
                            name="race-s" id="race-s"  
                            onblur="if (this.value == '')  
                            {this.value = '<?php echo $search_text; ?>';}"  
                            onfocus="if (this.value == '<?php echo $search_text; ?>')  
                            {this.value = '';}" /> 
                            
                            <input type="hidden" id="racesearchsubmit" /> 
                        </form>
                    </div>
                </div> 
	    </div>
	</section>
        
        <!--Tabbed Content-->
        <div id="tabs">
        <div class="tabbed_content active">
 		<div id="result" class="boxShadow"></div>
        <section id="raceResultsActive"><!--Active Races-->
            
            
        </section>
        </div><!--End of tab-->
        
        <div class="tabbed_content">
            
        <section id="raceResultsFinished"><!--Active Races-->
            
            
        </section>
            </div><!--End of tab-->
        </div><!--End Tabs-->
		
		<div id="templateDiv" style="display:none">
		<div class="container grit bot-bg bot-bg-alt clearfix">
			<div class="inner-container wrap clearfix">
				<div class="active-race">
					<div class="fourcol first pic-wooden" style="overflow: hidden; padding: 25px; height: 400px">
						<img src="<?php echo site_url(); ?>{image}" style="height: 300px"/>
					</div>
					<div class="fivecol">
						<div><h2 class="highlight">{raceName}</h2></div>
						<div><h3 class="highlight">{charityName}</h3></div>
					   
						  
						<div class="headings"><p class="highlight">Leaderboard</p><p class="highlight">Race Map: <span class="map">{mapName}</span></p></div>
						  
						<ol class="highlight" id="leaderboard_{id}">
						</ol>
						  
					   
					</div>
					<div class="threecol last">
						<div class="headings"><p class="highlight">Start</p><p class="highlight">Finish</p></div>
						<div class="dates"><time class="highlight">{start}</time><time class="highlight">{finish}</time></div>
					</div>
				  <a class="btn small right" href="{viewMoreUrl}">View More</a>
				</div>
			</div>
		</div>
		</div>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>