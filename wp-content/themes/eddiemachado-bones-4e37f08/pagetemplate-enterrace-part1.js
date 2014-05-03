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
	
//	selectedCell = paper.rect(startGridX * cellWidth * scale, startGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#0f0");
//	selectedCell = paper.rect(finishGridX * cellWidth * scale, finishGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#f00");

	selectedCell = paper.image(theme_url+"/library/images/flag_green.png", startGridX * cellWidth * scale, startGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
	selectedCell = paper.image(theme_url+"/library/images/flag_red.png", finishGridX * cellWidth * scale, finishGridY * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale);
}
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


	var raceId = qs("raceId");
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
						scale = data.result.mapWidth / 12521.0;
						jQuery("#mapScale").val(scale);
						drawGrid();
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
					    jQuery("#weatherForecast"+(i+1)).val(data.rows[i].weatherForecast);
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
			+"&noOfPitstops="+jQuery("#noOfPitstops").val();
		return false;
	} );
	
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
			
		});
};

