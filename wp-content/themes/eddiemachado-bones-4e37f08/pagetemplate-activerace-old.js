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

	if (paper) paper.remove();

	paper = Raphael("paperParentAR", mapWidth*scale, mapHeight*scale);
	paper.image(site_url+mapImageUrl, 0, 0, mapWidth*scale, mapHeight*scale);
	
	//console.log(scale);
	
	/*var x, y;
	var w = cellWidth * scale;
	var h = cellHeight * scale;

	for (x=0;x<gridWidth;x++) {
		var curx = x * w;
		for (y=0;y<gridHeight;y++) {
			var cury = y * h;
			var g = paper.path("M"+curx+" "+cury+"L"+(curx+w)+" "+cury+"L"+(curx+w)+" "+(cury+h));
			
		}
	}*/
	
	//selectedCell = paper.rect(startGridX * cellWidth * scale, startGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#0f0");
	
	
	//selectedCell = paper.rect(finishGridX * cellWidth * scale, finishGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#f00");

	selectedCell = paper.image(theme_url+"/library/images/flag_green.png", startGridX * cellWidth * scale, startGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
	selectedCell = paper.image(theme_url+"/library/images/flag_red.png", finishGridX * cellWidth * scale, finishGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);

}

var players;

var selPlayer;
var raceStatus;
var curDay;
var curHour;

function drawPlayers() {

	for (i=0;i<players.length;i++){
		rcImageUrl = site_url+players[i].tokenImageUrl;
		
		if (curDay < 0) x = startGridX; else x = players[i].gridX;
		if (curDay < 0) y = startGridY; else y = players[i].gridY;
			
	    var playercell = paper.image(rcImageUrl,x * cellWidth * scale, y * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
		
		jQuery(playercell.node).qtip({ // Grab some elements to apply the tooltip to
			content: {
				text: 'My common piece of text here'
			},
			position: {
				target: 'mouse'
			}
		});

		if (players[i].playerId == current_user_id)
			paper.circle(x * cellWidth * scale + ((cellWidth * scale) / 2), y * cellWidth * scale + ((cellWidth * scale) / 2), cellWidth * scale).attr("stroke", "#f00");
	}
}

jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		var md = false;
		;
		
		jQuery("#featured").change( function(e) {
			var f = jQuery(this).prop('checked') ? 1 : 0;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_update_race_featured',
					id: raceId,
					featured: f
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					
					
				}
			});
		});
		
		
		jQuery('#frame').on('mousedown', function(e) {
			jQuery(this).data('p0', { x: e.pageX, y: e.pageY });
			md = true;
		}).on('mouseup', function(e) {
			md = false;
		}).on('mousemove', function(e) {
			if (md) {
				var p0 = jQuery(this).data('p0');
				var curX = parseInt(jQuery('#paperParentAR').css('left'), 10);
				var curY = parseInt(jQuery('#paperParentAR').css('top'), 10);
				
				jQuery('#paperParentAR').css('left', curX + e.pageX - p0.x);
				jQuery('#paperParentAR').css('top', curY + e.pageY - p0.y);
				
				jQuery(this).data('p0', { x: e.pageX, y: e.pageY });
			}
		});
		
		jQuery("#mapScale").change(function(e) {
			scale = jQuery("#mapScale").val();
			drawGrid();
			drawPlayers();
		});
		
		jQuery("#day, #hour").change(function(e) {
				
			getLeaderBoard(raceId, jQuery("#day").val(), jQuery("#hour").val(), raceStatus);
		
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
				var dateParts = data.rows[0].startDate.split("-");
				var d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
				//jQuery("#startDate").html(d.toLocaleDateString());
				jQuery("#startDate").html(d.ddmmyyyy());
				jQuery("#startTime").html(data.rows[0].startTime);
				dateParts = data.rows[0].finishDate.split("-");
				d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
				//jQuery("#finishDate").html(d.toLocaleDateString());
				jQuery("#finishDate").html(d.ddmmyyyy());
				jQuery("#finishTime").html(data.rows[0].finishTime);
				jQuery("#raceName").html(data.rows[0].raceName);
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
							jQuery("#mapId").val(data.result.id);
							jQuery("#mapName").val(data.result.mapName);
							jQuery("#mapImageUrl").val(data.result.mapImageUrl);
							jQuery("#mapWidth").val(data.result.mapWidth);
							jQuery("#mapHeight").val(data.result.mapHeight);
							jQuery("#gridWidth").val(data.result.gridWidth);
							jQuery("#gridHeight").val(data.result.gridHeight);
							jQuery("#cellWidth").val(data.result.cellWidth);
							jQuery("#cellHeight").val(data.result.cellHeight);
							jQuery("#mapScale").val(data.result.mapWidth / 12521.0);
							if (data.result.id == 3) {
								jQuery("#mapScale").val(0.1);
								
							}
							scale = jQuery("#mapScale").val();
							updateMapOptions();
							drawGrid();
							getLeaderBoard(raceId, curDay, curHour, raceStatus);
							
							
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
							r = r.replace(/{index}/g, i);
							row += r;
						}
						jQuery("#charactersResults").html(row);
						
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
					}
				});
				
				
				
				
				
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
						
					}
				});
			}
		});
		
		jQuery("#next").click(function (e) {
			if (!n) return;
			curPage++;
			getLeaderBoard(raceId, curDay, curHour, raceStatus);
		});
		jQuery("#prev").click(function (e) {
			if (!p) return;
			curPage--;
			getLeaderBoard(raceId, curDay, curHour, raceStatus);
		});
		
		//getActiveRaces();

	}
);

var curPage = 1;
var n, p;
var limit = 10;

function getLeaderBoard(raceId, day, hour, raceStatus) {
	console.log("glb "+raceId+":"+day+":"+hour);
	jQuery.ajax({
		url: site_url+"/wp-admin/admin-ajax.php",
		type: "POST",
		data: {
			action: 'r2f_action_get_leaderboard',
			raceId: raceId,
			day: day,
			hour: hour,
			page: curPage,
			rows: limit
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			jQuery("#result").text(data.message + " " + data.error);
			var li = '';
			players = new Array();
			start = limit*curPage - limit;
			for (i=0;i<data.rows.length;i++){
				
			   li += '<li id="lbli'+data.rows[i].playerId+'" data-index="'+i+'">'+ (start+i+1) + '. '+ data.rows[i].name + ' (' + data.rows[i].tokenName + ')</li>';
			   rcImageUrl = site_url+data.rows[i].tokenImageUrl;
			   players[i] = data.rows[i];
			   //var aImage = paper.image(rcImageUrl, data.rows[i].gridX * cellWidth * scale, data.rows[i].gridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
				/*jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_leaderboard_history',
						raceId: raceId,
						playerId, data.rows[i].playerId,
						day: 0
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						var row = "";
						
						for(i=0;i<data.rows.length;i++) {
							r = '<div style="width: 10px">';
							r += data.rows[i].position;
							r += '</div>';
							row += r;
						}
						jQuery("#lbli"+data.rows[i].playerId).append(row);
					}
				});*/
			}
			
			if (data.total_pages > 1) {
				/*jQuery("#next").addClass("hidden");
				jQuery("#prev").addClass("hidden");
				if (curPage != data.total_pages) 
					jQuery("#next").removeClass("hidden");
				if (curPage > 1)
					jQuery("#prev").removeClass("hidden");*/
				if (curPage != data.total) 
						n = true;
					else
						n = false;
					if (curPage > 1)
						p = true;
					else
						p = false;
			}
			
			jQuery('#leaderboard').html(li);
			
			jQuery("#pager").html("Page "+curPage+" of " +data.total_pages);
			
			for (i=0;i<data.rows.length;i++){
				jQuery("#lbli"+data.rows[i].playerId).click(function (e) {
					j = jQuery(this).attr("data-index");
					if (selPlayer) selPlayer.remove();
					if (curDay < 0) x = startGridX; else x = players[j].gridX;
					if (curDay < 0) y = startGridY; else y = players[j].gridY;			
					selPlayer = paper.circle(x * cellWidth * scale + ((cellWidth * scale) / 2), y * cellWidth * scale + ((cellWidth * scale) / 2), (cellWidth * scale) - 2).attr("stroke", "#0f0");
				});
			}
			
			if (raceStatus == 1) {
				jQuery("#winnerName").html(data.rows[0].name);
				jQuery("#winnerTokenName").html(data.rows[0].tokenName);
				jQuery("#winbanner").css("display", "block");
				data.rows[0].gridX = finishGridX;
				data.rows[0].gridY = finishGridY;
				jQuery("#pageTitle").html("Completed Race");
			}
			drawPlayers();
		}
	});
}

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