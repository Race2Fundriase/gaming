jQuery(document).ready
(
	function(jQuery)
	{
		
		var q = qs('race-s');
		var p, n, curPage = 1;
		var rowHtml = jQuery("#templateDiv").html();
		function getActiveRaces() {
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_races',
					page: curPage,
					rows: 5,
					raceStatus: 0,
					q: q,
					private: 0
				},
				dataType: "JSON",
				success: function (data) {
					
					try {console.log(data);} catch(err) { alert(err.message); }
					
					jQuery("#result").text(data.message + " " + data.error);
					
					var row = "";
					
					for(i=0;i<data.records;i++) {
						r = rowHtml;
						r = r.replace(/{id}/g, data.rows[i].cell[0]);
						r = r.replace(/{index}/g, i);
						r = r.replace(/{raceName}/g, data.rows[i].cell[1]);
						r = r.replace(/{mapName}/g, data.rows[i].cell[2]);
						r = r.replace(/{charityName}/g, data.rows[i].cell[5]);
						//r = r.replace(/{start}/g, data.rows[i].cell[6]);
						r = r.replace(/{start}/g, convertDateTimeToDate(data.rows[i].cell[6], data.rows[i].cell[7]));
						//r = r.replace(/{stime}/g, data.rows[i].cell[7]);
						r = r.replace(/{stime}/g, convertDateTimeToTime(data.rows[i].cell[6], data.rows[i].cell[7]));
						//r = r.replace(/{finish}/g, data.rows[i].cell[8]);
						r = r.replace(/{finish}/g, convertDateTimeToDate(data.rows[i].cell[8], data.rows[i].cell[9]));
						//r = r.replace(/{ftime}/g, data.rows[i].cell[9]);
						r = r.replace(/{ftime}/g, convertDateTimeToTime(data.rows[i].cell[8], data.rows[i].cell[9]));
						r = r.replace(/{image}/g, data.rows[i].cell[10]);
						r = r.replace(/{viewMoreUrl}/g,site_url+'/active-race/?raceId='+data.rows[i].cell[0]);
						if (data.rows[i].canEnter && current_user_id != 0) {
							r = r.replace(/{enterRaceUrl}/g,site_url+'/purchase-token/?raceId='+data.rows[i].cell[0]);
						} else if (data.rows[i].canEnter && current_user_id == 0) {
							r = r.replace(/{enterRaceUrl}/g,site_url+'/token-join/?raceId='+data.rows[i].cell[0]);
						} else {
							r = r.replace(/{enterRaceUrl}/g,"");
							r = r.replace(/{enterRaceClass}/g,"myhidden");
						}
						row += r;
						
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_get_leaderboard',
								raceId: data.rows[i].cell[0]
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);
								jQuery("#result").text(data.message + " " + data.error);
								var li = '';
								for (i=0;i<data.rows.length;i++){
								   li += '<li>'+ data.rows[i].name + '</li>';
								}
								jQuery('#leaderboard_'+data.id).append(li);
							}
						});
						
					}
					jQuery("#raceResultsActive").html(row);
					
					for(i=1;i<data.records;i++) {
						jQuery("#race_"+i).addClass("top-bg-alt");
					}
					
					if (data.total > 1) {
						/*jQuery("#next").addClass("myhidden");
						jQuery("#prev").addClass("myhidden");
						if (curPage != data.total_pages) 
							jQuery("#next").removeClass("myhidden");
						if (curPage > 1)
							jQuery("#prev").removeClass("myhidden");*/
						if (curPage != data.total) 
							n = true;
						else
							n = false;
						if (curPage > 1)
							p = true;
						else
							p = false;
					}
					
					jQuery("#pager").html("Page "+curPage+" of " +data.total);
				}
			});
		}

		jQuery("#next").click(function (e) {
			if (!n) return;
			curPage++;
			getActiveRaces();
		});
		jQuery("#prev").click(function (e) {
			if (!p) return;
			curPage--;
			getActiveRaces();
		});
		
		getActiveRaces();
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_races',
				page: 0,
				rows: 100,
				raceStatus: 1,
				q: q,
				private: 0
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
					r = r.replace(/{image}/g, data.rows[i].cell[10]);
					r = r.replace(/{viewMoreUrl}/g,site_url+'/complete-race/?raceId='+data.rows[i].cell[0]);
					row += r;
					
					jQuery.ajax({
						url: site_url+"/wp-admin/admin-ajax.php",
						type: "POST",
						data: {
							action: 'r2f_action_get_leaderboard',
							raceId: data.rows[i].cell[0]
						},
						dataType: "JSON",
						success: function (data) {
							console.log(data);
							jQuery("#result").text(data.message + " " + data.error);
							var li = '';
							for (i=0;i<data.rows.length;i++){
							   li += '<li>'+ data.rows[i].name + '</li>';
							}
							jQuery('#leaderboard_'+data.id).append(li);
						}
					});
					
				}
				jQuery("#raceResultsFinished").html(row);
			}
		});
		
	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}