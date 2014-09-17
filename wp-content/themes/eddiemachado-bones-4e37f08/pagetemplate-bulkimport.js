jQuery(document).ready
(

	function(jQuery)
	{

		var raceId = qs("raceId");
		var option = '';
		var curRow = 0;
	
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

				if (data.rows) 
					jQuery("#raceName").html(data.rows[0].raceName);
				
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
								
				for (i=0;i<data.rows.length;i++){
				   option += '<option value="'+ data.rows[i].tokenName + '">' + data.rows[i].tokenName + '</option>';
				}
				
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_racecharacters',
						raceId: raceId
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);

						if (data.rows) {
							
							for (i=0;i<data.rows.length;i++){
							   addRow(data.rows[i]);
							}
						} else
							addRow();
						
					}
				});
				
				
				
			}
		});
	
		jQuery("#continue").click(function(e) { 
			
			var csv = "";
			var b = false;
			for (i=0;i<curRow;i++) {

				
				if (b)
					csv += '\r\n';
				
				// 	upload if it's not hidden or we are updating a record (so can be hidden - deleted)
				if (!jQuery("#row_"+i).hasClass("myhidden") || jQuery("#row_"+i).attr("racecharacterId") != "") {
					csv += jQuery("#playerName_"+i).val() + '\t';
					csv += jQuery("#tokenId_"+i).val() + '\t';
					csv += jQuery("#drivingStyle_"+i).val() + '\t';
					csv += jQuery("#noOfPitStops_"+i).val() + '\t';
					csv += jQuery("#row_"+i).attr("racecharacterId") + '\t';
					csv += jQuery("#row_"+i).hasClass("myhidden");
				}
				
			
				b = true;
			}
			
			
			
			console.log(csv);
			
			jQuery("#playersCSV").val(csv);
				
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_bulk_import',
					raceId: raceId,
					playersCSV: jQuery("#playersCSV").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					if (data.error == "") {
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_get_racecharacters',
								raceId: raceId
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);

								jQuery("#result").text(data.message + " " + data.error);
								jQuery("#inputTable").html("");
								curRow = 0;
								if (data.rows) {
									
									for (i=0;i<data.rows.length;i++){
									   addRow(data.rows[i]);
									}
								} else
									addRow();
								
							}
						});
					}
					if (data.error == "")
						var n = noty({text: data.message, buttons: [{addClass: 'btn btn-primary', text: 'Close', onClick: function($noty) {
							$noty.close();
							return false;
							}}]});
					else
						var n = noty({text: data.message + " " + data.error, buttons: [{addClass: 'btn btn-primary', text: 'Close', onClick: function($noty) {
							$noty.close();
							return false;
							}}]});
				}
			});
				
			return false;
		} );
		
		function addRow(p) {

			var html = '<tr id="row_'+curRow+'" data-id="'+curRow+'"><td><input id="playerName_'+curRow+'" size="30" data-id="'+curRow+'"></td><td><select id="tokenId_'+curRow+'">'+option+'</select></td><td><select id="drivingStyle_'+curRow+'"><option value="0.1">1</option><option value="0.2">2</option><option value="0.3">3</option><option value="0.4">4</option><option value="0.5" selected>5</option><option value="0.6">6</option><option value="0.7">7</option><option value="0.8">8</option><option value="0.9">9</option><option value="1">10</option></select></td><td><select id="noOfPitStops_'+curRow+'"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5" selected>5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></td><td><input id="remove_'+curRow+'" type="button" value="Remove" data-id="'+curRow+'"/></td></tr>';
			
			jQuery("#inputTable").append(html);
			
			jQuery("#playerName_"+curRow).keyup(function(e) {
				var code = e.which;
				if (code == 13) {
					var id = jQuery(this).attr("data-id");
					
					if (id == findLastRow()) {
						addRow();
					}
				}
			});
			
			jQuery("#remove_"+curRow).click(function() {
				
				if (confirm("Are you sure you want to remove the row?")) {
				
					var id = jQuery(this).attr("data-id");

					jQuery("#row_"+id).addClass("myhidden");
				}
			});
			
			jQuery("#playerName_"+curRow).focus();
			
			jQuery("#row_"+curRow).attr("racecharacterId", "");
			
			if (p) {
				jQuery("#playerName_"+curRow).val(p.playerName);
				jQuery("#tokenId_"+curRow).val(p.tokenName);
				jQuery("#drivingStyle_"+curRow).val(p.drivingStyleWeight);
				jQuery("#noOfPitStops_"+curRow).val(p.noOfPitstops);
				jQuery("#row_"+curRow).attr("racecharacterId", p.id);
			}
			
			
			curRow++;
			//console.log(curRow);
		}
		
		function findLastRow() {
			for (i=curRow-1;i>=0;i--) {
				if (!jQuery("#row_"+i).hasClass("myhidden"))
					return i;
			}
		}
	}
);



function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

