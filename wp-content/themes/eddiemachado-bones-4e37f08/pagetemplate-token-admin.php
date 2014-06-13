<?php
/*
Template Name: Token Admin
*/

if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content">

	<br/>
	<div id="tokenDataGrid" class="boxShadow">
		<table id="list2"></table>
		<div id="pager2"></div>
	</div>
	<div id="tokenOptions" class="boxShadow">
		<H2>Token Options</h2>
		<form id="dataForm">
		<div class="form-elements">
		<div>
			<label for="curDay"><span>id</span></label>
			<div>
			<input id="id" name="id" type="text" tabindex="13"/>
			</div>
		</div>
		<div><label for="tokenName" id="scaleLabel"><span>Token Name:</span></label><input type="text" id="tokenName" value="" required /></div>
		<div><label for="tokenDescription" id="scaleLabel"><span>Token Description:</span></label><input type="text" id="tokenDescription" value="" required /></div>
		<div><label for="tokenImageUrl" id="scaleLabel"><span>Token Image URL:</span></label><input type="text" id="tokenImageUrl" value="" required /></div>
		<div><label for="speed" id="scaleLabel"><span>Speed:</span></label><input type="text" id="speed" value=""/></div>
		<div><label for="optimumNoOfPitstops" id="optimumNoOfPitstopsLabel"><span>Optimum No Of Pitstops:</span></label><input type="text" id="optimumNoOfPitstops" value=""/></div>
		<div><label for="weatherTolerance" id="weatherToleranceLabel"><span>Weather Tolerance:</span></label><input type="text" id="weatherTolerance" value=""/></div>
		<input type="button" value="Apply" id="upsertToken"/>
		<input type="button" value="Duplicate" id="duplicateToken"/>
		</div>
		</form>
	</div>
	<div id="result" class="boxShadow"></div>
</div>
</section>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>