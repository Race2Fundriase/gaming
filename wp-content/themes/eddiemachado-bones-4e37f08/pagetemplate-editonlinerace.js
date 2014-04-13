jQuery(document).ready
(
	function(jQuery)
	{

		var raceId = qs("raceId");
		var rowHtml = jQuery("#templateDiv").html();
		var lengthInDays;
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
							jQuery("#maxNoOfPlayers").val(data.rows[0].maxNoOfPlayers);
							jQuery("#raceName").val(data.rows[0].raceName);
							jQuery("#raceDescription").val(data.rows[0].raceDescription);
							jQuery("#mapId").val(data.rows[0].mapId);
							jQuery("#startDate").val(data.rows[0].startDate);
							jQuery("#startTime").val(data.rows[0].startTime);
							jQuery("#finishDate").val(data.rows[0].finishDate);
							jQuery("#finishTime").val(data.rows[0].finishTime);
							jQuery("#entryPrice").val(data.rows[0].entryPrice);
							jQuery("#finishGridX").val(data.rows[0].finishGridX);
							jQuery("#finishGridY").val(data.rows[0].finishGridY);
							jQuery("#startGridX").val(data.rows[0].startGridX);
							jQuery("#startGridY").val(data.rows[0].startGridY);
							jQuery("#curDay").val(data.rows[0].curDay);
							jQuery("#raceStatus").val(data.rows[0].raceStatus);
							jQuery("#paymentMethodEmail").val(data.rows[0].paymentMethodEmail);
							jQuery("#justGivingCharityId").val(data.rows[0].justGivingCharityId);
							
							
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
									   jQuery("#weatherForecast"+(i+1)).val(data.rows[i].weatherForecast);
									}
									
									
								}
							});
						}
					});
				}
			}
		});
	
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "GET",
			data: {
				action: 'r2f_action_get_tokens',
				page: 0,
				rows: 100
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var option = '';
				for (i=0;i<data.records;i++){
				   option += '<option value="'+ data.rows[i].cell[0] + '">' + data.rows[i].cell[1] + '</option>';
				}
				jQuery('#raceTokens').append(option);
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_racetokens',
						raceId: raceId
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						for(i=0;i<data.rows.length;i++)
							jQuery("#raceTokens option[value='"+data.rows[i].tokenId+"']").prop("selected", true);
						
					}
				});
			}
		});
		
	
		jQuery("#continue").click(function() { 
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_race',
					id: raceId,
					maxNoOfPlayers: jQuery("#maxNoOfPlayers").val(),
					raceName: jQuery("#raceName").val(),
					raceDescription: jQuery("#raceDescription").val(),
					mapId: jQuery("#mapId").val(),
					startDate: jQuery("#startDate").val(),
					startTime: jQuery("#startTime").val(),
					finishDate: jQuery("#finishDate").val(),
					finishTime: jQuery("#finishTime").val(),
					entryPrice: jQuery("#entryPrice").val(),
					raceTokens: jQuery("#raceTokens").val(),
					finishGridX: jQuery("#finishGridX").val(),
					finishGridY: jQuery("#finishGridY").val(),
					startGridX: jQuery("#startGridX").val(),
					startGridY: jQuery("#startGridY").val(),
					curDay: jQuery("#curDay").val(),
					raceStatus: jQuery("#raceStatus").val(),
					paymentMethodEmail: jQuery("#paymentMethodEmail").val(),
					justGivingCharityId: jQuery("#justGivingCharityId").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					//jQuery("#result").text(data.message + " " + data.error);
					//options(data.id);
					var n = noty({text: data.message + " " + data.error});
				}
			});
			var i;
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
						//jQuery("#result").text(data.message + " " + data.error);
						//options(data.id);
						//var n = noty({text: data.message + " " + data.error});
					}
				});
			}
			return false;
		} );
		
		jQuery("#startDate,#finishDate").change(function(e) {
			// Build weather grid (and populate if it's already got data)
			
		});
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

