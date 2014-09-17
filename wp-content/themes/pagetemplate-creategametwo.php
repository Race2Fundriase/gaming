<?php
/*
 Template Name: Create Game Two
 */
 
 if (!check_security(basename(__FILE__, '.php'))) wp_redirect( get_option( 'siteurl' ) );
 
?>

<?php get_header(); ?>
        
        
           
        <br/><br/><br/><br/>
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
			<div id="create-race-header">
                                <div class="text-center"><h1 class="highlight">Create: Online Game</h1></div>
                                
                               <!-- <div class="text-center"><p class="highlight">Select your online game payment method below:</p></div>-->
                                
<!--                                <ul id="tab_control" class="tab_control">
                                     <li><a href="#" class="btn btn-blue large active">Paypal</a></li>-->
                                     <!--<li><a href="#" class="btn large">Just Giving</a></li>-->
                                <!--</ul>-->
                                
                               <p class="text-center orange-type">Don't have a paypal account? sign up for one <a href="#">here</a></p>
                            </div>
                <div class="inner-container wrap"> 
			<div class="tabbed_content active">
                        <form id="create-game" action=""><!--start form-->
                                        <div class="form-elements">
                                                <h3><span>Part 2</span></h3>
                                             
                                                <div>
                                                    <label for="merchantemail"><span>Email address registered for paypal payments:</span></label>
                                                    <div>
                                                    <input name="merchantemail" id="paymentMethodEmail" type="email" value="" tabindex="1" placeholder="this is where your money will be sent"/> 
                                                    </div>
                                                </div>
                                        </div>
                        </form>
			</div>
					
			<div class="tabbed_content">
			<form id="create-game" action=""><!--start form-->
					<div class="form-elements">
                                                <h3><span>Part 2</span></h3>
                                             
                                                <div>
                                                    <label for="merchantemail"><span>Just Giving Charity ID:</span></label>
                                                    <div>
                                                    <input name="merchantemail" id="justGivingCharityId" type="text" value="" tabindex="1"/> 
                                                    </div>
                                                </div>
					</div>	
			</form>                
			</div>
                       
					
					<div>
                        <form id="create-game" action=""><!--start form-->
                                <div class="form-elements">
                                                
                                                <h3><span>Part 3</span></h3>
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
                                                    <label for="prizeDesc"><span>Prize (optional):</span></label>
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
															<option timeZoneId="1" gmtAdjustment="GMT-12:00" useDaylightTime="0" value="-12">(GMT-12:00) International Date Line West</option>
															<option timeZoneId="2" gmtAdjustment="GMT-11:00" useDaylightTime="0" value="-11">(GMT-11:00) Midway Island, Samoa</option>
															<option timeZoneId="3" gmtAdjustment="GMT-10:00" useDaylightTime="0" value="-10">(GMT-10:00) Hawaii</option>
															<option timeZoneId="4" gmtAdjustment="GMT-09:00" useDaylightTime="1" value="-9">(GMT-09:00) Alaska</option>
															<option timeZoneId="5" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
															<option timeZoneId="6" gmtAdjustment="GMT-08:00" useDaylightTime="1" value="-8">(GMT-08:00) Tijuana, Baja California</option>
															<option timeZoneId="7" gmtAdjustment="GMT-07:00" useDaylightTime="0" value="-7">(GMT-07:00) Arizona</option>
															<option timeZoneId="8" gmtAdjustment="GMT-07:00" useDaylightTime="1" value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
															<option timeZoneId="9" gmtAdjustment="GMT-07:00" useDaylightTime="1" value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
															<option timeZoneId="10" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00) Central America</option>
															<option timeZoneId="11" gmtAdjustment="GMT-06:00" useDaylightTime="1" value="-6">(GMT-06:00) Central Time (US & Canada)</option>
															<option timeZoneId="12" gmtAdjustment="GMT-06:00" useDaylightTime="1" value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
															<option timeZoneId="13" gmtAdjustment="GMT-06:00" useDaylightTime="0" value="-6">(GMT-06:00) Saskatchewan</option>
															<option timeZoneId="14" gmtAdjustment="GMT-05:00" useDaylightTime="0" value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
															<option timeZoneId="15" gmtAdjustment="GMT-05:00" useDaylightTime="1" value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
															<option timeZoneId="16" gmtAdjustment="GMT-05:00" useDaylightTime="1" value="-5">(GMT-05:00) Indiana (East)</option>
															<option timeZoneId="17" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
															<option timeZoneId="18" gmtAdjustment="GMT-04:00" useDaylightTime="0" value="-4">(GMT-04:00) Caracas, La Paz</option>
															<option timeZoneId="19" gmtAdjustment="GMT-04:00" useDaylightTime="0" value="-4">(GMT-04:00) Manaus</option>
															<option timeZoneId="20" gmtAdjustment="GMT-04:00" useDaylightTime="1" value="-4">(GMT-04:00) Santiago</option>
															<option timeZoneId="21" gmtAdjustment="GMT-03:30" useDaylightTime="1" value="-3.5">(GMT-03:30) Newfoundland</option>
															<option timeZoneId="22" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Brasilia</option>
															<option timeZoneId="23" gmtAdjustment="GMT-03:00" useDaylightTime="0" value="-3">(GMT-03:00) Buenos Aires, Georgetown</option>
															<option timeZoneId="24" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Greenland</option>
															<option timeZoneId="25" gmtAdjustment="GMT-03:00" useDaylightTime="1" value="-3">(GMT-03:00) Montevideo</option>
															<option timeZoneId="26" gmtAdjustment="GMT-02:00" useDaylightTime="1" value="-2">(GMT-02:00) Mid-Atlantic</option>
															<option timeZoneId="27" gmtAdjustment="GMT-01:00" useDaylightTime="0" value="-1">(GMT-01:00) Cape Verde Is.</option>
															<option timeZoneId="28" gmtAdjustment="GMT-01:00" useDaylightTime="1" value="-1">(GMT-01:00) Azores</option>
															<option timeZoneId="29" gmtAdjustment="GMT+00:00" useDaylightTime="0" value="0">(GMT+00:00) Casablanca, Monrovia, Reykjavik</option>
															<option timeZoneId="30" gmtAdjustment="GMT+00:00" useDaylightTime="1" value="0" selected>(GMT+00:00) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London</option>
															<option timeZoneId="31" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
															<option timeZoneId="32" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
															<option timeZoneId="33" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
															<option timeZoneId="34" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb</option>
															<option timeZoneId="35" gmtAdjustment="GMT+01:00" useDaylightTime="1" value="1">(GMT+01:00) West Central Africa</option>
															<option timeZoneId="36" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Amman</option>
															<option timeZoneId="37" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Athens, Bucharest, Istanbul</option>
															<option timeZoneId="38" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Beirut</option>
															<option timeZoneId="39" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Cairo</option>
															<option timeZoneId="40" gmtAdjustment="GMT+02:00" useDaylightTime="0" value="2">(GMT+02:00) Harare, Pretoria</option>
															<option timeZoneId="41" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius</option>
															<option timeZoneId="42" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Jerusalem</option>
															<option timeZoneId="43" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Minsk</option>
															<option timeZoneId="44" gmtAdjustment="GMT+02:00" useDaylightTime="1" value="2">(GMT+02:00) Windhoek</option>
															<option timeZoneId="45" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Kuwait, Riyadh, Baghdad</option>
															<option timeZoneId="46" gmtAdjustment="GMT+03:00" useDaylightTime="1" value="3">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
															<option timeZoneId="47" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Nairobi</option>
															<option timeZoneId="48" gmtAdjustment="GMT+03:00" useDaylightTime="0" value="3">(GMT+03:00) Tbilisi</option>
															<option timeZoneId="49" gmtAdjustment="GMT+03:30" useDaylightTime="1" value="3.5">(GMT+03:30) Tehran</option>
															<option timeZoneId="50" gmtAdjustment="GMT+04:00" useDaylightTime="0" value="4">(GMT+04:00) Abu Dhabi, Muscat</option>
															<option timeZoneId="51" gmtAdjustment="GMT+04:00" useDaylightTime="1" value="4">(GMT+04:00) Baku</option>
															<option timeZoneId="52" gmtAdjustment="GMT+04:00" useDaylightTime="1" value="4">(GMT+04:00) Yerevan</option>
															<option timeZoneId="53" gmtAdjustment="GMT+04:30" useDaylightTime="0" value="4.5">(GMT+04:30) Kabul</option>
															<option timeZoneId="54" gmtAdjustment="GMT+05:00" useDaylightTime="1" value="5">(GMT+05:00) Yekaterinburg</option>
															<option timeZoneId="55" gmtAdjustment="GMT+05:00" useDaylightTime="0" value="5">(GMT+05:00) Islamabad, Karachi, Tashkent</option>
															<option timeZoneId="56" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30) Sri Jayawardenapura</option>
															<option timeZoneId="57" gmtAdjustment="GMT+05:30" useDaylightTime="0" value="5.5">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
															<option timeZoneId="58" gmtAdjustment="GMT+05:45" useDaylightTime="0" value="5.75">(GMT+05:45) Kathmandu</option>
															<option timeZoneId="59" gmtAdjustment="GMT+06:00" useDaylightTime="1" value="6">(GMT+06:00) Almaty, Novosibirsk</option>
															<option timeZoneId="60" gmtAdjustment="GMT+06:00" useDaylightTime="0" value="6">(GMT+06:00) Astana, Dhaka</option>
															<option timeZoneId="61" gmtAdjustment="GMT+06:30" useDaylightTime="0" value="6.5">(GMT+06:30) Yangon (Rangoon)</option>
															<option timeZoneId="62" gmtAdjustment="GMT+07:00" useDaylightTime="0" value="7">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
															<option timeZoneId="63" gmtAdjustment="GMT+07:00" useDaylightTime="1" value="7">(GMT+07:00) Krasnoyarsk</option>
															<option timeZoneId="64" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
															<option timeZoneId="65" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Kuala Lumpur, Singapore</option>
															<option timeZoneId="66" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
															<option timeZoneId="67" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Perth</option>
															<option timeZoneId="68" gmtAdjustment="GMT+08:00" useDaylightTime="0" value="8">(GMT+08:00) Taipei</option>
															<option timeZoneId="69" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
															<option timeZoneId="70" gmtAdjustment="GMT+09:00" useDaylightTime="0" value="9">(GMT+09:00) Seoul</option>
															<option timeZoneId="71" gmtAdjustment="GMT+09:00" useDaylightTime="1" value="9">(GMT+09:00) Yakutsk</option>
															<option timeZoneId="72" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30) Adelaide</option>
															<option timeZoneId="73" gmtAdjustment="GMT+09:30" useDaylightTime="0" value="9.5">(GMT+09:30) Darwin</option>
															<option timeZoneId="74" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00) Brisbane</option>
															<option timeZoneId="75" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Canberra, Melbourne, Sydney</option>
															<option timeZoneId="76" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Hobart</option>
															<option timeZoneId="77" gmtAdjustment="GMT+10:00" useDaylightTime="0" value="10">(GMT+10:00) Guam, Port Moresby</option>
															<option timeZoneId="78" gmtAdjustment="GMT+10:00" useDaylightTime="1" value="10">(GMT+10:00) Vladivostok</option>
															<option timeZoneId="79" gmtAdjustment="GMT+11:00" useDaylightTime="1" value="11">(GMT+11:00) Magadan, Solomon Is., New Caledonia</option>
															<option timeZoneId="80" gmtAdjustment="GMT+12:00" useDaylightTime="1" value="12">(GMT+12:00) Auckland, Wellington</option>
															<option timeZoneId="81" gmtAdjustment="GMT+12:00" useDaylightTime="0" value="12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
															<option timeZoneId="82" gmtAdjustment="GMT+13:00" useDaylightTime="0" value="13">(GMT+13:00) Nuku'alofa</option>
														</select>		
														Current Race Time: <span id="currentRaceTime"></span>
													</div>
                                                </div>
												<div>
                                                <label for="startDateTime"><span>Start Date (Race Time Zone)</span></label>
                                                    <div>
													<input id="startDateTime" name="startDateTime" type="text" value="" tabindex="12" readonly required/>
													Local Time: <span id="localStartDateTime"></span>
													</div>
                                                </div>
                                                <input id="startDate" name="startDate" type="hidden" value="" tabindex="12"/>
												<input id="startTime" name="startTime" type="hidden" value="" tabindex="12"/>
												
												<div>
                                                <label for="finishDateTime"><span>Finish Date (Race Time Zone)</span></label>
                                                   <div>
													<input id="finishDateTime" name="finishDateTime" type="text" tabindex="13" readonly required/>
													Local Time: <span id="localFinishDateTime"></span>
													</div>
                                                </div>
                                                
												<input id="finishDate" name="finishDate" type="hidden" tabindex="13" readonly />
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