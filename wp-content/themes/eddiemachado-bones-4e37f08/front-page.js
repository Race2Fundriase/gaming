
jQuery(document).ready
(
	
	function(jQuery)
	{
		
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_featured_races'
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				var row = "";
				var rowHtml = jQuery("#templateDiv").html();
				for(i=0;i<data.rows.length;i++) {
					r = rowHtml;
					r = r.replace(/{raceName}/g, data.rows[i].raceName);
					r = r.replace(/{mapImageUrl}/g, site_url+"/"+data.rows[i].mapImageUrl);
					r = r.replace(/{charityName}/g, data.rows[i].charityName);
					r = r.replace(/{enterRaceUrl}/g, site_url+"/active-race/?raceId="+data.rows[i].id);
					row += r;
				}
				jQuery("#featuredGames").html(row);
			}
		});

	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

