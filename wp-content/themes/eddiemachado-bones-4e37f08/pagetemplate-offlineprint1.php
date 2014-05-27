<?php
/*
Template Name: Offline Print 1
*/
?>

<?php get_header(); ?>

        
    <section >
		<div id="printheader">
		<div class="inner-slider wrap" id="">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                    </div>
					<br/><br/><br/><br/><br/>
	    <div class="container pad-top sand bot-bg-grass">
		
			<div class="inner-container wrap clearfix">
				
				<div>
					<br/>
					<div class="sponser myhidden" id="sponserDiv">
						<p class="highlight" id="">Sponsored By:</p>
						<a target="_blank" href="" id="sponserUrl"><img border="0" src="" id="sponserLogoUrl"/></a>
					</div>
				</div>
						
				<div class="active-race-header2-print">
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
	    </div>
		</div>
		</div>
	</section>
        
        <section>
            <div class="container grit bot-bg">
                <div class="inner-container wrap clearfix">
				</h1>
                    <div class="ninecol first">
                        
                        
                        <div id="race-data">
                            
							 <div class="characters clearfix">
                                
                            <div><h3 class="highlight">Characters Available</h3></div>
								<div id="charactersResults">
								</div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
			
        </section>
		<section>
		<p>Please pick your:</p>
		<p>Driving Style 1 - 10 (1 is slow as possible, 10 is fast as possible)</p>
		<p>Pitstop Frequency 1 - 10 (1 is never, 10 is very frequent)</p>
		</section>
		<div id="templateDiv" style="display: none">
			<div class="fourcol" id="wrapper_{index}" >
				<img src="{image}" alt="" />
				<br/>
				<p class="highlight">{tokenName}</p>
			</div>
		</div>
		


<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>
