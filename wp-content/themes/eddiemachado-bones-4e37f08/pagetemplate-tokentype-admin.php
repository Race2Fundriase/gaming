<?php
/*
Template Name: Token Type Admin
*/

if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content">

	<br/>
	<div id="tokenTypeDataGrid" class="boxShadow" align="center">
		<table id="list2"></table>
		<div id="pager2"></div>
	</div>
	<div id="tokenOptions" class="boxShadow">
		<H2>Token Type Options</h2>
		<form id="dataForm">
		<div class="form-elements">
		<div>
			<label for="curDay"><span>id</span></label>
			<div>
			<input id="id" name="id" type="text" tabindex="13"/>
			</div>
		</div>
		<div><label for="typeDesc" id="typeDescLabel"><span>Type Desc:</span></label><input type="text" id="typeDesc" value="" required /></div>
		<input type="button" value="Apply" id="upsertTokenType"/>
		</div>
		</form>
	</div>
	<div id="result" class="boxShadow"></div>
</div>
</section>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>