<?php
/*
Template Name: Complete Race
*/
?>

<?php get_header(); ?>
        <section>
            <div class="slider secondary clearfix">
                    
                            <img src="<?php echo get_template_directory_uri(); ?>/library/images/slide1.jpg" alt=""/>
                    
                    <div class="inner-slider wrap">
                            <div id="logo" class="secondary">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/r2fhomelogo.png" alt="" />
                            </div>
                    </div>
                    
            </div>
	</section>
	<div class="wide-fence why wrap"></div>
        
        <section>
	    <div class="container pad-top sand bot-bg-grass">
		<div class="inner-container wrap clearfix">
                    <div>
		    <h1 class="highlight"><?php the_title(); ?></h1>
                    </div>
                    
                    <div id="complete-race-header">
                        <div id="other-search">
                            <?php $search_text = "Search Races"; ?> 
                            <form method="get" id="racesearch"  action=""> 
                                
                                <input type="text" value="<?php echo $search_text; ?>"  
                                name="race-s" id="race-s"  
                                onblur="if (this.value == '')  
                                {this.value = '<?php echo $search_text; ?>';}"  
                                onfocus="if (this.value == '<?php echo $search_text; ?>')  
                                {this.value = '';}" /> 
                                
                                <input type="hidden" id="racesearchsubmit" /> 
                            </form>
                        </div>
                        <div class="info">
                            <div class="headings"><p class="highlight">Start</p><p class="highlight">Finish</p></div>
                            <div class="dates"><time datetime="2013-08-08" class="highlight">08/08/13</time><time datetime="2013-08-13" class="highlight">15/08/13</time></div>
                        </div>
                        <img src="<?php echo get_template_directory_uri(); ?>/library/images/active-race-page-test-image.jpg" alt="" />
                    </div>
                </div> 
	    </div>
	</section>
        
        <section>
            <div class="container grit bot-bg">
                <div class="inner-container wrap clearfix">
                    <h1 class="winner">WINNER:<span class="name"> Tom </span> with the <span class="vehicle">Motorbike</span></h1>
                    <div class="sevencol first">
                        <h2 class="highlight">Race To The North Pole</h2>
                        
                        <div id="race-data">
                            <p class="highlight">Race To North Pole</p>
                            <dl class="conditions">
                                <!--Removing closing /dt closes the gap between inline elements valid HTML5-->
                                <dt>Location:
                                <dd> North Pole</dd>
                                <dt>Terrain:
                                <dd> Icy, Rough</dd>
                                <dt>Weather:
                                <dd>Cold, Snowy</dd>
                            </dl>
                            <p class="highlight">Prize: Spa Weekend</p>
                            
                            <div class="characters clearfix">
                                
                            <div><h3 class="highlight">Characters Available</h3></div>
                            
                                <div class="fourcol first">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/active_race_test_vehicle.jpg" alt="" />
                                    <br/>
                                    <p class="highlight">Car</p>
                                </div>
                                <div class="fourcol">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/active_race_test_vehicle.jpg" alt="" />
                                    <br/>
                                    <p class="highlight">Car</p>
                                </div>
                                <div class="fourcol last">
                                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/active_race_test_vehicle.jpg" alt="" />
                                    <br/>
                                    <p class="highlight">Car</p>
                                </div>
                            </div>
                            
                            <div class="leaderboard clearfix">
                                <div><h3 class="highlight">Leaderboard</h3></div>
                              
                                <table class="responsive">
                                    <thead>
                                        <tr>
                                        <th>No.</th>
                                        <th>Player</th>
                                        <th>Token</th>
                                        <th>Driving Style</th>
                                        <th>Pitstops</th>
                                        <th>Distance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tom</td>
                                            <td>Motorbike</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>10</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Gary</td>
                                            <td>Sledge</td>
                                            <td>4</td>
                                            <td>1</td>
                                            <td>9</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Aaron</td>
                                            <td>Hot Air Balloon</td>
                                            <td>2</td>
                                            <td>2</td>
                                            <td>8</td>
                                        </tr>
                                    </tbody>
                                </table>
                            
                            </div>
                        </div>
                    </div>
                    
                    <aside id="profile-excerpt" class="fivecol last">
                        <div><h3 class="highlight">Chauncy Maples Malawi Trust</h3></div>
                        <p class="highlight">Lorem ipsum dolor sit amet, maiores ornare ac fermentum, imperdiet ut vivamus a, nam lectus at nunc. Quam euismod sem, semper ut potenti pellentespellentesque quisque.</p>
                        <div><br/><p class="highlight">Find out more:</p></div>
                        <div><br/><p class="highlight">Website:<a href="#">www.url.com</a></p></div>
                        <div><p class="highlight">Facebook:<a href="#">www.facebook.com/yourfacebook</a></p></div>
                        <div><p class="highlight">Twitter:<a href="#">www.twitter.com/user</a></p></div>
                        <div class="profile-view"><a class="btn small center" href="#">Profile Page</a></div>
                    </aside>
                </div>
            </div>
        </section>
<?php get_footer(); ?>

