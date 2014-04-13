
jQuery(document).ready
(
	function(jQuery)
	{
		var rowHtml = jQuery("#templateDiv").html();
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_races',
				page: 0,
				rows: 100
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				var row = "";
				for(i=0;i<data.records;i++) {
					r = rowHtml;
					r = r.replace(/{id}/g, data.rows[i].cell[0]);
					r = r.replace(/{raceName}/g, data.rows[i].cell[1]);
					r = r.replace(/{mapName}/g, data.rows[i].cell[2]);
					r = r.replace(/{charityName}/g, data.rows[i].cell[5]);
					r = r.replace(/{start}/g, data.rows[i].cell[6]);
					r = r.replace(/{stime}/g, data.rows[i].cell[7]);
					r = r.replace(/{finish}/g, data.rows[i].cell[8]);
					r = r.replace(/{ftime}/g, data.rows[i].cell[9]);
					r = r.replace(/{maxNoOfPlayers}/g, data.rows[i].cell[11]);
					r = r.replace(/{raceStatus}/g, data.rows[i].cell[3] ? 'Active' : 'Complete');
					r = r.replace(/{viewMoreUrl}/g,site_url+'/active-race/?raceId='+data.rows[i].cell[0]);
					r = r.replace(/{inviteUrl}/g,site_url+'/active-race/?raceId='+data.rows[i].cell[0]);
					r = r.replace(/{createUrl}/g,site_url+'/enter-race/?raceId='+data.rows[i].cell[0]);
					r = r.replace(/{stopActivateUrl}/g,site_url+'/edit-online-race/?raceId='+data.rows[i].cell[0]);
					row += r;
					
					
				}
				jQuery("#raceResultsActive").html(row);
			}
		});
	}
);
