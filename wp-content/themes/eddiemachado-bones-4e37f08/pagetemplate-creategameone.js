jQuery(document).ready
(

	function(jQuery)
	{

		var raceId = qs("raceId");
		var products_race;
		var products_sub;
	
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
			location.href = site_url+"/create-online-race-2/?productType=race&qty="+jQuery("#tokenamount_race").val();
			return false;
		} );
		
		jQuery("#continue_sub").click(function() { 
			jQuery("#item_name").val("Unlimited games with upto "+jQuery("#tokenamount_sub").val()+" players");
			return_url = site_url+"/create-online-race-2/?productType=sub&qty="+jQuery("#tokenamount_sub").val();
			jQuery("#return").val(return_url);
			jQuery("#amount").val(jQuery("#tokenprice_sub").val());
			jQuery("#paypal_form").submit();
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

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

