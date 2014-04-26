<?php
/*
Template Name: CRON
*/
?>



        CRON Jobs
		<?php 
			r2f_action_upsert_racecharactersScore();
		?>

		<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>