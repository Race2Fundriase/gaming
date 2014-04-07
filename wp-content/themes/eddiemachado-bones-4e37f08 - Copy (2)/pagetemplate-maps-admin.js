jQuery(document).ready
(
	function(jQuery)
	{
		var rowHtml = '<div class="inner-container wrap clearfix"><div class="active-race"><div class="fourcol first" style="overflow: hidden"><img src="{mapUrl}"/></div><div class="fivecol"><div><h2 class="highlight">{id} {mapName}</h2></div></div><a class="btn small right" href="'+site_url+'/map-admin?id={id}">View More</a></div></div>'
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_maps',
				page: 0,
				rows: 100
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				var row = "";
				for(i=0;i<data.records;i++) {
					r = rowHtml;
					r = r.replace(/{id}/g, data.rows[i].cell[0]);
					r = r.replace(/{mapUrl}/g, site_url+data.rows[i].cell[1]);
					r = r.replace(/{mapName}/g, data.rows[i].cell[2]);
					row += r;
				}
				r = rowHtml;
				r = r.replace(/{id}/g, "");
				r = r.replace(/{mapUrl}/g, "<?php echo get_template_directory_uri(); ?>/plus.png");
				r = r.replace(/{mapName}/g, "Create New Map");
				row += r;
				jQuery("#mapResults").html(row);
			}
		});

	}
);

