var raceId;

jQuery(document).ready
(

	function(jQuery)
	{

		raceId = qs("raceId");
		var products_race;
		var products_sub;
		var subId = qs("subId");
		var qty = qs("qty");
		
		if (qty && raceId && qty != "") {
		
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_add_race_maxNoOfPlayers',
					id:raceId,
					qty: qty
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					location.href = site_url + "/edit-online-race/?raceId="+raceId;
				}
			});
			
		
		}
				
		if (offline == 1)
			jQuery("#gameType").html("Offline");
		else
			jQuery("#gameType").html("Online");
			
		if (subId != "") {
		
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_sub_check',
					subId: subId
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					if (data.error == "") {
						jQuery("#tokenamount_race").val(data.qty);
						jQuery("#tokenprice_race").val("0");
						
					}
				}
			});
			
		}
	
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_products',
				productType: 'race'
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				products_race = data.rows;
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_products',
				productType: 'sub'
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				products_sub = data.rows;
			}
		});
	
		jQuery("#race_1,#race_2,#race_3").click(function() { 
			jQuery("#tokenamount_race").val(jQuery(this).attr("data-selection"));
			jQuery("#tokenprice_race").val(jQuery(this).attr("data-price"));
			return false;
		} );
		
		jQuery("#sub_1,#sub_2,#sub_3").click(function() { 
			jQuery("#tokenamount_sub").val(jQuery(this).attr("data-selection"));
			jQuery("#tokenprice_sub").val(jQuery(this).attr("data-price"));
			return false;
		} );
		
		jQuery("#continue_race").click(function() { 
		
			// Check Voucher
			if (jQuery("#voucherCode").val() != "") {
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_use_voucher',
						voucherCode: jQuery("#voucherCode").val()
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						// check voucher code
						if (data.valid == 1) {
							
							if (data.result.discount_amount != 0) {
								jQuery("#tokenprice_race").val(jQuery("#tokenprice_race").val() - data.result.discount_amount);
								
							}
							else
								jQuery("#tokenprice_race").val(jQuery("#tokenprice_race").val() * (data.result.discount_percent / 100));
								
							alert("Voucher is valid - applying discount.");
							continue_race();
						} else 
							alert("Invalid Voucher Code.");
					}
				});
			} else
				continue_race();
			
			return false;
		} );
		
		jQuery("#continue_sub").click(function() { 
		
			jQuery("#item_name_sub").val("Unlimited games with upto "+jQuery("#tokenamount_sub").val()+" players");
			return_url = site_url+"/admin-dashboard";
			jQuery("#return_sub").val(return_url);
			jQuery("#item_number_sub").val("SUB:"+current_user_id+"-"+jQuery("#tokenamount_sub").val());
			jQuery("#cancel_return_sub").val(site_url+"/create-online-race-1");
			jQuery("#notify_url_sub").val(site_url+"/ipn");
			
			if (!is_admin)
				jQuery("#a3").val(jQuery("#tokenprice_sub").val());
			else
				jQuery("#a3").val("0.10");
				
			jQuery("#t3").val("Y");
			jQuery("#p3").val("1");
			jQuery("#paypal_form_sub").submit();
			return false;
		} );
		
		jQuery("#startDate,#finishDate").change(function(e) {
			// Build weather grid (and populate if it's already got data)
			
		});
		
		jQuery("#tokenamount_race").change(function(e) {
			var q = parseInt(jQuery(this).val());
			
			for(i=0;i<products_race.length;i++) {
				
				if (parseInt(products_race[i].qty)>=q) {
					jQuery("#tokenprice_race").val(products_race[i].price);
					return;
				}
			}
			
			jQuery("#tokenprice_race").val("Please contact us.");
		});
	}
);

function continue_race() {
	jQuery("#item_name").val(jQuery("#tokenamount_race").val()+" tokens");
	return_url = site_url+"/add-to-game/?raceId="+raceId+"&qty="+jQuery("#tokenamount_race").val();
	
	if (jQuery("#tokenprice_race").val() == 0) {
		location.href = return_url;
		return;
	}
	
	jQuery("#item_number").val("ADDRACE:"+jQuery("#tokenamount_race").val()+"-"+raceId);
	jQuery("#cancel_return").val(site_url+"/add-to-game/?raceId="+raceId);
	jQuery("#notify_url").val(site_url+"/ipn");
	jQuery("#return").val(return_url);
	jQuery("#amount").val(jQuery("#tokenprice_race").val());
	jQuery("#paypal_form").submit();
	
}

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

