jQuery(document).ready
(
	function(jQuery)
	{
		
			
		
		jQuery("#register_charity").click(function() { 

			jQuery("#registerForm").validate();
			if (!jQuery("#registerForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_join',
					join_type: 'charity',
					official_charity_name: jQuery("#official_charity_name").val(),
					profile_name: jQuery("#profile_name").val(),
					main_contact_name: jQuery("#main_contact_name").val(),
					telephone_number: jQuery("#telephone_number").val(),
					email: jQuery("#email").val(),
					building_no_or_name: jQuery("#building_no_or_name").val(),
					road_name: jQuery("#road_name").val(),
					town_city: jQuery("#town_city").val(),
					county: jQuery("#county").val(),
					postcode: jQuery("#postcode").val(),
					country: jQuery("#country").val(),
					gift_aid: jQuery("#gift_aid").val(),
					confirmPassword: jQuery("#website_address").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					var n = noty({text: data.message + " " + data.error});
					if (data.error == "")
						location.href = "/";
				}
			});
			return false;
		} );
		
		jQuery("#register_fund").click(function() { 

			jQuery("#registerForm_fund").validate();
			if (!jQuery("#registerForm_fund").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_join',
					join_type: 'fundraiser',
					official_charity_name: '',
					profile_name: jQuery("#profile_name_fund").val(),
					main_contact_name: jQuery("#main_contact_name_fund").val(),
					telephone_number: jQuery("#telephone_number_fund").val(),
					email: jQuery("#email_fund").val(),
					building_no_or_name: jQuery("#building_no_or_name_fund").val(),
					road_name: jQuery("#road_name_fund").val(),
					town_city: jQuery("#town_city_fund").val(),
					county: jQuery("#county_fund").val(),
					postcode: jQuery("#postcode_fund").val(),
					country: jQuery("#country_fund").val(),
					gift_aid: jQuery("#gift_aid_fund").val(),
					confirmPassword: jQuery("#website_address_fund").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					var n = noty({text: data.message + " " + data.error});
					if (data.error == "")
						location.href = "/";
				}
			});
			return false;
		} );
	}
);
