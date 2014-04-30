<?php
/*
Template Name: Admin Dashboard
*/

if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );

?>
<?php get_header(); ?>

	<div class="wide-fence why wrap"></div>
<br/>
        <section>
	    <div class="container pad-top sand bot-bg">
		<div class="inner-container wrap clearfix">
            <div>
		    <h1 class="highlight"><?php the_title(); ?></h1>
                    </div>
			<div class="inner-container wrap clearfix">
				<div class="fourcol first text-center">
					<a href="<?=site_url();?>/create-online-race-1">
					<span class="circle-image start-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Start a race"/></span>
					<h2 class="highlight">Create Online Game</h2><br/>
					<a/>
					<p class="highlight">An online race allows you to create a race and have your supporters enter your race and pay via PayPal.</p>
				</div>
				<div class="fourcol text-center">
					<a href="<?=site_url();?>/create-offline-race-1" id="comingsoon">
					<span class="circle-image enter-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Enter a race"/></span>
					<h2 class="highlight">Create Offline Game</h2><br/>
					</a>
					<p class="highlight">An offline race allows you to create a race where only you can enter players to the race, allowing you to allow for people to sign up in person and take money offline.</p>
				</div>
				<div class="fourcol text-center">
					<a href="<?=site_url();?>/profile">
					<span class="circle-image our-members"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Our members"/></span>
					<h2 class="highlight">Your Profile</h2><br/>
					</a>
					<p class="highlight">Create, edit and view your profile information, update your password and more.</p>
				</div>
			</div>
		    
            </div> 
			<div id="racesDataGrid" class="boxShadow">
				<table>
				<thead>
				<tr><th>Race</th><th>Map</th><th>Start Date</th><th>Finish Date</th><th>No. of Characters</th><th>Game Status</th><th>Invite Characters</th><th>Create Characters</th><th>Stop/Activate Game</th></tr>
				</thead>
				<tbody id="raceResultsActive"></tbody>
				</table>
			</div>
	    </div>
	</section>
    <div  style="display:none">
		<table >
		<tbody id="templateDiv">
		<tr><td><a href="{viewMoreUrl}">{raceName}</a></td><td>{mapName}</td><td>{start} {stime}</td><td>{finish} {ftime}</td><td>{maxNoOfPlayers}</td><td>{raceStatus}</td><td><a href="{tweetUrl}"><img src="<?php echo get_template_directory_uri(); ?>/library/images/bird_blue_32.png" border="0"/></a></td><td><a href="{createUrl}">Create</a></td><td><a href="{stopActivateUrl}">Edit</a></td></tr>
		</tbody>
		</table>
	</div>
        
        
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>