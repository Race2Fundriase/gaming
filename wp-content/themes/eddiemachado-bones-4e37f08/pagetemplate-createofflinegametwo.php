<?php
/*
 Template Name: Create Offline Game Two
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
                                <div class="text-center"><h1 class="highlight">Create: Offline Game</h1></div>
                                
                            </div>
                                        
                    </div>
            </div>
            
             <div class="fences wrap"></div>
             
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
                <div class="inner-container wrap"> 
			                      
					
					<div>
                        <form id="create-game" action=""><!--start form-->
                                <div class="form-elements">
                                                
                                                <h3><span>Part 2</span></h3>
												<input id="maxNoOfPlayers" name="maxNoOfPlayers" type="hidden" value="" tabindex="3"/> 
                                                <div>
                                                    <label for="nameofrace"><span>Name Of Race:</span></label>
                                                    <div>
                                                    <input id="raceName" name="nameofrace" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="desc"><span>Description Of Race:</span></label>
                                                    <div>
                                                    <textarea id="raceDescription" name="desc" value="" tabindex="2"></textarea>
                                                    </div>
                                                </div>
												
												<div>
                                                    <label for="prizeDesc"><span>Prize:</span></label>
                                                    <div>
                                                    <textarea id="prizeDesc" name="prizeDesc" value="" tabindex="2"></textarea>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="courseselection"><span>Course Selection:</span></label>
                                                    <div>
														<select id="mapId" name="mapId">
															
														</select>
													</div>
                                                </div>
												 <div class="">
												<label for="timeZone"><span>Race Time Zone</span></label>
													<div>
														<select name="timeZone" id="timeZone">
															<option timeZoneId="1" gmtAdjustment="GMT-12:00" useDaylightTime="0" value="-12">(GMT-12:00)</option>
															<option timeZoneId="2" gmtAdjustment="GMT-11:00" useDaylightTime="0" value="-11">(GMT-11:00)</option>
															<option timeZoneId="3" gmtAdjustment="GMT-10:00" useDaylightTime="0" value="-10">(GMT-10:00)</option>
															<option timeZoneId="4" gmtAdjustment="GMT-09:00" useDaylightTime="1" value="-9">(GMT-09:00)</option>
															<option timeZoneId="5" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00)</option>
															<option timeZoneId="6" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00)</option>
															<option timeZoneId="7" gmtAdjustment="GMT-07:00" useDaylightTime="0" value="-7">(GMT-07:00)</option>
															<option timeZoneId="10" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00)</option>
															
															<option timeZoneId="14" gmtAdjustment="GMT-05:00" useDaylightTime="0" value="-5">(GMT-05:00)</option>
															
															<option timeZoneId="17" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00)</option>
															
															<option timeZoneId="21" gmtAdjustment="GMT-03:30" useDaylightTime="1" value="-3.5">(GMT-03:30)</option>
															<option timeZoneId="22" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00)</option>
															
															<option timeZoneId="26" gmtAdjustment="GMT-02:00" useDaylightTime="1" value="-2">(GMT-02:00)</option>
															<option timeZoneId="27" gmtAdjustment="GMT-01:00" useDaylightTime="0" value="-1">(GMT-01:00)</option>
															
															
															<option timeZoneId="30" gmtAdjustment="GMT+00:00" useDaylightTime="1" value="0" selected>(GMT+00:00)</option>
															<option timeZoneId="31" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00)</option>
															
															<option timeZoneId="36" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00)</option>
															
															<option timeZoneId="45" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00)</option>
															
															<option timeZoneId="49" gmtAdjustment="GMT+03:30" useDaylightTime="1" value="3.5">(GMT+03:30)</option>
															<option timeZoneId="50" gmtAdjustment="GMT+04:00" useDaylightTime="0" value="4">(GMT+04:00)</option>
															
															<option timeZoneId="53" gmtAdjustment="GMT+04:30" useDaylightTime="0" value="4.5">(GMT+04:30)</option>
															<option timeZoneId="54" gmtAdjustment="GMT+05:00" useDaylightTime="1" value="5">(GMT+05:00)</option>
															
															<option timeZoneId="56" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30)</option>
															
															<option timeZoneId="58" gmtAdjustment="GMT+05:45" useDaylightTime="0" value="5.75">(GMT+05:45)</option>
															<option timeZoneId="59" gmtAdjustment="GMT+06:00" useDaylightTime="1" value="6">(GMT+06:00)</option>
															
															<option timeZoneId="61" gmtAdjustment="GMT+06:30" useDaylightTime="0" value="6.5">(GMT+06:30)</option>
															<option timeZoneId="62" gmtAdjustment="GMT+07:00" useDaylightTime="0" value="7">(GMT+07:00)</option>
															
															<option timeZoneId="64" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00)</option>
															
															<option timeZoneId="69" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00)</option>
															
															<option timeZoneId="72" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30)</option>
															
															<option timeZoneId="74" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00)</option>
															
															<option timeZoneId="79" gmtAdjustment="GMT+11:00" useDaylightTime="1" value="11">(GMT+11:00)</option>
															<option timeZoneId="80" gmtAdjustment="GMT+12:00" useDaylightTime="1" value="12">(GMT+12:00)</option>
															<option timeZoneId="81" gmtAdjustment="GMT+12:00" useDaylightTime="0" value="12">(GMT+12:00)</option>
															<option timeZoneId="82" gmtAdjustment="GMT+13:00" useDaylightTime="0" value="13">(GMT+13:00)</option>
														</select>		
														Current Time: <span id="currentRaceTime"></span>
													</div>
                                                </div>
                                                <div>
                                                <label for="startDateTime"><span>Start Date</span></label>
                                                    <div>
													<input id="startDateTime" name="startDateTime" type="text" value="" tabindex="12" readonly/>
													<div class="myhidden">Local Time: <span id="localStartDateTime"></span></div>
													</div>
                                                </div>
                                                <input id="startDate" name="startDate" type="hidden" value="" tabindex="12"/>
												<input id="startTime" name="startTime" type="hidden" value="" tabindex="12"/>
												
												<div>
                                                <label for="finishDateTime"><span>Finish Date</span></label>
                                                   <div>
													<input id="finishDateTime" name="finishDateTime" type="text" tabindex="13" readonly/>
													<div class="myhidden">Local Time: <span id="localFinishDateTime"></span></div>
													</div>
                                                </div>
                                                
												<input id="finishDate" name="finishDate" type="hidden" tabindex="13" readonly/>
												<input id="finishTime" name="finishTime" type="hidden" tabindex="13"/>
												<div>
                                                    <label for="entryCurrency"><span>Entry Currency:</span></label>
                                                    <div>
                                                    <select id="entryCurrency" name="entryCurrency">
														<option value="AUD">AUD</option>
														<option value="BRL">BRL</option>
														<option value="CAD">CAD</option>
														<option value="CZK">CZK</option>
														<option value="DKK">DKK</option>
														<option value="EUR">EUR</option>
														<option value="HKD">HKD</option>
														<option value="HUF">HUF</option>
														<option value="ILS">ILS</option>
														<option value="JPY">JPY</option>
														<option value="MYR">MYR</option>
														<option value="MXN">MXN</option>
														<option value="NOK">NOK</option>
														<option value="NZD">NZD</option>
														<option value="PHP">PHP</option>
														<option value="PLN">PLN</option>
														<option value="GBP" selected>GBP</option>
														<option value="RUB">RUB</option>
														<option value="SGD">SGD</option>
														<option value="SEK">SEK</option>
														<option value="CHF">CHF</option>
														<option value="TWD">TWD</option>
														<option value="THB">THB</option>
														<option value="TRY">TRY</option>
														<option value="USD">USD</option>
													</select>
                                                    </div>
                                                </div>
												<div>
                                                    <label for="entryprice"><span>Entry Price:</span></label>
                                                    <div>
                                                    <input id="entryPrice" name="entryprice" type="text" value="" tabindex="3"/> 
                                                    </div>
                                                </div>
												<div>
                                                    <label for="nameofrace"><span>Private Race? (If you select private race your race will not be listed publicly on the website):</span></label>
                                                    <div>
                                                    <select id="private" name="private">
														<option value="0">No</option>
														<option value="1">Yes</option>
													</select>
                                                    </div>
                                                </div>
												
												<div class="myhidden"> 
													<label for="raceTokens"><span>Select Tokens</span></label>
													<div>
														<select multiple id="raceTokens" name="raceTokens">
														</select>
													</div>
												</div>
												<div align="center" class="highlight">Select tokens your players can use</div>
												<div>
													<label for="tokenCategories"><span>Category</span></label>
													<div>
														<select id="tokenCategories" name="tokenCategories">
														</select>
													</div>
												</div>
												
												<div class="clearfix" id="raceTokenResults">
													
												</div>

                                            <input name="token" type="hidden" value="a2"/>
                                            
                                           
                                            <div class="text-center continue"><input type="submit" value="continue" id="continue" class="btn large"/></div>
												
                                </div>
                        </form>
					</div>
                 </div>

            </div>
					<div id="templateDiv" style="display: none">
						<div class="threecol token" id="wrapper_{index}" data-selection="{tokenId}">
							<a href="#" class="optionselect" data-selection="{tokenId}" id="token_{tokenId}">
								<img src="{imageUrl}"/>
							</a>
							<div class="text-center"><p class="highlight">{tokenName}</p></div>
						</div>
					</div>
					

		   
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>