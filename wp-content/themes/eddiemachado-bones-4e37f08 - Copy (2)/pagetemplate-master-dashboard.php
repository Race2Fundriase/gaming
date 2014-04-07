<?php
/*
Template Name: Master Dashboard
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
			<li><a href="<?=site_url();?>/wp-admin" class="btn large ">WP Admin</a></li>
			<li><a href="<?=site_url();?>/maps-admin" class="btn large ">Map Admin</a></li>
			<li><a href="<?=site_url();?>/token-admin" class="btn large">Token Admin</a></li>
			<li><a href="<?=site_url();?>/create-online-race" class="btn large ">Create Online Game</a></li>
			<li><a href="<?=site_url();?>/" class="btn large ">Create Offline Game</a></li>
		    </ul>
            </div> 
	    </div>
	</section>
        
        
        
<?php get_footer(); ?>