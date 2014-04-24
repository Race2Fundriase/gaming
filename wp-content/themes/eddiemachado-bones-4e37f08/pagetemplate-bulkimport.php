<?php
/*
 Template Name: Bulk Import
 */
 
 if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
?>

<?php get_header(); ?>
        <div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Bulk Import</h1></div>
                                

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
                                                    <label for="playersCSV"><span>Players CSV:</span></label>
                                                    <div>
													<textarea name="playersCSV" id="playersCSV" rows="10" cols="40"></textarea>
                                                    
                                                    </div>
													
                                                </div>
         
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue" class="btn large"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
            
			
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>