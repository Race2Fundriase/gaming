<?php
/*
Template Name: User Dashboard
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
						<a href="<?=site_url();?>/races">
						<span class="circle-image start-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Start a race"/></span>
						<h2 class="highlight">Enter A Race</h2><br/>
						<a/>
						<p class="highlight">Enter a race and begin helping good causes to raise money whilst having fun.</p>
					</div>
					<div class="fourcol text-center">
						<a href="<?=site_url();?>/charities">
						<span class="circle-image enter-a-race"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Enter a race"/></span>
						<h2 class="highlight">Charities</h2><br/>
						</a>
						<p class="highlight">Search and view charities on Race to Fundraise, learn more about their work and join an active race to raise money.</p>
					</div>
					<div class="fourcol text-center">
						<a href="<?=site_url();?>/fundraisers">
						<span class="circle-image our-members"><img src="<?php echo get_template_directory_uri(); ?>/library/images/circle-image-overlay.png" alt="Our members"/></span>
						<h2 class="highlight">Fundraisers</h2><br/>
						</a>
						<p class="highlight">Check out our fundraisers, learn more about their cause and join an active race to raise money.</p>
					</div>
				</div>
			<div id="racesDataGrid" class="boxShadow">
				<table>
				<thead>
				<tr><th>Race</th><th>Map</th><th>Start Date</th><th>Finish Date</th><th>Character Type</th><th>Game Status</th><th>Leaderboard Position</th></tr>
				</thead>
				<tbody id="raceResultsActive"></tbody>
				</table>
			</div>
	    </div>
	</section>
    <div  style="display:none">
		<table >
		<tbody id="templateDiv">
		<tr><td><a href="{viewMoreUrl}">{raceName}</a></td><td>{mapName}</td><td>{start}</td><td>{finish}</td><td>{characterType}</td><td>{raceStatus}</td><td>{leaderboardPos}</td></tr>
		</tbody>
		</table>
	</div>
        
        
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>