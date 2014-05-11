
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
				rows: 100,
				createdBy: current_user_id
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
					r = r.replace(/{maxNoOfPlayers}/g, data.rows[i].cell[12]+" of "+data.rows[i].cell[11]);
					r = r.replace(/{raceStatus}/g, data.rows[i].cell[3] ? 'Active' : 'Complete');
					r = r.replace(/{viewMoreUrl}/g,site_url+'/active-race/?raceId='+data.rows[i].cell[0]);
					r = r.replace(/{tweetUrl}/g,'https://twitter.com/intent/tweet?text='+encodeURIComponent(data.rows[i].cell[1])+'&url='+ encodeURIComponent(site_url+'/active-race/?raceId='+data.rows[i].cell[0]));
					r = r.replace(/{fbUrl}/g,'https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(site_url+'/enter-race/?raceId='+data.rows[i].cell[0])+'&t='+encodeURIComponent(data.rows[i].cell[1]));
					r = r.replace(/{mailtoUrl}/g,'mailto:?subject='+encodeURIComponent(data.rows[i].cell[1])+'&body=Join the fun! '+encodeURIComponent(site_url+'/enter-race/?raceId='+data.rows[i].cell[0]));
					r = r.replace(/{createUrl}/g,site_url+'/enter-race/?raceId='+data.rows[i].cell[0]);
					r = r.replace(/{stopActivateUrl}/g,site_url+'/edit-online-race/?raceId='+data.rows[i].cell[0]);
					row += r;
					
					
				}
				jQuery("#raceResultsActive").html(row);
			}
		});
		
		var rowHtmlSub = jQuery("#templateDivSubs").html();
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_subs',
				page: 0,
				rows: 100
			},
			dataType: "JSON",
			success: function (data) {
				
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				var row = "";
				
				for(i=0;i<data.result.length;i++) {
					r = rowHtmlSub;
					r = r.replace(/{subDate}/g, data.result[i].created);
					r = r.replace(/{subDesc}/g, data.result[i].item_name);
					r = r.replace(/{createRaceUrl}/g,site_url+'/create-online-race-1/?subId='+data.result[i].id);
					row += r;
					
					
				}
				jQuery("#subsResultsActive").html(row);
			}
		});
		
		jQuery("#comingsoon").click(function(e) {
			e.preventDefault;
			alert ("This feature is coming soon!");
			return false;
		});
	}
);
