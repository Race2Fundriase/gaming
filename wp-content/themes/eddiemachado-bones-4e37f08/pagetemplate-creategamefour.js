
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

	
	
	//drawGrid();
	jQuery("#startGridX,#startGridY,#finishGridX,#finishGridY").change(function(e) {
		startGridX = jQuery("#startGridX").val();
		startGridY = jQuery("#startGridY").val();
		finishGridX = jQuery("#finishGridX").val();
		finishGridY = jQuery("#finishGridY").val();
		drawGrid();
	});
	
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
			
			jQuery("#startGridX").val(startGridX);
			jQuery("#startGridY").val(startGridY);
			jQuery("#finishGridX").val(finishGridX);
			jQuery("#finishGridY").val(finishGridY);
					
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

						drawMap('paperParentSF', true);

						map.on('click', function(e) {
		
							var p = getPoint(e.latlng);
							if (jQuery("#startA").hasClass("btn-blue")) {
								startGridX = p.x;
								startGridY = p.y;
							} else {
								finishGridX = p.x;
								finishGridY = p.y;
							}
							jQuery("#startGridX").val(startGridX);
							jQuery("#startGridY").val(startGridY);
							jQuery("#finishGridX").val(finishGridX);
							jQuery("#finishGridY").val(finishGridY);
							
							drawStart();
							drawFinish();
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
					action: 'r2f_action_update_race_startfinish',
					id: raceId,
					startGridX: jQuery("#startGridX").val(),
					startGridY: jQuery("#startGridY").val(),
					finishGridX: jQuery("#finishGridX").val(),
					finishGridY: jQuery("#finishGridY").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					if (data.error == "") {
						location.href = site_url+"/create-online-race-5/?raceId="+raceId;
					}
					
				}
			});
			
		
		return false;
	} );
};

