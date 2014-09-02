

Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]); // padding
  };

var d = new Date();


function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

window.onload = function () {

	jQuery('#create-game input').attr('readonly', 'readonly');
	jQuery('#create-game textarea').attr('readonly', 'readonly');
	jQuery('#raceStatus').attr("readonly", "");
	
	var raceId = qs("raceId");
	var racecharacterId = qs("racecharacterId");


	
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
			jQuery("#mapName").val(data.rows[0].mapName);
			
			jQuery("#startDate").val(convertDateTimeToDate(data.rows[0].startDate, data.rows[0].startTime));
			jQuery("#startTime").val(convertDateTimeToTime(data.rows[0].startDate, data.rows[0].startTime));
			jQuery("#finishDate").val(convertDateTimeToDate(data.rows[0].finishDate, data.rows[0].finishTime));
			jQuery("#finishTime").val(convertDateTimeToTime(data.rows[0].finishDate, data.rows[0].finishTime));
			jQuery("#entryPrice").val(data.rows[0].entryPrice);
			jQuery("#finishGridX").val(data.rows[0].finishGridX);
			jQuery("#finishGridY").val(data.rows[0].finishGridY);
			jQuery("#startGridX").val(data.rows[0].startGridX);
			jQuery("#startGridY").val(data.rows[0].startGridY);
			jQuery("#curDay").val(data.rows[0].curDay);
			jQuery("#paymentMethodEmail").val(data.rows[0].paymentMethodEmail);
			jQuery("#justGivingCharityId").val(data.rows[0].justGivingCharityId);
			startGridX = data.rows[0].startGridX;
			startGridY = data.rows[0].startGridY;
			finishGridX = data.rows[0].finishGridX;
			finishGridY = data.rows[0].finishGridY;
			
			jQuery("#startGridX").val(startGridX);
			jQuery("#startGridY").val(startGridY);
			jQuery("#finishGridX").val(finishGridX);
			jQuery("#finishGridY").val(finishGridY);
			
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
					var ts = "";
					var sep = "";
					for(i=0;i<data.rows.length;i++) {
						ts += sep+data.rows[i].tokenName;
						sep = ",";
					}
					jQuery("#selectedTokens").val(ts);
					
				}
			});
					
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_map',
					id: data.rows[0].mapId
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					if (data.error == "") {
						mapId = data.result.id;
						mapName = data.result.mapName;
						mapImageUrl = data.result.mapImageUrl;
						mapWidth = data.result.mapWidth;
						mapHeight = data.result.mapHeight;
						gridWidth = data.result.gridWidth;
						gridHeight = data.result.gridHeight;
						cellWidth = data.result.cellWidth;
						cellHeight = data.result.cellHeight;
						mapTilesUrl = data.result.mapTilesUrl;
						minZoom = data.result.minZoom;
						maxZoom = data.result.maxZoom;
						boundaryX = data.result.boundaryX;
						boundaryY = data.result.boundaryY;
						mapOverlayUrl = data.result.mapOverlayUrl;
						drawMap('paperParentSF2', true);
					}
					
				}
			});

			var row = "";
			lengthInDays = data.rows[0].lengthInDays;
			rowHtml = jQuery("#templateDiv2").html();
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
					   jQuery("#weatherDay"+(i+1)).val(getWeatherDesc(data.rows[i].weather));
					   jQuery("#weatherForecastDay"+(i+1)).val(getWeatherDesc(data.rows[i].weatherForecast));
					}
					
					
				}
			});
			jQuery('#create-game select').attr('disabled', 'true');
			jQuery('#create-game input').attr('readonly', 'readonly');
		}
	});
	
	jQuery("#continue").click(function(e) { 
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_update_race_raceStatus',
				id: raceId,
				raceStatus: jQuery("#raceStatus").val()
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				location.href = site_url+"/active-race/?share=1&raceId="+raceId;			
				
			}
		});
		
		
		
		return false;
	} );
	
	jQuery("#startagain").click(function(e) { 
		
		location.href = site_url+"/create-online-race-2/?raceId="+raceId;
		
		return false;
	} );

};

function getWeatherDesc(id) {
	if (id==1) return "Icy";
	if (id==2) return "Snow";
	if (id==3) return "Thunderstorm";
	if (id==4) return "Heavy Rain";
	if (id==5) return "Rain";
	if (id==6) return "Overcast";
	if (id==7) return "Light cloud";
	if (id==8) return "Clear skies";
	if (id==9) return "Sunny";
	if (id==10) return "Heat wave";
	return "";
}