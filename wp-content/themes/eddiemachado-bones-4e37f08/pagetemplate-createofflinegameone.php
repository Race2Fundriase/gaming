<?php
/*
 Template Name: Create Offline Game One
 */
 
 if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>
<br/><br/><br/><br/>
			
             <!--FORM OPTION 1-->
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content active">
                <div class="inner-container wrap">
                        <div class="form-elements">
                                                <h3><span>Part 1a</span></h3>
                                                
                                                <input name="token" type="hidden" value="a"/>
                                            
                                                <div >
													<h3 class="highlight">Buy a Single Race</h3>
													<table align="center" width="60%">
														<tr class="highlight"><th width="60%">Maximum Players</th><th>&pound;</th><th>Click to Buy</th></tr>
														<tr style="color: white;"><td>for up to 4 players</td><td align="center">Free</td><td align="center" width="15%"><input data-selection="4" data-price="0" type="submit" value="Buy" id="buy_1" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 50 players</td><td align="center">20</td><td align="center" width="15%"><input data-selection="50" data-price="20" type="submit" value="Buy" id="buy_2" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 100 players</td><td align="center">35</td><td align="center" width="15%"><input data-selection="100" data-price="35" type="submit" value="Buy" id="buy_3" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 350 players</td><td align="center">75</td><td align="center" width="15%"><input data-selection="350" data-price="75" type="submit" value="Buy" id="buy_4" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 1000 players</td><td align="center">125</td><td align="center" width="15%"><input data-selection="1000" data-price="125" type="submit" value="Buy" id="buy_5" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 5000 players</td><td align="center">225</td><td align="center" width="15%"><input data-selection="5000" data-price="225" type="submit" value="Buy" id="buy_6" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 10000 players</td><td align="center">325</td><td align="center" width="15%"><input data-selection="10000" data-price="325" type="submit" value="Buy" id="buy_7" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 15000 players</td><td align="center">395</td><td align="center" width="15%"><input data-selection="15000" data-price="395" type="submit" value="Buy" id="buy_8" class="btn"/></td></tr>
														<tr style="color: white;"><td>for up to 25000 players</td><td align="center">450</td><td align="center" width="15%"><input data-selection="25000" data-price="450" type="submit" value="Buy" id="buy_9" class="btn"/></td></tr>
														
													</table>
												</div>
                                            
                                                <div class="myhidden" id="details">
                                                    <label for="tokenamount_race"><span>Custom amount of tokens:</span></label>
                                                    <div>
                                                    <input name="tokenamount_race" id="tokenamount_race" type="text" value="" tabindex="1"/> 
                                                    </div>
													<label for="tokenprice_race"><span>Price (&pound;):</span></label>
                                                    <div>
                                                    <input name="tokenprice_race" id="tokenprice_race" type="text" value="" tabindex="1" readonly/> 
                                                    </div>
													<label for="voucherCode"><span>Voucher Code:</span></label>
													<div>
                                                    <input name="voucherCode" id="voucherCode" type="text" value="" tabindex="1"  /> 
                                                    </div>
													<div class="text-center continue"><input type="submit" value="continue" id="continue_race" class="btn large"/></div>
                                                </div>
         <div>
													<h3 class="highlight">Buy a 12  month subscription (for unlimited online and offline games to be run within 12 months)</h3>
													<table align="center" width="60%">
														<tr class="highlight"><th width="60%">Maximum Players</th><th>&pound;</th><th>Click to Buy</th></tr>
														<tr style="color: white;"><td>Unlimited games with up to 1000 players for 12 months</td><td align="center">350</td><td align="center" width="15%"><input data-selection="1000" data-price="350" type="submit" value="Buy" id="sub_1" class="btn"/></td></tr>
														<tr style="color: white;"><td>Unlimited games with up to 15000 players for 12 months</td><td align="center">550</td><td align="center" width="15%"><input data-selection="15000" data-price="550" type="submit" value="Buy" id="sub_2" class="btn"/></td></tr>
														<tr style="color: white;"><td>Unlimited games with up to 25000 players for 12 months</td><td align="center">1100</td><td align="center" width="15%"><input data-selection="25000" data-price="1100" type="submit" value="Buy" id="sub_3" class="btn"/></td></tr>
														
													</table>


														</div>
                                            
                                                
												
												<div class="myhidden" id="details_sub">
                                                    <label for="tokenamount"><span>Max Players:</span></label>
                                                    <div>
                                                    <input name="tokenamount_sub" id="tokenamount_sub" type="text" value="" tabindex="1"  readonly="readonly"/> 
													</div>
													<label for="tokenamount"><span>Price (&pound;):</span></label>
													<div>
													<input name="tokenprice_sub" id="tokenprice_sub" type="text" value="" tabindex="1"  readonly="readonly"/> 
                                                    </div>
													<div class="text-center continue"><input type="submit" value="continue" id="continue_sub" class="btn large"/></div>
                                                </div>
                                            
   <br/><br/><br/><br/><br/><br/>                               
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
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                        </a>
                                                        <div class="text-center"><p class="highlight">Unlimited games with upto 1000 players (&pound;350)</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol token">
                                                        <a href="#" class="optionselect" data-selection="5000" data-price="550" id="sub_2">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">Unlimited games with upto 15000 players (&pound;550)</p></div>
                                                    </div>
                                                    
                                                    <div class="fourcol last token">
                                                        <a href="#" class="optionselect" data-selection="25000" data-price="1100" id="sub_3">
                                                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                        </a>
                                                         <div class="text-center"><p class="highlight">Unlimited games with upto 25000 players(&pound;1100)</p></div>
                                                    </div>
                                                </div>
                                            
                                                <div >
                                                    <label for="tokenamount"><span>Max Players:</span></label>
                                                    <div>
                                                    <input name="tokenamount_sub" id="tokenamount_sub" type="text" value="" tabindex="1" readonly/> 
													</div>
													<label for="tokenamount"><span>Price (&pound;):</span></label>
													<div>
													<input name="tokenprice_sub" id="tokenprice_sub" type="text" value="" tabindex="1" readonly/> 
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
			<input type="hidden" name="item_name"
			value="" id="item_name">
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
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>