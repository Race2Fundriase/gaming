
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
				jQuery("#charityProfileWebsite").html(data.user.data.website);
				jQuery("#charityProfileDesc").html(data.user.data.description);
				
			}
		});
		

	}
);


function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

