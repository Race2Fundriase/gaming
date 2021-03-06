<?php
/*
 Template Name: Bulk Import
 */
 
 if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>
<style>select {padding: 0!important; width: 100%!important; background-image: none!important; -webkit-appearance: normal!important; -moz-appearance: normal!important;</style>
<?php get_header(); ?>
        <div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Upload Players for Offline Race</h1></div>
                                <div class="text-center"><h1 class="highlight" id="raceName"></h1></div>

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
                                            
												<div>
                                                    <label for="playersCSV"><span>Players:</span></label>
                                                    <div>
														<table id="inputTable" width="100%">
															<tr class="highligh">
																<td width="40%">Player Name</td>
																<td width="20%">Token</td>
																<td width="15%">Driving Style</td>
																<td width="15%">Pitstops</td>
															</tr>
														</table>
                                                    
                                                    </div>
													
                                                </div>
											
                                                <div class="myhidden">
                                                    <label for="playersCSV"><span>Players CSV:</span></label>
                                                    <div>
													<textarea name="playersCSV" id="playersCSV" rows="10" cols="40"></textarea>
                                                    
                                                    </div>
													
                                                </div>
         <!--Row format: Player Name&lt;tab&gtToken Name&lt;tab&gtDriving Style Weight (0.0-1.0)&lt;tab&gtNo Of Pitstops (0-10)-->
                                            <div class="text-center continue"><input type="submit" value="save & continue" id="continue" class="btn large"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
						<div>
						
						
						</div>
                </div><!--End Inner Container-->
            </div><!--End Container-->
            
			
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>