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
		<fieldset class="myfields">
		<div><label for="id" id="scaleLabel">id:</label><input type="text" id="id" value="" /></div>
		<div><label for="tokenName" id="scaleLabel">Token Name:</label><input type="text" id="tokenName" value="" required /></div>
		<div><label for="tokenDescription" id="scaleLabel">Token Description:</label><input type="text" id="tokenDescription" value="" required /></div>
		<div><label for="tokenImageUrl" id="scaleLabel">Token Image URL:</label><input type="text" id="tokenImageUrl" value="" required /></div>
		<div><label for="speed" id="scaleLabel">Speed:</label><input type="text" id="speed" value=""/></div>
		<div><label for="optimumNoOfPitstops" id="optimumNoOfPitstopsLabel">Optimum No Of Pitstops:</label><input type="text" id="optimumNoOfPitstops" value=""/></div>
		<input type="button" value="Apply" id="upsertToken"/>
		</fieldset>
		</form>
	</div>
	<div id="result" class="boxShadow"></div>
</div>
</section>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>