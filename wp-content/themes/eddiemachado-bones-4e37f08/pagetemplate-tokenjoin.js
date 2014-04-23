jQuery(document).ready
(
	function(jQuery)
	{
		
			
		jQuery("#login").click(function() { 

			jQuery("#loginForm").validate();
			if (!jQuery("#loginForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_token_login',
					username: jQuery("#profileName2").val(),
					password: jQuery("#password").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					if (data.error == "")
						location.href = "/";
				}
			});
			return false;
		} );
		
		jQuery("#register").click(function() { 

			jQuery("#registerForm").validate();
			if (!jQuery("#registerForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_token_register',
					name: jQuery("#name").val(),
					profileName: jQuery("#profileName").val(),
					email: jQuery("#email").val(),
					building_no_or_name: jQuery("#building").val(),
					road: jQuery("#road").val(),
					city: jQuery("#city").val(),
					county: jQuery("#county").val(),
					postcode: jQuery("#postcode").val(),
					country: jQuery("#country").val(),
					choosePassword: jQuery("#choosePassword").val(),
					confirmPassword: jQuery("#confirmPassword").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					var n = noty({text: data.message + " " + data.error});
					if (data.error == "")
						setTimeout(function(){location.href = "/"},5000);
				}
			});
			return false;
		} );
	}
);
