
jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		var md = false;
		var share = qs("share");
		
		
			
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
				jQuery("#result").text(data.message + " " + data.error);
				var dateParts = data.rows[0].startDate.split("-");
				var d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
				jQuery("#startDate").html(d.ddmmyyyy());
				jQuery("#startTime").html(data.rows[0].startTime);
				dateParts = data.rows[0].finishDate.split("-");
				d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
				jQuery("#finishDate").html(d.ddmmyyyy());
				jQuery("#finishTime").html(data.rows[0].finishTime);

				jQuery("#raceName").html(data.rows[0].raceName);
				jQuery("#entryPrice").html(data.rows[0].entryPrice);
				jQuery("#raceDescription").html(data.rows[0].raceName);
				jQuery("#mapName").html(data.rows[0].mapName);
				jQuery("#weather").html(data.rows[0].weather);
				jQuery("#terrain").html(data.rows[0].terrain);
				jQuery("#featured").prop("checked", (data.rows[0].featured == 1));
				if (data.rows[0].prizeDesc)
					jQuery("#prize").html("Prize: "+data.rows[0].prizeDesc);
				
				startGridX = data.rows[0].startGridX;
				startGridY = data.rows[0].startGridY;
				finishGridX = data.rows[0].finishGridX;
				finishGridY = data.rows[0].finishGridY;
				
				curDay = data.rows[0].curDay;
				curHour = data.rows[0].curHour;
				raceStatus = data.rows[0].raceStatus;
				var createdBy = data.rows[0].createdBy;
				
				jQuery("#sponserLogoUrl").attr("src", data.rows[0].sponserLogoUrl);
				jQuery("#sponserUrl").attr("href", data.rows[0].sponserUrl);
				if (data.rows[0].sponserLogoUrl != "")
					jQuery("#sponserDiv").removeClass("myhidden");
				
				
				
				
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
							
							
							
							drawMap('paperParentAR2', false);
							
							
							
							jQuery.ajax({
								url: site_url+"/wp-admin/admin-ajax.php",
								type: "POST",
								data: {
									action: 'r2f_action_get_charity',
									id: createdBy
								},
								dataType: "JSON",
								success: function (data) {
									console.log(data);
									jQuery("#result").text(data.message + " " + data.error);
									jQuery("#charityProfileName").html(data.user.data.charityName);
									jQuery("#charityProfileWebsite").html(data.user.data.website);
									jQuery("#charityProfileDesc").html(data.user.data.description);
									window.print();
								}
								
								
							});
						}
					}
				});
				
				
				
				
				
			}
		});
		
		

	}
);


function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]); // padding
  };
  
Date.prototype.ddmmyyyy = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return (dd[1]?dd:"0"+dd[0]) + "/" + (mm[1]?mm:"0"+mm[0]) + "/" + yyyy; // padding
  };