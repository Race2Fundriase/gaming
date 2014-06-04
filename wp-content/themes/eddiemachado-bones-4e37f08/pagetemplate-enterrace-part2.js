
var selectedCell;

var inPlays;

var selectedCells = [];

function selectGrid(x, y) {

	
	curx = x;
	cury = y;
		
	if (inPlays && inPlays[curx] && inPlays[curx][cury] && inPlays[curx][cury] == "0") return;
	
//	if (selectedCell) selectedCell.remove();
	
	if (selectedCells.length == 0 ) {
		if (Math.abs(startGridX - curx) > 1 || Math.abs(startGridY.y - cury) > 1) return;
	}
	
	for(i=0;i<selectedCells.length;i++) {
	
		if (selectedCells[i].x == curx && selectedCells[i].y == cury) {
			if (i == selectedCells.length - 1) {
				//selectedCells[i].cell.remove();
				map.removeLayer(selectedCells[i].cell);
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

	//var aCell = paper.rect(curx * cellWidth * scale, cury * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#00f");
	var aCell = drawCell(curx, cury);

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
	
	
	var raceId = qs("raceId");
	var playerName = qs("playerName");
	var tokenId = qs("tokenId");
	var drivingStyleWeight = qs("drivingStyleWeight");
	var noOfPitstops = qs("noOfPitstops");
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
						
						map.on('click', function(e) {
		
							var p = getPoint(e.latlng);
							selectGrid(p.x, p.y);
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
								for (i=0;i<data.rows.length;i++){
								   option += '<option value="'+ data.rows[i].tokenId + '">' + data.rows[i].tokenName + '</option>';
								}
								jQuery('#tokenId').append(option);
							}
						});
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_get_mapgridtokenoffsets_bymap',
								mapId: data.result.id,
								tokenId: tokenId
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);
								jQuery("#result").text(data.message + " " + data.error);
								inPlays = createArray(jQuery("#gridWidth").val(), jQuery("#gridHeight").val());
								for(x=0;x<jQuery("#gridWidth").val();x++) 
									for(y=0;y<jQuery("#gridHeight").val();y++)
										inPlays[x][y] = "1";
																	
								for(i=0;i<data.rows.length;i++) {
									if(data.rows[i].inPlay == "0" || data.rows[i].inPlayToken == "0")
										if (data.rows[i].gridX < jQuery("#gridWidth").val() && 
											data.rows[i].gridY < jQuery("#gridHeight").val())
											inPlays[data.rows[i].gridX][data.rows[i].gridY] = "0";
								}
								
							}
						});
					}
					
				}
			});

			
		}
	});
	
	jQuery("#continue").click(function(e) { 
		
		if (selectedCells.length > 0 ) {
			var lastCell = selectedCells[selectedCells.length-1];
			
			if (Math.abs(lastCell.x - finishGridX) > 1 || Math.abs(lastCell.y - finishGridY) > 1) {
				jQuery("#feedback").text("You must finish at the finish grid position.");
				return false;
				
			}
			
			// if we get here we are good to go - calculate the route, save the entry and re-direct to the race view
			//tokenId = jQuery("#tokenId").val();
			playerId = current_user_id;
			joinDate = d.yyyymmdd();
			route = "";
			//playerName = jQuery("#playerName").val();
			for(i=0;i<selectedCells.length;i++) {
				route += selectedCells[i].x + ',' + selectedCells[i].y + '|';
			}
			
			//drivingStyleWeight = jQuery("#drivingStyleWeight").val();
			//noOfPitstops = jQuery("#noOfPitstops").val();

			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_purchase_check',
					raceId: raceId,
					playerId: current_user_id
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					
					jQuery.ajax({
						url: site_url+"/wp-admin/admin-ajax.php",
						type: "POST",
						data: {
							action: 'r2f_action_upsert_racecharacters',
							id: "",
							raceId: raceId,
							tokenId: tokenId,
							playerId: playerId,
							joinDate: joinDate,
							route: route,
							drivingStyleWeight: drivingStyleWeight,
							noOfPitstops: noOfPitstops,
							playerName: playerName,
							transactionId: data.id
						},
						dataType: "JSON",
						success: function (data) {
							console.log(data);
							jQuery("#result").text(data.message + " " + data.error);
							if (data.error == "")
								location.href = site_url+"/enter-race-part-3/?raceId="+raceId+"&racecharacterId="+data.id;
						}
					});
					
					
					
					
				}
			});
				
			
			
		}
		jQuery("#feedback").text("You must choose a route.");
		return false;
	} );
	
	jQuery("#random").click(function(e) { 
		playerId = current_user_id;
		joinDate = d.yyyymmdd();
		route = "random";
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_upsert_racecharacters',
				id: "",
				raceId: raceId,
				tokenId: tokenId,
				playerId: playerId,
				joinDate: joinDate,
				route: route,
				drivingStyleWeight: drivingStyleWeight,
				noOfPitstops: noOfPitstops,
				playerName: playerName,
				transactionId: transactionId
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				if (data.error == "")
					location.href = site_url+"/enter-race-part-3/?raceId="+raceId+"&racecharacterId="+data.id;
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
function createArray(length) {
    var arr = new Array(length || 0),
        i = length;

    if (arguments.length > 1) {
        var args = Array.prototype.slice.call(arguments, 1);
        while(i--) arr[length-1 - i] = createArray.apply(this, args);
    }

    return arr;
}
