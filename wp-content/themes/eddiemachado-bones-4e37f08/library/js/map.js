var allPlayers;

var map;
var startGridX, startGridY, finishGridX, finishGridY;
var mapId, mapName, mapImageUrl, mapWidth, mapHeight, gridWidth, gridHeight, cellWidth, cellHeight;
var mapTilesUrl;
var minZoom, maxZoom, boundaryX, boundaryY;
var mapOverlayUrl;
var overlay, tiles;

function drawMap(id, grid) {

	var mapMinZoom = minZoom;
	var mapMaxZoom = maxZoom;
	
	
	
	
	tiles = L.tileLayer(mapTilesUrl+'/{z}/{x}/{y}.png', {
	  minZoom: mapMinZoom, maxZoom: mapMaxZoom,
	  bounds: mapBounds,
	  attribution: '',
	  noWrap: true          
	});
	
	if (mapOverlayUrl != "") {
		overlay = L.tileLayer(mapOverlayUrl+'/{z}/{x}/{y}.png', {
		  minZoom: mapMinZoom, maxZoom: mapMaxZoom,
		  bounds: mapBounds,
		  attribution: '',
		  noWrap: true          
		});
		
		map = L.map(id, {
		  maxZoom: mapMaxZoom,
		  minZoom: mapMinZoom,
		  crs: L.CRS.Simple,
		  layers: [overlay, tiles]
		}).setView([0, 0], mapMinZoom);
		
		var baseMaps = {
			
			"show borders": overlay,
			"hide borders": tiles
		};
		
		L.control.layers(baseMaps, null, { position: 'topleft' }).addTo(map);

		
	} else {
	
		map = L.map(id, {
		  maxZoom: mapMaxZoom,
		  minZoom: mapMinZoom,
		  crs: L.CRS.Simple,
		  layers: [tiles]
		}).setView([0, 0], mapMinZoom);
	}
	
	
	
	var mapBounds = new L.LatLngBounds(
		map.unproject([0, boundaryY], mapMaxZoom),
		map.unproject([boundaryX, 0], mapMaxZoom));
	
	map.fitBounds(mapBounds);	
	
	if (grid)
		drawGrid();
	drawStart();
	drawFinish();
	
	map.on('click', function(e) { 
		if (!allPlayers) return;
		for (i=0;i<allPlayers.length;i++){
			//console.log(allPlayers[i].ll.distanceTo(e.latlng));
			if (allPlayers[i].ll.distanceTo(e.latlng) < 100000) drawAllPlayerHighlight(allPlayers[i]);
		}
	});
	
}


function getLatLng(gridX, gridY, offset) {

	var scale = 4096 / Math.max(mapWidth, mapHeight);
	
	var x = (cellWidth * scale) * gridX;
	var y = (cellHeight * scale) * gridY;
	
	var point = L.point(x, y);
	var ll = map.unproject(point, 4);
	return ll;
}

function getPoint(latLng) {

	var scale = 4096 / Math.max(mapWidth, mapHeight);
	
	var point = map.project(latLng, 4);
	
	var gridX = point.x / (cellWidth * scale);
	var gridY = point.y / (cellHeight * scale);
	
	var point2 = L.point(parseInt(gridX), parseInt(gridY));

	return point2;
}

var startMarker;

function drawStart() {

	var startIcon = L.icon({
		iconUrl: theme_url+"/library/images/flag_green.png",

		iconSize:     [30, 30], // size of the icon
		iconAnchor:   [0, 30], // point of the icon which will correspond to marker's location
		popupAnchor:  [-3, -33] // point from which the popup should open relative to the iconAnchor
	});
	
	var ll = getLatLng(startGridX, startGridY, true);

	if (startMarker) map.removeLayer(startMarker);
	startMarker = L.marker(ll, {icon: startIcon}).addTo(map);
	
	
}

var finishMarker;

function drawFinish() {

	var finishIcon = L.icon({
		iconUrl: theme_url+"/library/images/flag_red.png",

		iconSize:     [30, 30], // size of the icon
		iconAnchor:   [0, 30], // point of the icon which will correspond to marker's location
		popupAnchor:  [-3, -33] // point from which the popup should open relative to the iconAnchor
	});

	var ll = getLatLng(finishGridX, finishGridY, true);

	if (finishMarker) map.removeLayer(finishMarker);
	finishMarker = L.marker(ll, {icon: finishIcon}).addTo(map);
	
}

var icons;
var eventSet = false;

function drawPlayers() {
	
	// remove existing ?
	icons = new Array();
	
	zoom = map.getZoom();
	
	iconWidth = 30 * (zoom-1);
	iconHeight = 30 * (zoom-1);
	
	for (i=0;i<players.length;i++){

		icons[i] = L.icon({
			iconUrl: players[i].tokenImageUrl,

			iconSize:     [iconWidth, iconHeight], // size of the icon
			iconAnchor:   [iconWidth/2, iconHeight/2], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});
		
		players[i].icon = icons[i];

		drawPlayer(players[i]);
	}
	
	if (!eventSet) {
		map.on('zoomend', function() { drawPlayers(); });
		eventSet = true;
	}
}

function drawAllPlayers() {
	
	// remove existing ?
	allIcons = new Array();
	
	zoom = 2;
		
	iconWidth = 30 * (zoom-1);
	iconHeight = 30 * (zoom-1);
	
	for (i=0;i<allPlayers.length;i++){

		allIcons[i] = L.icon({
			iconUrl: allPlayers[i].tokenImageUrl,

			iconSize:     [iconWidth, iconHeight], // size of the icon
			iconAnchor:   [iconWidth/2, iconHeight/2], // point of the icon which will correspond to marker's location
			popupAnchor:  [0, -10] // point from which the popup should open relative to the iconAnchor
		});
		
		allPlayers[i].icon = allIcons[i];

		drawPlayer(allPlayers[i]);
	}
	
}

function removeAllPlayers() {
	if (!allPlayers) return;
	for (i=0;i<allPlayers.length;i++){

		if (allPlayers[i].marker) map.removeLayer(allPlayers[i].marker);
	}
}

function removePlayers() {
	if (!players) return;
	for (i=0;i<players.length;i++){

		if (players[i].marker) map.removeLayer(players[i].marker);
	}
}

function drawGrid() {
	
	for (y=0;y<gridHeight;y++) {
	
		latlngs = new Array();
		latlngs[0] = getLatLng(0, y);
		latlngs[1] = getLatLng(gridWidth, y);
		var polyline = L.polyline(latlngs, {color: 'black', weight: 1}).addTo(map);	
			
	}
	
	for (x=0;x<gridWidth;x++) {
	
		latlngs = new Array();
		latlngs[0] = getLatLng(x, 0);
		latlngs[1] = getLatLng(x, gridHeight);
		var polyline = L.polyline(latlngs, {color: 'black', weight: 1}).addTo(map);	
			
	}

	
}

function drawPlayer(p) {
	
	if (p.marker) map.removeLayer(p.marker);
	
	var ll = getLatLng(p.gridX, p.gridY);

	p.marker = L.marker(ll, {icon: p.icon});
	
	p.ll = ll;
	
	if (current_user_id != 0 && p.playerId == current_user_id) {
		drawPlayerHighlight(p);
	}

	p.marker.riseOnHover = true;
	
	p.marker.on('click', function () {
		console.log("hello");
	});
	
	p.marker.addTo(map);
	
	//console.log(p.marker);
	
}

function drawCell(x, y) {

	latlngs = new Array();
	latlngs[0] = getLatLng(x, y);
	latlngs[1] = getLatLng(x+1, y+1);
	
	var cell = L.rectangle(latlngs, {color: 'blue', weight: 1, fillOpacity: 0.8}).addTo(map);	
	
	return cell;
	
}

function drawPlayerHighlight(p) {
	
	for (i=0;i<players.length;i++){
		if (players[i].marker) players[i].marker.setZIndexOffset(0);
	}
	
	p.marker.setZIndexOffset(1000);
	
	var pt = "<b>"+p.playerName+"</b>";
		
	if (p.user_email) pt += "<br/>"+p.user_email;
	if (p.address) pt += "<br/>"+p.address;
	if (p.telephone) pt += "<br/>"+p.telephone;
	p.marker.bindPopup(pt).openPopup();
		
	map.panTo(p.ll);
	
	
}

function drawAllPlayerHighlight(p) {
	
	for (i=0;i<allPlayers.length;i++){
		if (allPlayers[i].marker) allPlayers[i].marker.setZIndexOffset(0);
	}
	
	p.marker.setZIndexOffset(1000);
	
	var pt = "<b>"+p.playerName+"</b>";
		
	if (p.user_email) pt += "<br/>"+p.user_email;
	if (p.address) pt += "<br/>"+p.address;
	if (p.telephone) pt += "<br/>"+p.telephone;
	p.marker.bindPopup(pt).openPopup();
		
	map.panTo(p.ll);
	
	
}
