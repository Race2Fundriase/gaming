<?php
/*
Template Name: Token Join
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
	<div class="fences wrap"></div>
	
	<section>
	    <div class="container sand bot-bg-grass">
		<div class="inner-container wrap">
		    <h1 class="highlight">Player Account Setup</h1>
		    
		    <ul id="tab_control" class="tab_control">
			<li><a href="#" class="btn large active btn-blue">Register</a></li>
			<li><a href="#" class="btn large">Login</a></li>
		    </ul>
		    
		</div>
	    </div>
	</section>
	
	<section>
	    <div class="container grit bot-bg bot-bg-alt clearfix">
		<div class="inner-container wrap">
		    <div id="tabs">
			<div class="tabbed_content active">
			    <form method="post" action="#" id="registerForm">
				   <div class="form-elements">
					<h3><span>Part 1</span></h3>
				     
					<div>
					    <label for="name"><span>Name:</span></label>
					    <div>
					    <input name="name" id="name" type="text" value="" size="8" tabindex="1"/> 
					    </div>
					</div>
					<div>
					    <label for="profileName"><span>Profile Name (this is your username):</span></label>
					    <div>
					    <input name="profileName" id="profileName" type="text" value="" size="8" tabindex="2"/>
					    </div>
					</div>
					<div>
					    <label for="email"><span>Email Address:</span></label>
					    <div>
					    <input name="email" id="email" type="email" spellcheck="false" maxlength="255" tabindex="5"/>
					    </div>
					</div>
					
					<h3><span>Part 2</span></h3>
				     
					<div>
					    <label for="building"><span>House No. or Name*</span></label>
					    <div>
					    <input name="building" id="building" type="text" value="" size="8" tabindex="6" required/> 
					    </div>
					</div>
					<div>
					    <label for="road"><span>Road Name*</span></label>
					    <div>
					    <input name="road" id="road" type="text" value="" size="8" tabindex="7" required/>
					    </div>
					</div>
					<div>
					    <label for="city"><span>Town/City*</span></label>
					    <div>
					    <input name="city" id="city" type="text" value="" size="8" tabindex="8"/>
					    </div>
					</div>
					<div>
					    <label for="county"><span>County*</span></label>
					    <div>
					    <input name="county" id="county" type="text" value="" tabindex="9"/>
					    </div>
					</div>
					<div>
					    <label for="postcode"><span>Postcode*</span></label>
					    <div>
					    <input name="postcode" id="postcode" type="text" spellcheck="false" tabindex="10"/>
					    </div>
					</div>
					<div>
					    <label for="country"><span>Country*</span></label>
					    <div>
					    <select name="country" id="country" tabindex="11">
						<option value="">Country...</option>
						<option value="Afganistan">Afghanistan</option>
						<option value="Albania">Albania</option>
						<option value="Algeria">Algeria</option>
						<option value="American Samoa">American Samoa</option>
						<option value="Andorra">Andorra</option>
						<option value="Angola">Angola</option>
						<option value="Anguilla">Anguilla</option>
						<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
						<option value="Argentina">Argentina</option>
						<option value="Armenia">Armenia</option>
						<option value="Aruba">Aruba</option>
						<option value="Australia">Australia</option>
						<option value="Austria">Austria</option>
						<option value="Azerbaijan">Azerbaijan</option>
						<option value="Bahamas">Bahamas</option>
						<option value="Bahrain">Bahrain</option>
						<option value="Bangladesh">Bangladesh</option>
						<option value="Barbados">Barbados</option>
						<option value="Belarus">Belarus</option>
						<option value="Belgium">Belgium</option>
						<option value="Belize">Belize</option>
						<option value="Benin">Benin</option>
						<option value="Bermuda">Bermuda</option>
						<option value="Bhutan">Bhutan</option>
						<option value="Bolivia">Bolivia</option>
						<option value="Bonaire">Bonaire</option>
						<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
						<option value="Botswana">Botswana</option>
						<option value="Brazil">Brazil</option>
						<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
						<option value="Brunei">Brunei</option>
						<option value="Bulgaria">Bulgaria</option>
						<option value="Burkina Faso">Burkina Faso</option>
						<option value="Burundi">Burundi</option>
						<option value="Cambodia">Cambodia</option>
						<option value="Cameroon">Cameroon</option>
						<option value="Canada">Canada</option>
						<option value="Canary Islands">Canary Islands</option>
						<option value="Cape Verde">Cape Verde</option>
						<option value="Cayman Islands">Cayman Islands</option>
						<option value="Central African Republic">Central African Republic</option>
						<option value="Chad">Chad</option>
						<option value="Channel Islands">Channel Islands</option>
						<option value="Chile">Chile</option>
						<option value="China">China</option>
						<option value="Christmas Island">Christmas Island</option>
						<option value="Cocos Island">Cocos Island</option>
						<option value="Colombia">Colombia</option>
						<option value="Comoros">Comoros</option>
						<option value="Congo">Congo</option>
						<option value="Cook Islands">Cook Islands</option>
						<option value="Costa Rica">Costa Rica</option>
						<option value="Cote DIvoire">Cote D'Ivoire</option>
						<option value="Croatia">Croatia</option>
						<option value="Cuba">Cuba</option>
						<option value="Curaco">Curacao</option>
						<option value="Cyprus">Cyprus</option>
						<option value="Czech Republic">Czech Republic</option>
						<option value="Denmark">Denmark</option>
						<option value="Djibouti">Djibouti</option>
						<option value="Dominica">Dominica</option>
						<option value="Dominican Republic">Dominican Republic</option>
						<option value="East Timor">East Timor</option>
						<option value="Ecuador">Ecuador</option>
						<option value="Egypt">Egypt</option>
						<option value="El Salvador">El Salvador</option>
						<option value="Equatorial Guinea">Equatorial Guinea</option>
						<option value="Eritrea">Eritrea</option>
						<option value="Estonia">Estonia</option>
						<option value="Ethiopia">Ethiopia</option>
						<option value="Falkland Islands">Falkland Islands</option>
						<option value="Faroe Islands">Faroe Islands</option>
						<option value="Fiji">Fiji</option>
						<option value="Finland">Finland</option>
						<option value="France">France</option>
						<option value="French Guiana">French Guiana</option>
						<option value="French Polynesia">French Polynesia</option>
						<option value="French Southern Ter">French Southern Ter</option>
						<option value="Gabon">Gabon</option>
						<option value="Gambia">Gambia</option>
						<option value="Georgia">Georgia</option>
						<option value="Germany">Germany</option>
						<option value="Ghana">Ghana</option>
						<option value="Gibraltar">Gibraltar</option>
						<option value="Great Britain">Great Britain</option>
						<option value="Greece">Greece</option>
						<option value="Greenland">Greenland</option>
						<option value="Grenada">Grenada</option>
						<option value="Guadeloupe">Guadeloupe</option>
						<option value="Guam">Guam</option>
						<option value="Guatemala">Guatemala</option>
						<option value="Guinea">Guinea</option>
						<option value="Guyana">Guyana</option>
						<option value="Haiti">Haiti</option>
						<option value="Hawaii">Hawaii</option>
						<option value="Honduras">Honduras</option>
						<option value="Hong Kong">Hong Kong</option>
						<option value="Hungary">Hungary</option>
						<option value="Iceland">Iceland</option>
						<option value="India">India</option>
						<option value="Indonesia">Indonesia</option>
						<option value="Iran">Iran</option>
						<option value="Iraq">Iraq</option>
						<option value="Ireland">Ireland</option>
						<option value="Isle of Man">Isle of Man</option>
						<option value="Israel">Israel</option>
						<option value="Italy">Italy</option>
						<option value="Jamaica">Jamaica</option>
						<option value="Japan">Japan</option>
						<option value="Jordan">Jordan</option>
						<option value="Kazakhstan">Kazakhstan</option>
						<option value="Kenya">Kenya</option>
						<option value="Kiribati">Kiribati</option>
						<option value="Korea North">Korea North</option>
						<option value="Korea Sout">Korea South</option>
						<option value="Kuwait">Kuwait</option>
						<option value="Kyrgyzstan">Kyrgyzstan</option>
						<option value="Laos">Laos</option>
						<option value="Latvia">Latvia</option>
						<option value="Lebanon">Lebanon</option>
						<option value="Lesotho">Lesotho</option>
						<option value="Liberia">Liberia</option>
						<option value="Libya">Libya</option>
						<option value="Liechtenstein">Liechtenstein</option>
						<option value="Lithuania">Lithuania</option>
						<option value="Luxembourg">Luxembourg</option>
						<option value="Macau">Macau</option>
						<option value="Macedonia">Macedonia</option>
						<option value="Madagascar">Madagascar</option>
						<option value="Malaysia">Malaysia</option>
						<option value="Malawi">Malawi</option>
						<option value="Maldives">Maldives</option>
						<option value="Mali">Mali</option>
						<option value="Malta">Malta</option>
						<option value="Marshall Islands">Marshall Islands</option>
						<option value="Martinique">Martinique</option>
						<option value="Mauritania">Mauritania</option>
						<option value="Mauritius">Mauritius</option>
						<option value="Mayotte">Mayotte</option>
						<option value="Mexico">Mexico</option>
						<option value="Midway Islands">Midway Islands</option>
						<option value="Moldova">Moldova</option>
						<option value="Monaco">Monaco</option>
						<option value="Mongolia">Mongolia</option>
						<option value="Montserrat">Montserrat</option>
						<option value="Morocco">Morocco</option>
						<option value="Mozambique">Mozambique</option>
						<option value="Myanmar">Myanmar</option>
						<option value="Nambia">Nambia</option>
						<option value="Nauru">Nauru</option>
						<option value="Nepal">Nepal</option>
						<option value="Netherland Antilles">Netherland Antilles</option>
						<option value="Netherlands">Netherlands (Holland, Europe)</option>
						<option value="Nevis">Nevis</option>
						<option value="New Caledonia">New Caledonia</option>
						<option value="New Zealand">New Zealand</option>
						<option value="Nicaragua">Nicaragua</option>
						<option value="Niger">Niger</option>
						<option value="Nigeria">Nigeria</option>
						<option value="Niue">Niue</option>
						<option value="Norfolk Island">Norfolk Island</option>
						<option value="Norway">Norway</option>
						<option value="Oman">Oman</option>
						<option value="Pakistan">Pakistan</option>
						<option value="Palau Island">Palau Island</option>
						<option value="Palestine">Palestine</option>
						<option value="Panama">Panama</option>
						<option value="Papua New Guinea">Papua New Guinea</option>
						<option value="Paraguay">Paraguay</option>
						<option value="Peru">Peru</option>
						<option value="Phillipines">Philippines</option>
						<option value="Pitcairn Island">Pitcairn Island</option>
						<option value="Poland">Poland</option>
						<option value="Portugal">Portugal</option>
						<option value="Puerto Rico">Puerto Rico</option>
						<option value="Qatar">Qatar</option>
						<option value="Republic of Montenegro">Republic of Montenegro</option>
						<option value="Republic of Serbia">Republic of Serbia</option>
						<option value="Reunion">Reunion</option>
						<option value="Romania">Romania</option>
						<option value="Russia">Russia</option>
						<option value="Rwanda">Rwanda</option>
						<option value="St Barthelemy">St Barthelemy</option>
						<option value="St Eustatius">St Eustatius</option>
						<option value="St Helena">St Helena</option>
						<option value="St Kitts-Nevis">St Kitts-Nevis</option>
						<option value="St Lucia">St Lucia</option>
						<option value="St Maarten">St Maarten</option>
						<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
						<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
						<option value="Saipan">Saipan</option>
						<option value="Samoa">Samoa</option>
						<option value="Samoa American">Samoa American</option>
						<option value="San Marino">San Marino</option>
						<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
						<option value="Saudi Arabia">Saudi Arabia</option>
						<option value="Senegal">Senegal</option>
						<option value="Serbia">Serbia</option>
						<option value="Seychelles">Seychelles</option>
						<option value="Sierra Leone">Sierra Leone</option>
						<option value="Singapore">Singapore</option>
						<option value="Slovakia">Slovakia</option>
						<option value="Slovenia">Slovenia</option>
						<option value="Solomon Islands">Solomon Islands</option>
						<option value="Somalia">Somalia</option>
						<option value="South Africa">South Africa</option>
						<option value="Spain">Spain</option>
						<option value="Sri Lanka">Sri Lanka</option>
						<option value="Sudan">Sudan</option>
						<option value="Suriname">Suriname</option>
						<option value="Swaziland">Swaziland</option>
						<option value="Sweden">Sweden</option>
						<option value="Switzerland">Switzerland</option>
						<option value="Syria">Syria</option>
						<option value="Tahiti">Tahiti</option>
						<option value="Taiwan">Taiwan</option>
						<option value="Tajikistan">Tajikistan</option>
						<option value="Tanzania">Tanzania</option>
						<option value="Thailand">Thailand</option>
						<option value="Togo">Togo</option>
						<option value="Tokelau">Tokelau</option>
						<option value="Tonga">Tonga</option>
						<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
						<option value="Tunisia">Tunisia</option>
						<option value="Turkey">Turkey</option>
						<option value="Turkmenistan">Turkmenistan</option>
						<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
						<option value="Tuvalu">Tuvalu</option>
						<option value="Uganda">Uganda</option>
						<option value="Ukraine">Ukraine</option>
						<option value="United Arab Erimates">United Arab Emirates</option>
						<option selected="selected" value="United Kingdom">United Kingdom</option>
						<option value="United States of America">United States of America</option>
						<option value="Uraguay">Uruguay</option>
						<option value="Uzbekistan">Uzbekistan</option>
						<option value="Vanuatu">Vanuatu</option>
						<option value="Vatican City State">Vatican City State</option>
						<option value="Venezuela">Venezuela</option>
						<option value="Vietnam">Vietnam</option>
						<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
						<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
						<option value="Wake Island">Wake Island</option>
						<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
						<option value="Yemen">Yemen</option>
						<option value="Zaire">Zaire</option>
						<option value="Zambia">Zambia</option>
						<option value="Zimbabwe">Zimbabwe</option>
					    </select>
					    </div>
					</div>
					
					<h3><span>Part 3</span></h3>
					
					<div>
					    <label for="choosePassword"><span>Choose a Password</span></label>
					    <div>
					    <input name="choosePassword" id="choosePassword" type="password" value="" tabindex="12"/>
					    </div>
					</div>
					<div>
					    <label for="confirmPassword"><span>Confirm Password</span></label>
					    <div>
					    <input name="confirmPassword" id="confirmPassword" type="password" tabindex="13"/>
					    </div>
					</div>
					<div>
<p style="text-align:center; color:#ffffff;">By clicking sign up/register you agree to our electronic <a href="http://race2fundraise.com/terms-and-conditions/" style="color:#de5f02">terms and conditions</a></p>
</div>
					<div class="text-center signup"><input type="submit" value="REGISTER" class="btn large" id="register"/></div>
				  </div> 
			    </form>
			</div>
			<div class="tabbed_content">
			    <form method="post" action="#"id="loginForm">
				   <div class="form-elements">
					<h3><span>Part 1</span></h3>
				     
					<div>
					    <label for="profileName"><span>Profile Name:</span></label>
					    <div>
					    <input name="profileName2" id="profileName2" type="text" value="" size="8" tabindex="2"/>
					    </div>
					</div>
					<div>
					    <label for="password"><span>Password</span></label>
					    <div>
					    <input name="password" id="password" type="password" value="" tabindex="12"/>
					    </div>
					</div>
					
					<div class="text-center signup"><input type="submit" value="LOGIN" class="btn large" id="login"/></div>
				</div>
			    </form>
			</div>
		    </div>
		</div>
	    </div>
	</section>
	
			<section>
			<div class="container top-bg bot-bg sand">
				<div class="inner-container wrap clearfix">
					<div class="twelvecol first last">
						<h2 class="highlight">6 Facts About R2F</h2>
					</div>
					<div class="row clearfix">
					<div class="fourcol first clearfix">
						<span class="num-bullet">1</span>
						
						<p><span class="highlight">Fun</span><br/>The race2fundraise is fun to play, depending on how you choose to setup your race, players decide which character they want to race, select their racing colours, create their own route and determine their racing style enabling your supporters to become part of the fundraising event.</p>
					</div>
					
					<div class="fourcol clearfix">
						<span class="num-bullet">2</span>
						<p><span class="highlight">A Truly Unique fundraising opportunity</span><br/>
							You can tailor each race to your cause or project needs.
							You decide if the race is open to everyone (worldwide) or a closed list of invited people. 
							You choose the race duration, start and end times.
							You choose the race location, start and end points.
							You set the character choice.
							You set the player price.
							You even control the weather.
							You choose if there are prizes for finishing positions.</p>
					</div>
					
					<div class="fourcol last clearfix">
						<span class="num-bullet">3</span>
						<p><span class="highlight">Easy to setup and administer</span><br/>
Our game engine has been designed to make it simple to setup a new race, all the game settings and reporting is available online.  Players can see their current positions online 24 hours a day.</p>
					</div>
					</div>
					
					<div class="row clearfix">
					<div class="fourcol first clearfix">
						<span class="num-bullet">4</span>
						<p><span class="highlight">Cost effective fundraising idea</span><br/>
Race2fundraise offers excellent value for money with options to reflect different supporter levels and budgets; you could even choose to buy a small race and then add extra players as you need them. You can use your own website and email system to invite people to race and fundraise.</p>
					</div>
					
					<div class="fourcol clearfix">
						<span class="num-bullet">5</span>
						<p><span class="highlight">Inclusive to all</span><br/> 
Irrespective of age, location and agility all players can compete fairly against one another.  You can choose to make the game open to anyone online.</p>
					</div>
					
					<div class="fourcol last clearfix">
						<span class="num-bullet">6</span>
						<p><span class="highlight">Value and Entertainment for your supporters</span><br/>
During the race the players can see their position on the race map and compare it with their friends and family so your supporters receive entertainment for the full race duration.</p>
					</div>
					</div>
				</div>
			</div>
			</section>
	
<?php get_footer(); ?>
<script src="<?=get_stylesheet_directory_uri()?>/<?=basename(__FILE__, '.php');?>.js" type="text/javascript"></script>