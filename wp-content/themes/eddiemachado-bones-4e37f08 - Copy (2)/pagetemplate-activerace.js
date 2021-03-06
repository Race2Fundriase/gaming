var paper;
var scale = 0.2;
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

var startGridX = 0;
var startGridY = 0;
var finishGridX = 0;
var finishGridY = 0;

function drawGrid() {

	if (paper) paper.clear();

	paper = Raphael("paperParentAR", mapWidth*scale, mapHeight*scale);
	paper.image(site_url+mapImageUrl, 0, 0, mapWidth*scale, mapHeight*scale);

	console.log(scale);
	
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

jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		
		jQuery("#day").change(function(e) {
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_leaderboard',
					raceId: raceId,
					day: jQuery("#day").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					var li = '';
					drawGrid();
					for (i=0;i<data.rows.length;i++){
					   li += '<li>'+ data.rows[i].name + '(' + data.rows[i].tokenName + ')</li>';
					   rcImageUrl = site_url+data.rows[i].tokenImageUrl;
					   var aImage = paper.image(rcImageUrl, data.rows[i].gridX * cellWidth * scale, data.rows[i].gridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
					}
					jQuery('#leaderboard').html(li);
				}
			});
		});
		
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
				jQuery("#startDate").html(data.rows[0].startDate);
				jQuery("#finishDate").html(data.rows[0].finishDate);
				jQuery("#raceName").html(data.rows[0].raceName);
				jQuery("#raceDescription").html(data.rows[0].raceName);
				jQuery("#mapName").html(data.rows[0].mapName);
				jQuery("#weather").html(data.rows[0].weather);
				jQuery("#terrain").html(data.rows[0].terrain);
				
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
							jQuery.ajax({
								url: site_url+"/wp-admin/admin-ajax.php",
								type: "POST",
								data: {
									action: 'r2f_action_get_leaderboard',
									raceId: raceId,
									day: 0
								},
								dataType: "JSON",
								success: function (data) {
									console.log(data);
									jQuery("#result").text(data.message + " " + data.error);
									var li = '';
									for (i=0;i<data.rows.length;i++){
									   li += '<li>'+ data.rows[i].name + '(' + data.rows[i].tokenName + ')</li>';
									   rcImageUrl = site_url+data.rows[i].tokenImageUrl;
									   console.log(rcImageUrl);
									   //var aCell = paper.rect(data.rows[i].gridX * cellWidth * scale, data.rows[i].gridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "url("+rcImageUrl+")");
									   var aImage = paper.image(rcImageUrl, data.rows[i].gridX * cellWidth * scale, data.rows[i].gridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
									}
									jQuery('#leaderboard').append(li);
								}
							});
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
						var row = "";
						var rowHtml = jQuery("#templateDiv").html();
						for(i=0;i<data.rows.length;i++) {
							r = rowHtml;
							r = r.replace(/{image}/g, site_url+'/'+data.rows[i].tokenImageUrl);
							r = r.replace(/{tokenName}/g, data.rows[i].tokenName);
							row += r;
						}
						jQuery("#charactersResults").html(row);
					}
				});
				
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_upsert_racecharactersScore',
						id: raceId
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						var li = '';
						for (i=0;i<data.lengthInDays;i++){
						   li += '<option value="'+(i+1)+'">'+ (i + 1) + '</option>';
						}
						jQuery('#day').append(li);
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

