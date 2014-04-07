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
		    <ul id="tab_control" class="">
			<li><a href="<?=site_url();?>/create-online-race" class="btn large ">Create Online Game</a></li>
			<li><a href="<?=site_url();?>/" class="btn large ">Create Offline Game</a></li>
			<li><a href="<?=site_url();?>/profile" class="btn large">Your Profile</a></li>
		    </ul>
            </div> 
			<div id="racesDataGrid" class="boxShadow">
				<table id="list2"></table>
				<div id="pager2"></div>
			</div>
	    </div>
	</section>
        
        
        
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>