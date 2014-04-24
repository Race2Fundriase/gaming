var paper;
var scale = 1.0;
var mapWidth = 3506;
var mapHeight = 4440;
var cellWidth = 75;
var cellHeight = 75;
var gridWidth = 47;
var gridHeight = 60;
var xoff = 0;
var yoff = 0;

var selectedCell;

var mapImageUrl = "";
var mapImage;

function drawGrid() {

	if (paper) paper.clear();

	paper = Raphael("paperParentSF2", mapWidth*scale, mapHeight*scale);
	paper.image(site_url+mapImageUrl, 0, 0, mapWidth*scale, mapHeight*scale);

	var x, y;
	var w = cellWidth * scale;
	var h = cellHeight * scale;

	for (x=0;x<gridWidth;x++) {
		var curx = x * w;
		for (y=0;y<gridHeight;y++) {
			var cury = y * h;
			var g = paper.path("M"+curx+" "+cury+"L"+(curx+w)+" "+cury+"L"+(curx+w)+" "+(cury+h));
			
		}
	}
	
	selectedCell = paper.rect(startGridX * cellWidth * scale, startGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#0f0");
	
	selectedCell = paper.rect(finishGridX * cellWidth * scale, finishGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#f00");


	
}


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

var startGridX = 0;
var startGridY = 0;
var finishGridX = 0;
var finishGridY = 0;

window.onload = function () {

	scale = 0.2;
	xoff = 400;
	yoff = 100;
	
	jQuery('#create-game input').attr('readonly', 'readonly');
	

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
			jQuery("#maxNoOfPlayers").val(data.rows[0].maxNoOfPlayers);
			jQuery("#raceName").val(data.rows[0].raceName);
			jQuery("#raceDescription").val(data.rows[0].raceDescription);
			jQuery("#mapName").val(data.rows[0].mapName);
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
						jQuery("#mapId").val(data.result.id);
						jQuery("#mapName").val(data.result.mapName);
						jQuery("#mapImageUrl").val(data.result.mapImageUrl);
						jQuery("#mapWidth").val(data.result.mapWidth);
						jQuery("#mapHeight").val(data.result.mapHeight);
						jQuery("#gridWidth").val(data.result.gridWidth);
						jQuery("#gridHeight").val(data.result.gridHeight);
						jQuery("#cellWidth").val(data.result.cellWidth);
						jQuery("#cellHeight").val(data.result.cellHeight);
						updateMapOptions();
						drawGrid();
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
					   jQuery("#weatherDay"+(i+1)).val(data.rows[i].weather);
					   jQuery("#weatherForecast"+(i+1)).val(data.rows[i].weatherForecast);
					}
					
					
				}
			});
			jQuery('#create-game select').attr('disabled', 'true');
		}
	});
	
	jQuery("#continue").click(function(e) { 
		
		jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_update_race_raceStatus',
					id: raceId,
					raceStatus: 1
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					location.href = site_url+"/active-race/?raceId="+raceId;			
					
				}
			});
		
		
		
		return false;
	} );
	
	jQuery("#startagain").click(function(e) { 
		
		location.href = site_url+"/create-online-race-2/?raceId="+raceId;
		
		return false;
	} );

};

function updateMapOptions() {
	mapName = jQuery("#mapName").val();
	mapImageUrl = jQuery("#mapImageUrl").val();
	mapWidth = jQuery("#mapWidth").val();
	mapHeight = jQuery("#mapHeight").val();
	gridWidth = jQuery("#gridWidth").val();
	gridHeight = jQuery("#gridHeight").val();
	cellWidth = jQuery("#cellHeight").val();
	cellHeight = jQuery("#cellHeight").val();
}
