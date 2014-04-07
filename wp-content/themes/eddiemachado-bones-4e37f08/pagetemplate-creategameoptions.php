<?php
/*
Template Name: Create Game Options
*/
?>

<?php get_header(); ?>
 <div class="container sand bot-bg clearfix nav-margin">
    <div class="inner-container wrap">
            <div id="logo" class="secondary">
                    <img src="<?php echo get_template_directory_uri(); ?>/library/images/Logo-Wooden.gif" alt="" />
            </div>
            <div id="create-race-header">
                <div class="text-center"><h1 class="highlight">Options</h1></div>
            </div>
                        
    </div>
</div>
 
         <div class="fences wrap"></div>
           
            <div class="container container-create-race grit top-bg-grass bot-bg clearfix">
                <div class="inner-container wrap">
                        <div class="form-elements">
                                                <h3><span>Part 4</span></h3>
                                            
                                                <div>
                                                    <label for="weather"><span>Weather:</span></label>
                                                    <div>
                                                    <input name="weather" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" />
                                                      <div class="status">
                                                        <p class="left-status">Cold</p><p class="right-status">Hot</p>
                                                      </div>
                                                      
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="weatherforecast"><span>Weather Forecast:</span></label>
                                                    <div>
                                                    <input name="weatherforecast" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" />
                                                    <div class="status"><p class="left-status">Cold</p><p class="right-status">Hot</p></div>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="energyrequired"><span>Energy Required:</span></label>
                                                    <div>
                                                    <input name="energyrequired" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" />
                                                    <div class="status"><p class="left-status">Low Power</p><p class="right-status">High Power</p></div>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="courseagg"><span>Course Aggresiveness:</span></label>
                                                    <div>
                                                    <input name="courseagg" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" />
                                                    <div class="status"><p class="left-status">Low</p><p class="right-status">High</p></div>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="terrain"><span>Terrain:</span></label>
                                                    <div>
                                                    <input name="terrain" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" /> 
                                                    <div class="status"><p class="left-status">Slipery</p><p class="right-status">Rough</p></div>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="coursedist"><span>Course Distance:</span></label>
                                                    <div>
                                                    <input name="coursedist" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" /> 
                                                    <div class="status"><p class="left-status">Short</p><p class="right-status">Long</p></div>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label for="speed"><span>Speed:</span></label>
                                                    <div>
                                                    <input name="speed" type="text" data-slider-highlight="true" data-slider-theme="control" data-slider="true" /> 
                                                    <div class="status"><p class="left-status">Slow</p><p class="right-status">Fast</p></div>
                                                    </div>
                                                </div>
                                            <div class="text-center continue"><input type="submit" value="continue" class="btn large"/></div>
                                </div><!--End Form Elements-->
                        </form><!--End Form-->
                </div><!--End Inner Container-->
            </div><!--End Container-->
            <!--FORM OPTION 2-->
<?php get_footer(); ?>
<script>
jQuery(document).ready
(
	function(jQuery)
	{

		var raceId = qs("raceId");
		
		jQuery.ajax({
			url: "<?=site_url();?>/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_race',
				id: raceId
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#weather").val(data.rows[0].weather);
				jQuery("#weatherForecast").val(data.rows[0].weatherForecast);
				jQuery("#energyRequired").val(data.rows[0].energyRequired);
				jQuery("#courseAggressiveness").val(data.rows[0].courseAggressiveness);
				jQuery("#terrain").val(data.rows[0].terrain);
				jQuery("#courseDistance").val(data.rows[0].courseDistance);
				jQuery("#speed").val(data.rows[0].speed);
				
			}
		});
		
		jQuery("#continue").click(function() { 
			jQuery.ajax({
				url: "<?=site_url();?>/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_race_options',
					id: raceId,
					weather: jQuery("#weather").val(),
					weatherForecast: jQuery("#weatherForecast").val(),
					energyRequired: jQuery("#energyRequired").val(),
					courseAggressiveness: jQuery("#courseAggressiveness").val(),
					terrain: jQuery("#terrain").val(),
					courseDistance: jQuery("#courseDistance").val(),
					speed: jQuery("#speed").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					createCharacters(data.id);
				}
			});
			return false;
		} );
		
	}
);

function createCharacters(raceId) {
	location.href = '<?=site_url()?>/create-characters?raceId='+raceId;
}

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

</script>