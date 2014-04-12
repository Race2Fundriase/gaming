<?php
/*
Template Name: Purchase Token
*/
?>

<?php get_header(); ?>
        <section>
            <div class="slider secondary clearfix">
                    
                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/slide1.jpg" alt=""/>
                    
                    <div class="inner-slider wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/Logo-Wooden.gif" alt="" />
                            </div>
                    </div>
                    
            </div>
	</section>
	<div class="wide-fence why wrap"></div>
        
        <section>
	    <div class="container pad-top sand bot-bg-grass">
		<div class="inner-container wrap clearfix">
                    <div>
		    <h1 class="highlight">Purchase Token</h1>
                    </div>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="" id="business">
<input type="hidden" name="item_name"
value="Race2Fundraise Race Token">
<input type="hidden" name="item_number" id="item_number" value="TOKEN">
<input type="hidden" name="amount" value="1.50">
<input type="hidden" name="tax" value="0">
<input type="hidden" name="quantity" value="1">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="GBP">


<input type="hidden" name="return" id="return" value=""/>
<input type="hidden" name="cancel_return" id="cancel_return" value="<?=site_url()?>"/>
<input type="hidden" name="notify_url" id="notify_url" value="<?=site_url()?>"/>
<input type="image" name="submit" border="0"
src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
alt="PayPal - The safer, easier way to pay online">
</form>
                    <div id="active-race-header">
                        <div class="info">
                        </div>
                        
						</div>
                    </div>
                </div> 
	    
		</div>
	</section>
        
<?php get_footer(); ?>

<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>
