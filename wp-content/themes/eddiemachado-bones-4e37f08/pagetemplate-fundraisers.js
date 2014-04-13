
jQuery(document).ready
(
	function(jQuery)
	{
	
		var q = qs('charity-s');
	
		var rowHtml = jQuery("#templateDiv").html();
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_fundraisers',
				page: 0,
				rows: 100,
				q: q
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				var row = "";
				for(i=0;i<data.rows.length;i++) {
					//<div class="result-3-col"><p class="highlight">XYZ</p><p class="highlight">08/08/13</p><p class="highlight">08/08/13</p></div>
					r = rowHtml;
					r = r.replace(/{charityName}/g, data.rows[i].data.charityName);
					row += r;
					

				}
				jQuery("#charityResults").html(row);
			}
		});
	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}