
function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

window.onload = function () {


	var raceId = qs("raceId");
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
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_racetokens',
					raceId: raceId
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					var option = '';
					for (i=0;i<data.rows.length;i++){
					   option += '<option value="'+ data.rows[i].tokenId + '">' + data.rows[i].tokenName + '</option>';
					}
					jQuery('#tokenId').append(option);
				}
			});
			
		}
	});
	
	jQuery("#continue").click(function(e) { 
		// validate form
		if (jQuery("#playerName").val() == "") { alert("You must enter a player name"); return false; }
		location.href = site_url+"/enter-race-part-2/?raceId="+raceId+"&playerName="+jQuery("#playerName").val()
			+"&tokenId="+jQuery("#tokenId").val()+"&drivingStyleWeight="+jQuery("#drivingStyleWeight").val()
			+"&noOfPitstops="+jQuery("#noOfPitstops").val();
		return false;
	} );
};

