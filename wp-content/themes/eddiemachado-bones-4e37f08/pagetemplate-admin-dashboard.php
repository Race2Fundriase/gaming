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
		    <ul id="tab_control" class="">
			<li><a href="<?=site_url();?>/create-online-race" class="btn large ">Create Online Game</a></li>
			<li><a href="<?=site_url();?>/" class="btn large ">Create Offline Game</a></li>
			<li><a href="<?=site_url();?>/profile" class="btn large">Your Profile</a></li>
		    </ul>
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
		<tr><td><a href="{viewMoreUrl}">{raceName}</a></td><td>{mapName}</td><td>{start}</td><td>{finish}</td><td>{maxNoOfPlayers}</td><td>{raceStatus}</td><td>{inviteUrl}</td><td>{createUrl}</td><td>{stopActivateUrl}</td></tr>
		</tbody>
		</table>
	</div>
        
        
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>