<?php
/*
Template Name: Voucher Admin
*/

if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content">

	<br/>
	<div id="voucherDataGrid" class="boxShadow">
		<table id="list2"></table>
		<div id="pager2"></div>
	</div>
	<div id="voucherOptions" class="boxShadow">
		<H2>Voucher Options</h2>
		<form id="dataForm">
		<div class="form-elements">
		<div><label for="id" id="idLabel"><span>id:</span></label><input type="text" id="id" value=""  /></div>
		<div><label for="voucherCode" id="voucherCodeLabel"><span>Voucher Code:</span></label><input type="text" id="voucherCode" value="" required /></div>
		<div><label for="maxUses" id="maxUsesLabel"><span>Max Uses:</span></label><input type="text" id="maxUses" value="" required /></div>
		<div><label for="uses" id="usesLabel"><span>Uses:</span></label><input type="text" id="uses" value=""  /></div>
		<div><label for="expires" id="expiresLabel"><span>Expires:</span></label><input type="text" id="expires" value=""  /></div>
		<div><label for="discount_amount" id="discount_amountLabel"><span>Discount Amount:</span></label><input type="text" id="discount_amount" value=""  /></div>
		<div><label for="discount_percent" id="discount_percentLabel"><span>Discount Percent:</span></label><input type="text" id="discount_percent" value=""  /></div>
		<input type="button" value="Apply" id="upsertVoucher"/>
		</div>
		</form>
	</div>
	<div id="result" class="boxShadow"></div>
</div>
</section>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>