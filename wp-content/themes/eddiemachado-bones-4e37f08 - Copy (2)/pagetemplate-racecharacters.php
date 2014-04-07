<?php
/*
Template Name: Race Characters
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
					
					<div>
					    <label for="tokenId"><span>Select Token</span></label>
					    <div>
							<select id="tokenId" name="tokenId">
							</select>
					    </div>
					</div>		     
					<div>
					    <label for="speed"><span>Speed:</span></label>
					    <div>
					    <input id="speed" name="speed" type="text" value="" size="8" tabindex="1"/> 
					    </div>
					</div>
					
					<div>
					    <label for="noOfPitstops"><span>No. Of Pitstops</span></label>
					    <div>
					    <input id="noOfPitstops" name="noOfPitstops" type="text" value="" size="8" tabindex="8"/>
					    </div>
					</div>
					
					<div class="text-center signup"><input type="submit" value="CONTINUE" class="btn large" id="continue"/></div>
				   
			    </form>
			</div>
		</div>
	</section>
	
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>