<?php get_header(); ?>
			<section>
				<div class="slider clearfix">
					<ul class="rslides">
						<li><img src="<?php echo get_template_directory_uri(); ?>/library/images/slide1.jpg" alt=""/></li>
						<li><img src="<?php echo get_template_directory_uri(); ?>/library/images/slide2.jpg" alt=""/></li>
						<li><img src="<?php echo get_template_directory_uri(); ?>/library/images/slide3a.jpg" alt=""/></li>
					</ul>
					<div class="inner-slider">
						<div id="logo">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
						</div>
					</div>
					<div class="enter-race">
						<a class="btn large" href="<?=site_url()?>/races">Sign Up</a>
					</div>
					<div class="fences wrap"></div>
				</div>
			</section>
			
			<section>
			<div class="container bot-bg pad-top sand">
				<div class="inner-container wrap clearfix">
					<div class="fourcol first text-center">
						<a href="#">
						<span class="circle-image start-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Start a race"/></span>
						<h2 class="highlight">Create A Race</h2><br/>
						<a/>
						<p class="highlight">You can create your own unique race using our easy to use interface. You can set your own start and end points and select characters that your supporters will use, if you wish you can make it relevant to your own cause and it can be sensible or crazy as you chose. Race2Fundraise is a great unique FUNdraising idea!</p>
					</div>
					<div class="fourcol text-center">
						<a href="http://race2fundraise.com/join/">
						<span class="circle-image enter-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Enter a race"/></span>
						<h2 class="highlight">Enter A Race</h2><br/>
						</a>
						<p class="highlight">By entering a race you get to have great fun whilst supporting your chosen fundraising cause. You will have to choose a character to take account of the race conditions, and set your driving style, you may even have to plot your course. Be warned, the weather can affect the way your character will perform and the crazy race administrators control the weather so be you'll need to keep your wits about you.</p>
					</div>
					<div class="fourcol text-center">
						<a href="http://race2fundraise.com/charities/">
						<span class="circle-image our-members"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Our members"/></span>
						<h2 class="highlight">Our Members</h2><br/>
						</a>
						<p class="highlight">Charities, clubs, societies, places of education and fundraisers raising money for their chosen cause are all eligible to run setup a race2fundraise account.</p>
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
								    $getfield = '?screen_name=Race2Fundraise&count=3&include_entities=true';
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
						<!--<h2 class="highlight">Video Placeholder</h2>-->
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
					
					<div id="featuredGames">
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
				<div id="templateDiv" style="display: none">
					<div class="threecol first text-center">
						<div class="featured-game" style="overflow: hidden">
							<img src="{mapImageUrl}" alt="{raceName}" />
							<p class="title highlight">{raceName}</p>
							<p class="charity highlight">{charityName}</p>
						</div>
						<a class="btn medium" href="{enterRaceUrl}">Enter Race</a>
					</div>
				</div>

<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>