<?php
/*
Template Name: Fundraisers
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
		    <h1 class="highlight">Fundraisers</h1>
                    </div>
                    
		    <div id="info-header" class="clearfix">
			<div id="other-search">
			    <?php $search_text = "Search Members"; ?> 
			    <form method="get" id="membersearch"  action=""> 
				
				<input type="text" value="<?php echo $search_text; ?>"  
				name="charity-s" id="charity-s"  
				onblur="if (this.value == '')  
				{this.value = '<?php echo $search_text; ?>';}"  
				onfocus="if (this.value == '<?php echo $search_text; ?>')  
				{this.value = '';}" /> 
				
				<input type="hidden" id="membersearchsubmit" /> 
			    </form>
			    
			     <a href="http://race2fundraise.com/join/" class="btn small right">Create A Fundraiser</a>
			</div>
		    </div>
                </div> 
	    </div>
	</section>
        
      <div id="pagerDiv" style="width: 500px; margin: auto">
		<input type="submit" id="prev" class="btn small" value="PREVIOUS"  >
		<div id="pager" style="width: 200px; margin:auto; display: inline;" class="highlight"></div>
		<input type="submit" id="next" class="btn small" value="NEXT" >
		</div>
        <section id="charityResults">
            
        </section>
		<div id="templateDiv" style="display: none">
		<div class="container grit bot-bg bot-bg-alt clearfix" id="fund_{index}">
                <div class="inner-container wrap clearfix">
                    <div class="charities-info">
                        <div class="fourcol first pic-wooden">
                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/active-race-test-image-283x214.jpg"/>
                        </div>
                        <div class="fivecol">
                            <div><h2 class="highlight">{charityName}</h2></div>
                            <div><h3 class="highlight">Active Races</h3></div>

                            <div class="headings-3-col"><p class="highlight">Name</p><p class="highlight">Start</p><p class="highlight">Finish</p></div> 
                            <div class="activeRaces">
								
                            
							</div>
                        </div>
                       
                       <a class="btn small right" href="{profileUrl}">View More</a>
                    </div>
                </div>
            </div>
		</div>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>