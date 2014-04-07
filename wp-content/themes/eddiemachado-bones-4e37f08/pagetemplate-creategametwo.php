<?php
/*
 Template Name: Create Game Two
 */
?>

<?php get_header(); ?>
        
            <div class="container sand bot-bg clearfix nav-margin">
                    <div class="inner-container wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/Logo-Wooden.gif" alt="" />
                            </div>
                            <div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Create: Online Game</h1></div>
                                
                                <div class="text-center"><p class="highlight">Select your online game payment method below:</p></div>
                                
                                <ul id="tab_control" class="tab_control">
                                     <li><a href="#" class="btn btn-blue large active">Paypal</a></li>
                                     <li><a href="#" class="btn large">Just Giving</a></li>
                                </ul>
                                
                               <p class="text-center orange-type">Don't have a paypal account? sign up for one <a href="#">here</a></p>
                            </div>
                                        
                    </div>
            </div>
            
             <div class="fences wrap"></div>
             
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content active">
                <div class="inner-container wrap">                           
                        <form id="create-game" action=""><!--start form-->
                                        <div class="form-elements">
                                                <h3><span>Part 2</span></h3>
                                             
                                                <div>
                                                    <label for="merchantemail"><span>Merchant E-mail:</span></label>
                                                    <div>
                                                    <input name="merchantemail" type="email" value="" tabindex="1"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="adminemail"><span>Profile Name:</span></label>
                                                    <div>
                                                    <input name="adminemail" type="email" value="" tabindex="2"/>
                                                    </div>
                                                </div>
                                                
                                                <h3><span>Part 3</span></h3>
                                             
                                                <div>
                                                    <label for="nameofrace"><span>Name Of Race:</span></label>
                                                    <div>
                                                    <input name="nameofrace" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="desc"><span>Description Of Race:</span></label>
                                                    <div>
                                                    <textarea name="desc" value="" tabindex="2"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="courseselection"><span>Course Selection:</span></label>
                                                    <div>
                                                    <input name="courseselection" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                <label for="startdate"><span>Start Date</span></label>
                                                    <div>
                                                    <select name="startdate" tabindex="11">
                                                        <option value="">Date...</option>
                                                        <option value="20-20-20">20/10/20</option>
                                                        
                                                    </select>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                <label for="finishdate"><span>Finish Date</span></label>
                                                    <div>
                                                    <select name="finishdate" tabindex="11">
                                                        <option value="">Date...</option>
                                                        <option value="07-03-2014">07/03/2014</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="entryprice"><span>Entry Price:</span></label>
                                                    <div>
                                                    <input name="entryprice" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                            
                                            <input name="token" type="hidden" value="a"/>
                                            
                                            <div class="clearfix">
                                            <div class="fourcol first token">
                                                <a href="#" class="vehicleselect active" data-selection="a">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol token">
                                                <a href="#" class="vehicleselect" data-selection="b">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol last token">
                                                <a href="#" class="vehicleselect" data-selection="c">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol first token">
                                                <a href="#" class="vehicleselect" data-selection="d">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol token">
                                                <a href="#" class="vehicleselect" data-selection="e">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol last token">
                                                <a href="#" class="vehicleselect" data-selection="f">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            </div>
                                                  
                                            <div class="text-center continue"><input type="submit" value="continue" class="btn large"/></div>
                                        </div>
                        </form>
                 </div>
            </div>
            
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix tabbed_content">
                <div class="inner-container wrap">                           
                        <form id="create-game" action=""><!--start form-->
                                <div class="form-elements">
                                                <h3><span>Part 2</span></h3>
                                             
                                                <div>
                                                    <label for="merchantemail"><span>Merchant E-mail:</span></label>
                                                    <div>
                                                    <input name="merchantemail" type="email" value="" tabindex="1"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="adminemail"><span>Profile Name:</span></label>
                                                    <div>
                                                    <input name="adminemail" type="email" value="" tabindex="2"/>
                                                    </div>
                                                </div>
                                                
                                                <h3><span>Part 3</span></h3>
                                             
                                                <div>
                                                    <label for="nameofrace"><span>Name Of Race:</span></label>
                                                    <div>
                                                    <input name="nameofrace" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="desc"><span>Description Of Race:</span></label>
                                                    <div>
                                                    <textarea name="desc" value="" tabindex="2"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="courseselection"><span>Course Selection:</span></label>
                                                    <div>
                                                    <input name="courseselection" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                <label for="startdate"><span>Start Date</span></label>
                                                    <div>
                                                    <select name="startdate" tabindex="11">
                                                        <option value="">Date...</option>
                                                        <option value="20-20-20">20/10/20</option>
                                                        
                                                    </select>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                <label for="finishdate"><span>Finish Date</span></label>
                                                    <div>
                                                    <select name="finishdate" tabindex="11">
                                                        <option value="">Date...</option>
                                                        <option value="07-03-2014">07/03/2014</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="entryprice"><span>Entry Price:</span></label>
                                                    <div>
                                                    <input name="entryprice" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                            
                                            <input name="token" type="hidden" value="a2"/>
                                            
                                            <div class="clearfix">
                                            <div class="fourcol first token">
                                                <a href="#" class="vehicleselect" data-selection="a2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol token">
                                                <a href="#" class="vehicleselect active" data-selection="b2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol last token">
                                                <a href="#" class="vehicleselect" data-selection="c2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol first token">
                                                <a href="#" class="vehicleselect" data-selection="d2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol token">
                                                <a href="#" class="vehicleselect" data-selection="e2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            
                                            <div class="fourcol last token">
                                                <a href="#" class="vehicleselect" data-selection="f2">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/token-test-image.jpg"/>
                                                </a>
                                            </div>
                                            </div>
                                                  
                                            <div class="text-center continue"><input type="submit" value="continue" class="btn large"/></div>
                        
                                </div>
                        </form>
                 </div>
            </div>
           
            
<?php get_footer(); ?>