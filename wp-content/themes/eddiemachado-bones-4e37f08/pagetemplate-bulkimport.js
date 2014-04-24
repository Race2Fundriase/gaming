jQuery(document).ready
(

	function(jQuery)
	{

		var raceId = qs("raceId");
		
		jQuery("#continue").click(function(e) { 
				
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
				if (data.error == "")
					var n = noty({text: data.message});
				else
					var n = noty({text: data.message + " " + data.error});
			}
		});
			
		return false;
	} );
		
	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

