
jQuery(document).ready
(
	
	function(jQuery)
	{
		var charityId = qs("charityId");
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_charity',
				id: charityId
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				jQuery("#charityProfileName").html(data.user.data.charityName);
				jQuery("#charityProfileName2").html(data.user.data.charityName);
				jQuery("#charityProfileWebsite").html(data.user.data.website);
				jQuery("#charityProfileDesc").html(data.user.data.description);
				
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_races',
				createdBy: charityId,
				raceStatus: 0
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var li = "";
				for(i=0;i<data.rows.length;i++) {
					li += '<div class="headings-3-col"><p class="highlight"><a href="'+site_url+'/active-race/?raceId='+data.rows[i].cell[0]+'">'+ data.rows[i].cell[1] +'</a></p><p class="highlight">'+ data.rows[i].cell[6] +'</p><p class="highlight">'+data.rows[i].cell[8]+'</p></div>'
					
				}
				jQuery("#activeRaces").append(li);
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_races',
				createdBy: charityId,
				raceStatus: 1
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var li = "";
				for(i=0;i<data.rows.length;i++) {
					li += '<div class="headings-3-col"><p class="highlight"><a href="'+site_url+'/active-race/?raceId='+data.rows[i].cell[0]+'">'+ data.rows[i].cell[1] +'</a></p><p class="highlight">'+ data.rows[i].cell[6] +'</p><p class="highlight">'+data.rows[i].cell[8]+'</p></div>'
				}
				jQuery("#completeRaceResults").append(li);
			}
		});

	}
);


function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

