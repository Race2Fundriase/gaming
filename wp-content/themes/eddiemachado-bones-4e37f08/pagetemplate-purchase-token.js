jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		
		jQuery("#return").val(site_url+"/enter-race-part-1/?raceId="+raceId);
		jQuery("#cancel_return").val(site_url+"/purchase-token/?raceId="+raceId);
		jQuery("#notify_url").val(site_url+"/ipn");
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
				jQuery("#amount").val(data.rows[0].entryPrice);
				jQuery("#currency_code").val(data.rows[0].entryCurrency);
				if (data.rows[0].entryPrice == 0)
					location.href = site_url+"/enter-race/?raceId="+raceId;
				
				if (data.rows[0].paymentMethodEmail == "")
					jQuery("#paypalForm").css("display", "none");
				if (data.rows[0].justGivingCharityId == "")
					jQuery("#justGivingForm").css("display", "none");
				else
					jQuery("#justGivingLink").attr("href","http://www.justgiving.com/donation/direct/charity/"
						+data.rows[0].justGivingCharityId+"?amount="+data.rows[0].entryPrice
						+"&frequency=single&exitUrl="+site_url+"/enter-race/?raceId="+raceId);
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_purchase_check',
				raceId: raceId,
				playerId: current_user_id
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				if (data.id != "" || is_admin )
					location.href = site_url+"/enter-race/?raceId="+raceId+"&transactionId="+data.id;
				
				
			}
		});
		
	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

