
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

var lastInPlay;

function drawGrid() {

	if (paper) paper.clear();

	paper = Raphael("paperParent", mapWidth*scale, mapHeight*scale);
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
}

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
	
	if (selectedCell) selectedCell.remove();
	

	selectedCell = paper.rect(curx * cellWidth * scale, cury * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#00f");

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
					paper.rect(curx * cellWidth * scale, cury * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("stroke", "#0ff");
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
			var row = '<input type="hidden" id="cellTokenOffsetCount" value="'+data.rows.length+'"/><tr><th>Token</th><th>Value</th><th>In Play</th></tr>';
			var ip;
			for(i=0;i<data.rows.length;i++) {
				if (lastInPlay && lastInPlay[i] && data.rows[i].id == 0) ip = lastInPlay[i]; else ip = data.rows[i].inPlayToken;
				row += '<tr><td>'+data.rows[i].tokenName+'</td><td><input type="hidden" id="mapgridtokenoffsetId_'+i+'" value="'+data.rows[i].id+'"/><input type="hidden" id="tokenId_'+i+'" value="'+data.rows[i].tokenId+'"/><input id="value_'+i+'" type="text" value="'+data.rows[i].value+'"/></td><td><input id="inPlayToken_'+i+'" type="text" value="'+ip+'"/></td></tr>';
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

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

window.onload = function () {

	scale = 0.2;
	xoff = 400;
	yoff = 100;
	
	//drawGrid();
	
	jQuery("#paperParent").click(function(e) { 
	
		selectGrid(e.pageX - jQuery("#paperParent").offset().left + jQuery("#paperParent").scrollLeft(), 
			e.pageY - jQuery("#paperParent").offset().top + jQuery("#paperParent").scrollTop()); 
		
	} );
	var mapId = qs("id");
	jQuery.ajax({
		url: site_url+"/wp-admin/admin-ajax.php",
		type: "POST",
		data: {
			action: 'r2f_action_get_map',
			id: mapId
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
				jQuery("#mapTilesUrl").val(data.result.mapTilesUrl);
				jQuery("#minZoom").val(data.result.minZoom);
				jQuery("#maxZoom").val(data.result.maxZoom);
				jQuery("#boundaryX").val(data.result.boundaryX);
				jQuery("#boundaryY").val(data.result.boundaryY);
				updateMapOptions();
				drawGrid();
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_mapgrids',
						mapId: mapId
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						for(i=0;i<data.rows.length;i++) {
							curx = data.rows[i].gridX;
							cury = data.rows[i].gridY;
							paper.rect(curx * cellWidth * scale, cury * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("stroke", "#0f0");
						}
					}
				});
			}
			
		}
	});
	
};

jQuery(document).ready
(
	function(jQuery)
	{

		jQuery("#mapOptionsTitle").click( function() {
			if(jQuery("#mapOptions").css('display') != "none") 
				jQuery("#mapOptions").css('display', 'none');
			else
				jQuery("#mapOptions").css('display', 'block');
		});
		
		jQuery("#upsertMap").click(function() { 
			jQuery("#mapDataForm").validate();
			if (!jQuery("#mapDataForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_map',
					id: jQuery("#mapId").val(),
					mapName: jQuery("#mapName").val(),
					mapImageUrl: jQuery("#mapImageUrl").val(),
					mapWidth: jQuery("#mapWidth").val(),
					mapHeight: jQuery("#mapHeight").val(),
					gridWidth: jQuery("#gridWidth").val(),
					gridHeight: jQuery("#gridHeight").val(),
					cellWidth: jQuery("#cellWidth").val(),
					cellHeight: jQuery("#cellHeight").val(),
					mapTilesUrl: jQuery("#mapTilesUrl").val(),
					minZoom: jQuery("#minZoom").val(),
					maxZoom: jQuery("#maxZoom").val(),
					boundaryX: jQuery("#boundaryX").val(),
					boundaryY: jQuery("#boundaryY").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					jQuery("#mapId").val(data.id);
					updateMapOptions();
					drawGrid();
				}
			});
			return false;
		} );
		
		jQuery("#upsertMapGrid").click(function() { 
			jQuery("#mapGridDataForm").validate();
			if (!jQuery("#mapGridDataForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_mapgrid',
					id: jQuery("#mapgridId").val(),
					mapId: jQuery("#mapId").val(),
					gridX: jQuery("#gridX").val(),
					gridY: jQuery("#gridY").val(),
					inPlay: jQuery("#inPlay").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					jQuery("#mapgridId").val(data.id);
					getMapGridTokenOffsets();
				
				}
			});
			return false;
		} );
		
		jQuery("#upsertMapGridTokenOffset").click(function() { 
			jQuery("#mapGridTokenOffsetDataForm").validate();
			if (!jQuery("#mapGridTokenOffsetDataForm").valid()) return false;
			var c = jQuery("#cellTokenOffsetCount").val();
			lastInPlay = new Array();
			for(i=0;i<c;i++) {
				var mapgridtokenoffsetId = jQuery("#mapgridtokenoffsetId_"+i).val();
				var mapgridId = jQuery("#mapgridId").val();
				var tokenId = jQuery("#tokenId_"+i).val();
				var value = jQuery("#value_"+i).val();
				var inPlayToken = jQuery("#inPlayToken_"+i).val();
				lastInPlay[i] = inPlayToken;
				//console.log(mapgridId+","+tokenId);
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_upsert_mapgridtokenoffset',
						id: mapgridtokenoffsetId,
						mapgridId: mapgridId,
						tokenId: tokenId,
						value: value,
						i: i,
						inPlayToken: inPlayToken
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						jQuery("#mapgridtokenoffsetId_"+data.i).val(data.id);
					
					}
				});
			}
			return false;
		} );
		
		
	}
);

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
