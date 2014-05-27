<?php
/*
Template Name: Offline Print 2
*/
?>

<?php get_header(); ?>

        <section>
                                
                    <div class="inner-slider wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                    </div>
                    
            
	</section>
	
	<br/><br/><br/><br/><br/>
        
    <section>
	    <div class="container pad-top sand bot-bg-grass">
		
			<div class="inner-container wrap clearfix">
				
				<div>
					<br/>
					<div class="sponser myhidden" id="sponserDiv">
						<p class="highlight" id="">Sponsored By:</p>
						<a target="_blank" href="" id="sponserUrl"><img border="0" src="" id="sponserLogoUrl"/></a>
					</div>
				</div>
						
				<div id="active-race-header2">
					<div class="info" >
						<h2 class="highlight" id="raceName"></h2><br/>
						<h2 class="highlight" id="charityProfileName"></h2>
					</div>
					<div style="margin-top: -120px; margin-left: 500px">
						<p class="highlight">Start: <span id="startDate"></span> <span id="startTime"></span></p><br/>
						<p class="highlight">Finish: <span id="finishDate"></span> <span id="finishTime"></span></p>
						<div class="highlight">Entry Price: <span id="entryPrice"></span></div>
					</div>

			</div> 
			<div id="paperParentAR2" style="height: 700px">
				
				</div>	
	    </div>
	</section>
        
        


<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>
