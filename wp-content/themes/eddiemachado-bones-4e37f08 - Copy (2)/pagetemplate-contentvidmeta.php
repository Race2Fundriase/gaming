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
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/Logo-Wooden.gif" alt="" />
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
					
					<div class="fourcol first clearfix">
						<span class="num-bullet">1</span>
						<p>Lorem ipsum dolar sit amet, malores omare ac fermentum, imperdiet ut viamus a, nam lectus at nunc. Quam euismod sem, semper
						 ut potenti pellentesque quisque.</p>
					</div>
					
					<div class="fourcol clearfix">
						<span class="num-bullet">2</span>
						<p>Lorem ipsum dolar sit amet, malores omare ac fermentum, imperdiet ut viamus a, nam lectus at nunc. Quam euismod sem, semper
						 ut potenti pellentesque quisque.</p>
					</div>
					
					<div class="fourcol last clearfix">
						<span class="num-bullet">3</span>
						<p>Lorem ipsum dolar sit amet, malores omare ac fermentum, imperdiet ut viamus a, nam lectus at nunc. Quam euismod sem, semper
						 ut potenti pellentesque quisque.</p>
					</div>
					
					<div class="fourcol first clearfix">
						<span class="num-bullet">4</span>
						<p>Lorem ipsum dolar sit amet, malores omare ac fermentum, imperdiet ut viamus a, nam lectus at nunc. Quam euismod sem, semper
						 ut potenti pellentesque quisque.</p>
					</div>
					
					<div class="fourcol clearfix">
						<span class="num-bullet clearfix">5</span>
						<p>Lorem ipsum dolar sit amet, malores omare ac fermentum, imperdiet ut viamus a, nam lectus at nunc. Quam euismod sem, semper
						 ut potenti pellentesque quisque.</p>
					</div>
					
					<div class="fourcol last clearfix">
						<span class="num-bullet">6</span>
						<p>Lorem ipsum dolar sit amet, malores omare ac fermentum, imperdiet ut viamus a, nam lectus at nunc. Quam euismod sem, semper
						 ut potenti pellentesque quisque.</p>
					</div>
					
				</div>
			</div>
			</section>
			

<?php get_footer(); ?>