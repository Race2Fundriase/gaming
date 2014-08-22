jQuery(document).ready
(
	function(jQuery)
	{

		var raceId = qs("raceId");
		var rowHtml = jQuery("#templateDiv2").html();
		
		jQuery(".media-frame-router").addClass("myhidden");
		
		jQuery("#sponserLogo").change(function(e) {
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_image_url',
					file: jQuery("#sponserLogo").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					if (data.url!="") {
						jQuery("#sponserLogoUrl").val(data.url);
						jQuery("#sponserLogoImg").attr("src", data.url);
						jQuery("#sponserLogoImg").removeClass("myhidden");
					}
				}
			});
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_maps',
				page: 0,
				rows: 100
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var option = '';
				for (i=0;i<data.records;i++){
				   option += '<option value="'+ data.rows[i].cell[0] + '">' + data.rows[i].cell[2] + '</option>';
				}
				jQuery('#mapId').append(option);
				if (raceId) {
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
							/*jQuery("#maxNoOfPlayers").val(data.rows[0].maxNoOfPlayers);
							jQuery("#raceName").val(data.rows[0].raceName);
							jQuery("#raceDescription").val(data.rows[0].raceDescription);
							jQuery("#mapId").val(data.rows[0].mapId);
							jQuery("#startDate").val(data.rows[0].startDate);
							jQuery("#startTime").val(data.rows[0].startTime);
							jQuery("#startDateTime").val(data.rows[0].startDate + " " + data.rows[0].startTime);
							jQuery("#finishDate").val(data.rows[0].finishDate);
							jQuery("#finishTime").val(data.rows[0].finishTime);
							jQuery("#finishDateTime").val(data.rows[0].finishDate + " " + data.rows[0].finishTime);
							jQuery("#entryPrice").val(data.rows[0].entryPrice);
							jQuery("#finishGridX").val(data.rows[0].finishGridX);
							jQuery("#finishGridY").val(data.rows[0].finishGridY);
							jQuery("#startGridX").val(data.rows[0].startGridX);
							jQuery("#startGridY").val(data.rows[0].startGridY);
							jQuery("#curDay").val(data.rows[0].curDay);
							jQuery("#paymentMethodEmail").val(data.rows[0].paymentMethodEmail);
							jQuery("#justGivingCharityId").val(data.rows[0].justGivingCharityId);
							jQuery("#private").val(data.rows[0].private);*/
							jQuery("#sponserLogoUrl").val(data.rows[0].sponserLogoUrl);
							jQuery("#sponserLogoImg").attr("src", data.rows[0].sponserLogoUrl);
							jQuery("#sponserUrl").val(data.rows[0].sponserUrl);
							
							var row = "";
							lengthInDays = data.rows[0].lengthInDays;
							for(i=0;i<lengthInDays;i++) {
								r = rowHtml;
								r = r.replace(/{day}/g, i+1);
								row += r;	
							}
							jQuery("#weatherResults").append(row);
							
							jQuery.ajax({
								url: site_url+"/wp-admin/admin-ajax.php",
								type: "POST",
								data: {
									action: 'r2f_action_get_raceweather',
									raceId: raceId
								},
								dataType: "JSON",
								success: function (data) {
									console.log(data);
									var option = '';
									for (i=0;i<data.rows.length;i++){
									   jQuery("#weatherDay"+(i+1)).val(data.rows[i].weather);
									   jQuery("#weatherForecastDay"+(i+1)).val(data.rows[i].weatherForecast);
									}
									
									
								}
							});
						}
					});
				}
			}
		});
	
			
	
		jQuery("#continue").click(function() { 
			
			var i;
			
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_update_racesponserLogo',
					raceId: raceId,
					sponserLogoUrl: jQuery("#sponserLogoUrl").val(),
					sponserUrl: jQuery("#sponserUrl").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					for (i=0;i<lengthInDays;i++) {
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_upsert_raceweather',
								raceId: raceId,
								day: i,
								weather: jQuery("#weatherDay"+(i+1)).val(),
								weatherForecast: jQuery("#weatherForecastDay"+(i+1)).val()
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);
								if (data.day == lengthInDays-1)
									location.href = site_url+"/create-offline-race-4/?raceId="+raceId;
							}
						});
						
						
					}			
				}
			});
			
			
			return false;
		} );
		
						
	}
);

function options(raceId) {
	location.href = site_url+'/options?raceId='+raceId;
}

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

