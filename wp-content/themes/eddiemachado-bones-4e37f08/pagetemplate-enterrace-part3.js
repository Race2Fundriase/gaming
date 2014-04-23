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

	paper = Raphael("paperParent1", mapWidth*scale, mapHeight*scale);
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

var selectedCells = [];

function selectGrid(x, y) {

	
	// bring back to origin of paper
	//x = (x - xoff);
	//y = (y - yoff);
	
	// add the scroll of the div
	

	curx = x;
	curx = curx / (cellWidth * scale);
	
	cury = y;
	cury = cury / (cellHeight * scale);
	
	curx = Math.floor(curx);
	cury = Math.floor(cury);
	
//	if (selectedCell) selectedCell.remove();
	
	if (selectedCells.length == 0 ) {
		if (Math.abs(startGridX - curx) > 1 || Math.abs(startGridY.y - cury) > 1) return;
	}
	
	for(i=0;i<selectedCells.length;i++) {
	
		if (selectedCells[i].x == curx && selectedCells[i].y == cury) {
			if (i == selectedCells.length - 1) {
				selectedCells[i].cell.remove();
				selectedCells.splice(i, 1);
				console.log("removed");
			}
			return;
		}
	
	}
	
	if (selectedCells.length > 0 ) {
		var lastCell = selectedCells[selectedCells.length-1];
		
		if (Math.abs(lastCell.x - curx) > 1 || Math.abs(lastCell.y - cury) > 1) return;
		
	}

	var aCell = paper.rect(curx * cellWidth * scale, cury * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#00f");

	sCell = { cell: aCell, x: curx, y: cury };
	
	selectedCells.push(sCell);
			
	jQuery("#gridX").val(curx);
	jQuery("#gridY").val(cury);
	
	mapId = jQuery("#mapId").val();
	
	jQuery.ajax({
		url: site_url+"/wp-admin/admin-ajax.php",
		type: "POST",
		data: {
			action: 'r2f_action_get_mapgrid',
			mapId: mapId,
			gridX: curx,
			gridY: cury
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			jQuery("#result").text(data.message + " " + data.error);
			if (data.error == "") {
				if (data.result) {
					jQuery("#mapgridId").val(data.result.id);
					jQuery("#inPlay").val(data.result.inPlay);
					getMapGridTokenOffsets();
				} else {
					jQuery("#mapgridId").val("");
					jQuery("#inPlay").val(1);
					jQuery("#tokenOffsetResults").html("");
				}
			}
			
		}
	});
}

function getMapGridTokenOffsets() {
	var mapgridId = jQuery("#mapgridId").val();
	jQuery.ajax({
		url: site_url+"/wp-admin/admin-ajax.php",
		type: "POST",
		data: {
			action: 'r2f_action_get_mapgridtokenoffsets',
			mapgridId: mapgridId
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			jQuery("#result").text(data.message + " " + data.error);
			var row = '<input type="hidden" id="cellTokenOffsetCount" value="'+data.rows.length+'"/><tr><th>Token</th><th>Value</th></tr>';
			for(i=0;i<data.rows.length;i++) {
				row += '<tr><td>'+data.rows[i].tokenName+'</td><td><input type="hidden" id="mapgridtokenoffsetId_'+i+'" value="'+data.rows[i].id+'"/><input type="hidden" id="tokenId_'+i+'" value="'+data.rows[i].tokenId+'"/><input id="value_'+i+'" type="text" value="'+data.rows[i].value+'"/></td></tr>';
			}
			jQuery("#tokenOffsetResults").html(row);
		}
	});
}

function handleEvent(e){
 var elem, evt = e ? e:window.event;
 var clickX=0, clickY=0;

 if (evt.srcElement)  elem = evt.srcElement;
 else if (evt.target) elem = evt.target;
 if (elem && elem.tagName.toLowerCase()=='a') return true;

 if ((evt.clientX || evt.clientY) &&
     document.body &&
     document.body.scrollLeft!=null) {
  clickX = evt.clientX + document.body.scrollLeft;
  clickY = evt.clientY + document.body.scrollTop;
 }
 if ((evt.clientX || evt.clientY) &&
     document.compatMode=='CSS1Compat' && 
     document.documentElement && 
     document.documentElement.scrollLeft!=null) {
  clickX = evt.clientX + document.documentElement.scrollLeft;
  clickY = evt.clientY + document.documentElement.scrollTop;
 }
 if (evt.pageX || evt.pageY) {
  clickX = evt.pageX;
  clickY = evt.pageY;
 }

 //selectGrid(clickX, clickY);
 
 return false;
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
	
	//drawGrid();
	
	jQuery("#paperParent1").click(function(e) { 
	
		selectGrid(e.pageX - jQuery("#paperParent1").offset().left + jQuery("#paperParent1").scrollLeft(), 
			e.pageY - jQuery("#paperParent1").offset().top + jQuery("#paperParent1").scrollTop()); 
		
	} );
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
							jQuery("#playerName").html(data.rows[0].playerName);
							jQuery("#drivingStyleWeight").html(data.rows[0].drivingStyleWeight);
							jQuery("#noOfPitstops").html(data.rows[0].noOfPitstops);
							jQuery("#tokenName").html(data.rows[0].tokenName);
							
							// Draw the Route
							var r = data.rows[0].route.split('|');
							for(i=0;i<r.length;i++) {
								if (r[i] != "") {
									var p = r[i].split(',');
									var x = p[0];
									var y = p[1];
									selectedCell = paper.rect(x * cellWidth * scale, y * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#00f");
								}
							}
						}
					});
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
					location.href = site_url+"/active-race/?raceId="+raceId;
			}
		});
			
		
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
