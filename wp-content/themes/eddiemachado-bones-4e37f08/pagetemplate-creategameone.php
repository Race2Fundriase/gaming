<?php
/*
 Template Name: Create Game One
 */
 
 if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
 
 $title = get_the_title();
 
 if (strpos($title, "Offline") === FALSE) {
 ?>
 <script>offline = 0;</script>
 <?php
 } else {
 ?>
 <script>offline = 1;</script>
 <?php
 }
 
?>

<?php get_header(); ?>
        <div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Create: <span id="gameType"></span> Game</h1></div>
                                
                                <div class="text-center"><p class="highlight">Select payment method:</p></div>
                                
                                <ul id="tab_control" class="tab_control">
                                     <li><a href="#" class="btn btn-blue large active">Buy Race</a></li>
                                     <li><a href="#" class="btn large">Buy Subscriptions</a></li>
                                      
                                </ul>
                        </div>
                                        
                </div>
        </div>
        
        <div class="fences wrap"></div>
             <!--FORM OPTION 1-->
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content active">
                <div class="inner-container wrap">
                        <div class="form-elements">
                                                <h3><span>Part 1a</span></h3>
                                                
                                                <input name="token" type="hidden" value="a"/>
                                            
                                                <div class="clearfix">
                                                    <div class="fourcol first token text-right">
                                                        <a href="#" class="optionselect active" data-selection="50" data-price="20" id="race_1">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/bike.jpg"/>
                                                        </a>
                                                        <div class="text-center"><p class="highlight">50 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol token">
                                                        <a href="#" class="optionselect" data-selection="100" data-price="35" id="race_2">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/car.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">100 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol last token">
                                                        <a href="#" class="optionselect" data-selection="350" data-price="75" id="race_3">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/plane.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">350 TOKENS</p></div>
                                                    </div>
                                                </div>
												
												<div class="clearfix">
                                                    <div class="fourcol first token text-right">
                                                        <a href="#" class="optionselect active" data-selection="1000" data-price="125" id="race_4">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/horse.jpg"/>
                                                        </a>
                                                        <div class="text-center"><p class="highlight">1000 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol token">
                                                        <a href="#" class="optionselect" data-selection="5000" data-price="225" id="race_5">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/motorbike.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">5000 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol last token">
                                                        <a href="#" class="optionselect" data-selection="10000" data-price="325" id="race_6">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/old-plane.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">10000 TOKENS</p></div>
                                                    </div>
                                                </div>
												
												<div class="clearfix">
                                                    <div class="fourcol first token text-right">
                                                        <a href="#" class="optionselect active" data-selection="15000" data-price="395" id="race_7">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/atv.jpg"/>
                                                        </a>
                                                        <div class="text-center"><p class="highlight">15000 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol last token">
                                                        <a href="#" class="optionselect" data-selection="25000" data-price="450" id="race_8">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/balloon.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">25000 TOKENS</p></div>
                                                    </div>
                                                    
                                                    
                                                </div>
                                            
                                                <div>
                                                    <label for="tokenamount_race"><span>Custom amount of tokens:</span></label>
                                                    <div>
                                                    <input name="tokenamount_race" id="tokenamount_race" type="text" value="" tabindex="1"/> 
                                                    </div>
													<label for="tokenprice_race"><span>Price (&pound;):</span></label>
                                                    <div>
                                                    <input name="tokenprice_race" id="tokenprice_race" type="text" value="" tabindex="1"  readonly="readonly"/> 
                                                    </div>
													<label for="voucherCode"><span>Voucher Code:</span></label>
													<div>
                                                    <input name="voucherCode" id="voucherCode" type="text" value="" tabindex="1"  /> 
                                                    </div>
                                                </div>
         
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue_race" class="btn large"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
            <!--FORM OPTION 2-->
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content ">
                <div class="inner-container wrap">
                        <div class="form-elements">
                                                <h3><span>Part 1b</span></h3>
                                                
                                                <input name="token" type="hidden" value="a"/>
                                            
                                                <div class="clearfix">
                                                    <div class="fourcol first token text-right">
                                                        <a href="#" class="optionselect active" data-selection="1000" data-price="350" id="sub_1">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/bike.jpg"/>
                                                        </a>
                                                        <div class="text-center"><p class="highlight">Unlimited games with up to 1000 players (&pound;350) for 12 months</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol token">
                                                        <a href="#" class="optionselect" data-selection="5000" data-price="550" id="sub_2">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/car.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">Unlimited games with up to 15000 players (&pound;550) for 12 months</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol last token">
                                                        <a href="#" class="optionselect" data-selection="25000" data-price="1100" id="sub_3">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/tokens/plane.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">Unlimited games with up to 25000 players(&pound;1100) for 12 months</p></div>
                                                    </div>
                                                </div>
                                            
                                                <div >
                                                    <label for="tokenamount"><span>Max Players:</span></label>
                                                    <div>
                                                    <input name="tokenamount_sub" id="tokenamount_sub" type="text" value="" tabindex="1"  readonly="readonly"/> 
													</div>
													<label for="tokenamount"><span>Price (&pound;):</span></label>
													<div>
													<input name="tokenprice_sub" id="tokenprice_sub" type="text" value="" tabindex="1"  readonly="readonly"/> 
                                                    </div>
                                                </div>
         
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue_sub" class="btn large"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
             <!--FORM OPTION 3-->
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content ">
                <div class="inner-container wrap">
                        <div class="form-elements">
                                                <h3><span>Part 1c</span></h3>
                                                
                                                <input name="token" type="hidden" value="a"/>
                                            
                                                <div class="clearfix">
                                                    <div class="fourcol first token text-right">
                                                        <a href="#" class="optionselect active" data-selection="10">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                        </a>
                                                        <div class="text-center"><p class="highlight">10 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol token">
                                                        <a href="#" class="optionselect" data-selection="20">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">20 TOKENS</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol last token">
                                                        <a href="#" class="optionselect" data-selection="30">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">20 TOKENS</p></div>
                                                    </div>
                                                </div>
                                            
                                                <div>
                                                    <label for="tokenamount"><span>Custom amount of tokens:</span></label>
                                                    <div>
                                                    <input name="tokenamount" type="text" value="" tabindex="1"/> 
                                                    </div>
                                                </div>
         
                                            <div class="text-center continue"><input type="submit" value="continue" class="btn large"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal_form" style="display: none">
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="david@edupayment.co.uk" id="business">
			<input type="hidden" name="item_name" value="" id="item_name">
			<input type="hidden" name="item_number" id="item_number" value="">
			<input type="hidden" name="amount" value="1.50" id="amount">
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
			<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypal_form_sub" style="display: none">
				<input type="hidden" name="cmd" value="_xclick-subscriptions">
				<input type="hidden" name="business" value="david@edupayment.co.uk">
				<input type="hidden" name="currency_code" value="GBP">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="item_name" value="" id="item_name_sub">
				<input type="hidden" name="item_number" id="item_number_sub" value="">
				<input type="image" src="http://www.paypal.com/en_GB/i/btn/x-click-but20.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
				<input type="hidden" name="a3" value="5.00" id="a3">
				<input type="hidden" name="p3" value="1" id="p3">
				<input type="hidden" name="t3" value="M" id="t3">
				<input type="hidden" name="src" value="1">
				<input type="hidden" name="sra" value="1">
				
				<input type="hidden" name="return" id="return_sub" value=""/>
				<input type="hidden" name="cancel_return" id="cancel_return_sub" value="<?=site_url()?>"/>
				<input type="hidden" name="notify_url" id="notify_url_sub" value="<?=site_url()?>"/>

			</form>
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>