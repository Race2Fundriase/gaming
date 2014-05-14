
jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		var md = false;
		var share = qs("share");
		
		
		
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
				
				if (share) {
					var s = 'Welcome to the race. Share it with your friends.';
					//button += '<a href="#" onclick=";">Tweet</a>';
					
					var n = noty({
						text: s, 
						buttons: [
							{addClass: 'btn btn-primary', text: 'Tweet', onClick: function($noty) {
							window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent(data.rows[0].raceName)+'&url='+ encodeURIComponent(site_url+'/active-race/?raceId='+raceId), "_blank", "height=300,width=500"); 
							return false;
							}},
							{addClass: 'btn btn-primary', text: 'Facebook', onClick: function($noty) {
							window.open('https://www.facebook.com/sharer/sharer.php?t='+encodeURIComponent(data.rows[0].raceName)+'&u='+ encodeURIComponent(site_url+'/active-race/?raceId='+raceId), "_blank", "height=300,width=500"); 
							return false;
							}},
							{addClass: 'btn btn-primary', text: 'Close', onClick: function($noty) {
							$noty.close();
							return false;
							}}
						],
						closeWith: ['click']
					});
				}
				
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
							
							getLeaderBoard(raceId, curDay, curHour, raceStatus);
							
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
		
		jQuery("#lsearch").submit(function(e) {
			e.preventDefault();
			getLeaderBoard(raceId, curDay, curHour, raceStatus, jQuery("#q").val());
			return false;
		});

	}
);

var curPage = 1;
var n, p;
var limit = 10;

function getLeaderBoard(raceId, day, hour, raceStatus, q) {
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
			rows: limit, 
			q: q
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			jQuery("#result").text(data.message + " " + data.error);
			
			var li = '';
			players = new Array();
			if (data.rows) {
				start = limit*curPage - limit;
				for (i=0;i<data.rows.length;i++){
					
				   li += '<li id="lbli'+i+'" data-index="'+i+'">'+ data.rows[i].pos + '. '+ data.rows[i].name + ' (' + data.rows[i].tokenName + ')</li>';
				   rcImageUrl = site_url+data.rows[i].tokenImageUrl;
				   players[i] = data.rows[i];
				   if (curDay < 0) players[i].gridX = startGridX;
				   if (curDay < 0) players[i].gridY = startGridY;	
				   
				}
				
				if (raceStatus == 1) {
					players[0].gridX = finishGridX;
					players[0].gridY = finishGridY;
				}
				
				if (data.total_pages > 1) {
					
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
					jQuery("#lbli"+i).click(function (e) {
						j = jQuery(this).attr("data-index");
						drawPlayerHighlight(players[j]);
					});
					jQuery("#lbli"+i).addClass("mypointer");
				}
			} else {
				jQuery('#leaderboard').html("");
				
				jQuery("#pager").html("");
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