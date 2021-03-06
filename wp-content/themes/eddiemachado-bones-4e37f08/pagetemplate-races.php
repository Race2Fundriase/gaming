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
 		
		<div id="pagerDiv" style="width: 500px; margin: auto">
		<input type="submit" id="prev" class="btn small" value="PREVIOUS"  >
		<div id="pager" style="width: 200px; margin:auto; display: inline;" class="highlight"></div>
		<input type="submit" id="next" class="btn small" value="NEXT" >
		</div>
        <section id="raceResultsActive"><!--Active Races-->
            
            
        </section>
        </div><!--End of tab-->
        
        <div class="tabbed_content">
        
        <section id="raceResultsFinished"><!--Active Races-->
            
            
        </section>
            </div><!--End of tab-->
        </div><!--End Tabs-->
		
		<div id="templateDiv" style="display:none">
		<div class="container grit bot-bg bot-bg-alt clearfix" id="race_{index}">
			<div class="inner-container wrap clearfix">
				<div class="active-race">
					<div class="fourcol first pic-wooden">
						<img src="<?php echo site_url(); ?>{image}" />
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
						<div class="dates"><time class="highlight">{stime}</time><time class="highlight">{ftime}</time></div>
					</div>
				  <a class="btn small right" href="{viewMoreUrl}">View More</a><br/>
				  <div class="{enterRaceClass}">
				  <a style="position: relative; top: 10px" class="btn small right" href="{enterRaceUrl}">Enter Now</a>
				  </div>
				 
				  <!--<a class="btn small right" href="{joinRaceUrl}">Join Race</a>-->
				</div>
			</div>
		</div>
		</div>
		<div id="result" class="boxShadow myhidden"></div>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js?cache=1" type="text/javascript"></script>