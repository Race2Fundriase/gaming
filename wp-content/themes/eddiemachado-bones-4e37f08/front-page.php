<?php get_header(); ?>
			<section>
				<div class="slider clearfix">
					<ul class="rslides">
						<li><img src="<?php echo get_template_directory_uri(); ?>/library/images/slide1.jpg" alt=""/></li>
						<li><img src="<?php echo get_template_directory_uri(); ?>/library/images/slide2.jpg" alt=""/></li>
						<li><img src="<?php echo get_template_directory_uri(); ?>/library/images/slide3.jpg" alt=""/></li>
					</ul>
					<div class="inner-slider">
						<div id="logo">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/Logo-Wooden.gif" alt="" />
						</div>
					</div>
					<div class="enter-race">
						<a class="btn large" href="<?=site_url()?>/races">Enter A Race</a>
					</div>
					<div class="fences wrap"></div>
				</div>
			</section>
			
			<section>
			<div class="container bot-bg pad-top sand">
				<div class="inner-container wrap clearfix">
					<div class="fourcol first text-center">
						<span class="circle-image start-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Start a race"/></span>
						<h2 class="highlight">Start A Race</h2><br/>
						<p class="highlight">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
					</div>
					<div class="fourcol text-center">
						<span class="circle-image enter-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Enter a race"/></span>
						<h2 class="highlight">Enter A Race</h2><br/>
						<p class="highlight">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
					</div>
					<div class="fourcol text-center">
						<span class="circle-image our-members"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Our members"/></span>
						<h2 class="highlight">Our Members</h2><br/>
						<p class="highlight">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
					</div>
				</div>
			</div>
			</section>
			
			<section>
			<div class="container top-bg bot-bg sand">
				<div class="inner-container wrap clearfix">
					<div class="sixcol first">
						<h2 class="highlight">Twitter Feed</h2>
						<?php
							require_once('library/TwitterAPIExchange.php');
							
							$settings = array (
							    'oauth_access_token' => "157805036-G61sTHfpyHi0ABvvoIiPTyZ1KX2pFYqvavYSkCAR",
							    'oauth_access_token_secret' => "PDz1xzDFSBETSVKAWUANt1NYEqPMhOzX6Vn0K7FxIU",
							    'consumer_key' => "WxXBmAIH5IJfC0pwGutQ",
							    'consumer_secret' => "xAjhipQzRZfWJKmvgrED5ksfM3HLF1NBMfz972pg"
							);
							
							/** Note: Set the GET field BEFORE calling buildOauth(); **/
								    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
								    $getfield = '?screen_name=design_spin&count=3&include_entities=true';
								    $requestMethod = 'GET';
								    $twitter = new TwitterAPIExchange($settings);
								    $result = json_decode($twitter->setGetfield($getfield)
										 ->buildOauth($url, $requestMethod)
										 ->performRequest(), true); 
								    echo '<div id="twitter_container" class="clearfix">';
								   
								    for ($i=0 ; $i < 3; $i++) {
									    echo '<div class="tweet-container">';
									    echo '<span class="twitter-user" style="background:url('.$result[$i][user][profile_image_url].')"></span>';
									    echo '<div class="twitter-tweet"><p class="highlight">'.make_click($result[$i][text]).'</p></div>';
									    echo '</div>';
									}
								      
								    echo '</div>';
								    
								    
								    
								    /**
								    * Make clickable links from URLs in text.
								    */
								   function make_click($text) {
								     return preg_replace_callback(
								       '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', 
								       create_function(
									 '$matches',
									 'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
								       ),
								       $text
								     );
								   }
						    ?>
					</div>
					<div class="sixcol wooden text-center">
						<h2 class="highlight">Testimonials</h2>
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
					<div class="twelvecol first">
						<h2 class="highlight">Featured Games</h2>
					</div>
					
					<div class="threecol first text-center">
						<div class="featured-game">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/start-a-race-293x220.jpg" alt="game title"/>
							<p class="title highlight">A great race online</p>
							<p class="charity highlight">By XYZ Charity</p>
						</div>
						<a class="btn medium">Enter Race</a>
					</div>
					
					<div class="threecol text-center">
						<div class="featured-game">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/start-a-race-293x220.jpg" alt="game title"/>
							<p class="title highlight">A great race online</p>
							<p class="charity highlight">By XYZ Charity</p>
						</div>
						<a class="btn medium">Enter Race</a>
					</div>
					
					<div class="threecol text-center">
						<div class="featured-game">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/start-a-race-293x220.jpg" alt="game title"/>
							<p class="title highlight">A great race online</p>
							<p class="charity highlight">By XYZ Charity</p>
						</div>
						<a class="btn medium">Enter Race</a>
					</div>
					
					<div class="threecol text-center">
						<div class="featured-game">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/start-a-race-293x220.jpg" alt="game title"/>
							<p class="title highlight">A great race online</p>
							<p class="charity highlight">By XYZ Charity</p>
						</div>
						<a class="btn medium">Enter Race</a>
					</div>
				</div>
			</div>
			</section>
			
			<section>
			<div class="container top-bg bot-bg sand">
				<div class="inner-container wrap clearfix">
					<div class="eightcol first clearfix">
						<?php
						$query = new WP_Query('pagename=about-r2f');
						
						if ($query->have_posts()) {
							while ($query->have_posts()) {
								$query->the_post();
								echo '<h2 class="highlight">' . get_the_title() .'</h2>';
								echo the_excerpt() ;
								echo '<a class="btn small right" href="'. get_permalink() .'">Learn More</a>';
							}
						}
						?>
					</div>
					
					<?php
						$images =& get_children( array (
							'post_parent' => $query->ID,
							'post_type' => 'attachment',
							'post_mime_type' => 'image'
						));
					
						if ( empty($images) ) {
							// no attachments here
						} else {
							$i = 0;
							$len = count($images);
							
							echo '<div class="fourcol last">';
							foreach ( $images as $attachment_id => $attachment ) {
								if ($i == 0) {
									echo '<div class="sixcol thumb first text-center">';
								}
								else if ( $i == $len - 1) {
									echo '<div class="sixcol thumb last text-center">';
								}
								else {
									echo '<div class="sixcol thumb text-center"';
								}
								echo '<span class="shadow"><img src="'.wp_get_attachment_thumb_url( $attachment_id).'"/></span>';
								echo '</div>';
								$i++;
							}
							echo '</div>';
						}
					?>
				</div>
			</div>
			</section>
			

<?php get_footer(); ?>