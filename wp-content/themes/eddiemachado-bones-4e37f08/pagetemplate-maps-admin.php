<?php
/*
Template Name: Maps Admin
*/
?>

<?php get_currentuserinfo(); if (!current_user_can('publish_posts')) die("Access denied");?>

<?php get_header(); ?>

<section>
	<div class="container pad-top sand bot-bg-grass">
		<div class="inner-container wrap clearfix">
			<div>
				<h1 class="highlight"><?php the_title(); ?></h1>
			</div>
		</div> 
	</div>
</section>
<section id="mapResults">

</section>
<div id="result" class="boxShadow"></div>
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>