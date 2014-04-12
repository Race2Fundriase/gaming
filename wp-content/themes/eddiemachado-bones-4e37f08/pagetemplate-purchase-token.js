jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		
		jQuery("#return").val(site_url+"/enter-race/?raceId="+raceId);
		jQuery("#cancel_return").val(site_url+"/purchase-token/?raceId="+raceId);
		jQuery("#notify_url").val(site_url+"/wp-admin/admin-ajax.php?action=r2f_action_notify");
		jQuery("#item_number").val("TOKEN:"+raceId+"-"+current_user_id);
		
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
				jQuery("#business").val(data.rows[0].paymentMethodEmail);
				if (data.rows[0].entryPrice == 0)
					location.href = site_url+"/enter-race/?raceId="+raceId;
			}
		});
		
	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

