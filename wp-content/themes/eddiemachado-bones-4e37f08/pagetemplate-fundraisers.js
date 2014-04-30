
jQuery(document).ready
(
	function(jQuery)
	{
	
		var q = qs('charity-s');
		var curPage = 1;
		var p, n;
		
		var rowHtml = jQuery("#templateDiv").html();
		function getCharities() {
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_fundraisers',
					page: curPage,
					rows: 5,
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
						r = r.replace(/{index}/g, i);
						r = r.replace(/{profileUrl}/g, site_url+"/fundraiser-profile/?charityId="+data.rows[i].data.ID);
						row += r;
						

					}
					jQuery("#charityResults").html(row);
					
					for(i=1;i<data.rows.length;i++) {
						jQuery("#fund_"+i).addClass("top-bg-alt");
					}
					
					if (data.total_pages > 1) {
						/*jQuery("#next").addClass("myhidden");
						jQuery("#prev").addClass("myhidden");
						if (curPage != data.total_pages) 
							jQuery("#next").removeClass("myhidden");
						if (curPage > 1)
							jQuery("#prev").removeClass("myhidden");*/
						if (curPage != data.total_pages) 
							n = true;
						else
							n = false;
						if (curPage > 1)
							p = true;
						else
							p = false;
					}
					
					jQuery("#pager").html("Page "+curPage+" of " +data.total_pages);
				}
			});
		}
		
		jQuery("#next").click(function (e) {
			if (!n) return;
			curPage++;
			getCharities();
		});
		jQuery("#prev").click(function (e) {
			if (!p) return;
			curPage--;
			getCharities();
		});
		
		getCharities();
	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}