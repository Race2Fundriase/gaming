<?php
/*
Template Name: CRON
*/
?>



        CRON Jobs
		<?php 
			$races = get_racesToCRON();
			for($i=0;$i<count($races);$i++) {
				echo("<br/>Race $i<br/>");
				r2f_action_upsert_racecharactersScore($races[$i]->id);
			}
		?>

		<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>