<?php
/*
Template Name: Video & Facts
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
			<div class="container pad-top bot-dash sand">
				<div class="wide-fence wrap"></div>
				<div class="inner-container wrap clearfix">
					<div class="sixcol first">
						<?php
						if(have_posts()) {
							while(have_posts()) {
								the_post();
								echo '<h1 class="highlight">'. get_the_title() . '</h1>';
								the_content();
							}
						}
						?>
					</div>
					<div class="sixcol last vid-wooden">
						<div class="video-container">
						<?php echo getFeaturedVideo($post->ID); ?>
						</div>
					</div>
				</div>
			</div>
			</section>
			
			<section>
			<div class="container top-bg bot-bg sand">
				<div class="inner-container wrap clearfix">
					<div class="twelvecol first last">
						<h2 class="highlight">6 Facts About R2F</h2>
					</div>
					<div class="row clearfix">
					<div class="fourcol first clearfix">
						<span class="num-bullet">1</span>
						
						<p><span class="highlight">Fun</span><br/>The race2fundraise is fun to play, depending on how you choose to setup your race, players decide which character they want to race, select their racing colours, create their own route and determine their racing style enabling your supporters to become part of the fundraising event.</p>
					</div>
					
					<div class="fourcol clearfix">
						<span class="num-bullet">2</span>
						<p><span class="highlight">A Truly Unique fundraising opportunity</span><br/>
							You can tailor each race to your cause or project needs.
							You decide if the race is open to everyone (worldwide) or a closed list of invited people. 
							You choose the race duration, start and end times.
							You choose the race location, start and end points.
							You set the character choice.
							You set the player price.
							You even control the weather.
							You choose if there are prizes for finishing positions.</p>
					</div>
					
					<div class="fourcol last clearfix">
						<span class="num-bullet">3</span>
						<p><span class="highlight">Easy to setup and administer</span><br/>
Our game engine has been designed to make it simple to setup a new race, all the game settings and reporting is available online.  Players can see their current positions online 24 hours a day.</p>
					</div>
					</div>
					
					<div class="row clearfix">
					<div class="fourcol first clearfix">
						<span class="num-bullet">4</span>
						<p><span class="highlight">Cost effective fundraising idea</span><br/>
Race2fundraise offers excellent value for money with options to reflect different supporter levels and budgets; you could even choose to buy a small race and then add extra players as you need them. You can use your own website and email system to invite people to race and fundraise.</p>
					</div>
					
					<div class="fourcol clearfix">
						<span class="num-bullet">5</span>
						<p><span class="highlight">Inclusive to all</span><br/> 
Irrespective of age, location and agility all players can compete fairly against one another.  You can choose to make the game open to anyone online.</p>
					</div>
					
					<div class="fourcol last clearfix">
						<span class="num-bullet">6</span>
						<p><span class="highlight">Value and Entertainment for your supporters</span><br/>
During the race the players can see their position on the race map and compare it with their friends and family so your supporters receive entertainment for the full race duration.</p>
					</div>
					</div>
				</div>
			</div>
			</section>
			

<?php get_footer(); ?>