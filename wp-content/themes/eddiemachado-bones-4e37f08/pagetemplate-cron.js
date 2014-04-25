
jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		
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
				
				
				
			}
		});
		

	}
);


function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

