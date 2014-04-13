<?php
/*
Template Name: Admin Dashboard
*/
?>
<?php get_header(); ?>

	<div class="wide-fence why wrap"></div>
<br/>
        <section>
	    <div class="container pad-top sand bot-bg-grass">
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
					<p class="highlight">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
				</div>
				<div class="fourcol text-center">
					<a href="<?=site_url();?>/create-online-race-1">
					<span class="circle-image enter-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Enter a race"/></span>
					<h2 class="highlight">Create Offline Game</h2><br/>
					</a>
					<p class="highlight">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
				</div>
				<div class="fourcol text-center">
					<a href="<?=site_url();?>/profile">
					<span class="circle-image our-members"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Our members"/></span>
					<h2 class="highlight">Your Profile</h2><br/>
					</a>
					<p class="highlight">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
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
		<tr><td><a href="{viewMoreUrl}">{raceName}</a></td><td>{mapName}</td><td>{start} {stime}</td><td>{finish} {ftime}</td><td>{maxNoOfPlayers}</td><td>{raceStatus}</td><td><a href="{inviteUrl}">Invite</a></td><td><a href="{createUrl}">Create</a></td><td><a href="{stopActivateUrl}">Edit</a></td></tr>
		</tbody>
		</table>
	</div>
        
        
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>