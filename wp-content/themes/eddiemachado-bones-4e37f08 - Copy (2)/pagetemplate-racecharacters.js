jQuery(document).ready
(
	function(jQuery)
	{

		var raceId = qs("raceId");
	
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "GET",
			data: {
				action: 'r2f_action_get_tokens',
				page: 0,
				rows: 100
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var option = '<option value=""></option>';
				for (i=0;i<data.records;i++){
				   option += '<option value="'+ data.rows[i].cell[0] + '">' + data.rows[i].cell[1] + '</option>';
				}
				jQuery('#tokenId').append(option);
			}
		});
		
		jQuery("#tokenId").change(function() { 
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_racetoken',
					raceId: raceId,
					tokenId: jQuery("#tokenId").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					jQuery("#speed").val(data.rows[0].speed);
					jQuery("#noOfPitstops").val(data.rows[0].noOfPitstops);
				}
			});
			return false;
		} );
		
		jQuery("#speed").change(function() { 
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_racetokens',
					raceId: raceId,
					tokenId: jQuery("#tokenId").val(),
					speed: jQuery("#speed").val(),
					noOfPitstops: jQuery("#noOfPitstops").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					
				}
			});
			return false;
		} );
		
		jQuery("#noOfPitstops").change(function() { 
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_racetokens',
					raceId: raceId,
					tokenId: jQuery("#tokenId").val(),
					speed: jQuery("#speed").val(),
					noOfPitstops: jQuery("#noOfPitstops").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					
				}
			});
			return false;
		} );
		
		jQuery("#continue").click(function() { 
			home();
			return false;
		} );
		
	}
);

function home() {
	location.href = site_url+'/admin-dashboard';
}

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}


