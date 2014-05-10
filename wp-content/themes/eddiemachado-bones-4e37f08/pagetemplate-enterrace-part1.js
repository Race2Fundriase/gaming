function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}


window.onload = function () {

	var raceId = qs("raceId");
	var transactionId = qs("transactionId");
	
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

						drawMap('paperParentAR2', false);
					}
					
				}
			});
			
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
					jQuery("#result").text(data.message + " " + data.error);
					var option = '';
					var rowHtml = jQuery("#templateDiv").html();
					var row = "";
					for (i=0;i<data.rows.length;i++){
					   option += '<option value="'+ data.rows[i].tokenId + '">' + data.rows[i].tokenName + '</option>';
						r = rowHtml;
						r = r.replace(/{index}/g, i);
						r = r.replace(/{tokenId}/g, data.rows[i].tokenId);
						r = r.replace(/{tokenName}/g, data.rows[i].tokenName);
						r = r.replace(/{imageUrl}/g,site_url+data.rows[i].tokenImageUrl);
						row += r;
					}
					jQuery('#tokenId').append(option);
					jQuery("#raceTokenResults").html(row);
					
					for (i=0;i<data.rows.length;i++){
					
						jQuery("#token_"+i).click(function() { 

							return false;
						} );
						
						if ((i % 3) == 0)
							jQuery("#wrapper_"+i).addClass("first");
						if ((i % 3) == 2)
							jQuery("#wrapper_"+i).addClass("last");		

						jQuery("#wrapper_"+i).qtip({
						   content: data.rows[i].tokenTip,
						   show: 'mouseover',
						   hide: 'mouseout',
						   position: {
							my: 'bottom center',
							at: 'top center'
						   }
						});							
					}
					
					jQuery(".optionselect").bind("click", function(e) {
						var selection = jQuery(this).data('selection');        
						
						jQuery(".optionselect").removeClass("active");
						
						jQuery(this).addClass("active");
						jQuery("#tokenId option[value='"+selection+"']").prop("selected", true);
						
						
						e.preventDefault();
					});    
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
					    jQuery("#weatherForecastDay"+(i+1)).val(data.rows[i].weatherForecast);
					}
					
					
				}
			});
			jQuery('#enterRaceForm select').attr('disabled', 'true');
			
		}
	});
	
	jQuery("#continue").click(function(e) { 
		// validate form
		if (jQuery("#playerName").val() == "") { alert("You must enter a player name"); return false; }
		location.href = site_url+"/enter-race-part-2/?raceId="+raceId+"&playerName="+jQuery("#playerName").val()
			+"&tokenId="+jQuery("#tokenId").val()+"&drivingStyleWeight="+jQuery("#drivingStyleWeight").val()
			+"&noOfPitstops="+jQuery("#noOfPitstops").val()+"&transactionId="+transactionId;
		return false;
	} );
	
	
};

