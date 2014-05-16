
var selectedCell;

var selectedCells = [];

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

	
	jQuery('#enterRaceForm input').attr('readonly', 'readonly');
	
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
			startGridX = data.rows[0].startGridX;
			startGridY = data.rows[0].startGridY;
			finishGridX = data.rows[0].finishGridX;
			finishGridY = data.rows[0].finishGridY;
						
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

						drawMap('paperParent1', true);
						
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_get_racecharacter',
								id: racecharacterId
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);
								jQuery("#result").text(data.message + " " + data.error);
								jQuery("#playerName").val(data.rows[0].playerName);
								jQuery("#drivingStyleWeight").val(data.rows[0].drivingStyleWeight);
								jQuery("#drivingStyleWeight").simpleSlider("setValue", data.rows[0].drivingStyleWeight);
								jQuery("#noOfPitstops").val(data.rows[0].noOfPitstops);
								jQuery("#noOfPitstops").simpleSlider("setValue", data.rows[0].noOfPitstops);
								option = '<option value="'+ data.rows[0].tokenId + '">' + data.rows[0].tokenName + '</option>';
								jQuery('#tokenId').append(option);
															
								jQuery("#tokenId").val(data.rows[0].tokenId);
								
								jQuery('#enterRaceForm select').attr('disabled', 'true');
								
								// Draw the Route
								var r = data.rows[0].route.split('|');
								for(i=0;i<r.length;i++) {
									if (r[i] != "") {
										var p = r[i].split(',');
										var x = p[0];
										var y = p[1];
										
										drawCell(parseInt(x), parseInt(y));
									}
								}
							}
						});
					}
					
				}
			});

			
		}
	});
	
	jQuery("#continue").click(function(e) { 
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_activate_racecharacter',
				id: racecharacterId
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				if (data.error == "")
					location.href = site_url+"/active-race/?share=1&raceId="+raceId;
			}
		});
			
		
		return false;
	} );
	
	jQuery("#startagain").click(function(e) { 
		
		location.href = site_url+"/enter-race-part-1/?raceId="+raceId;
		
		return false;
	} );

};

