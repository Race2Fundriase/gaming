jQuery(document).ready
(
	function(jQuery)
	{

		var raceId = qs("raceId");
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
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
				url: site_url+"/wp-admin/admin-ajax.php",
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
	location.href = site_url+'/create-characters?raceId='+raceId;
}

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

