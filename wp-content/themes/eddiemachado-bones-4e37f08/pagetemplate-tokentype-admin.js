jQuery(document).ready
(
	function(jQuery)
	{
		
			
		jQuery("#list2").jqGrid({
			url:site_url+'/wp-admin/admin-ajax.php?action=r2f_action_get_tokentypes',
			datatype: "json",
			colNames:['id','Type Description'],
			colModel:[
				{name:'id',index:'id', width:55},
				{name:'typeDesc',index:'typeDesc', width:300}
				
			],
			rowNum:10,
			rowList:[10,20,30,150],
			pager: '#pager2',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			caption:"Token Types",
			onSelectRow: function(id){ 
				
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_tokentype',
						id: id
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						if (data.error == "") {
							jQuery("#id").val(data.result.id);
							jQuery("#typeDesc").val(data.result.typeDesc);
						}
						
					}
				});
			}
		});
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
		
		jQuery("#dataForm").validate();
		
		jQuery("#upsertTokenType").click(function() { 
			jQuery("#dataForm").validate();
			if (!jQuery("#dataForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_tokentype',
					id: jQuery("#id").val(),
					typeDesc: jQuery("#typeDesc").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					jQuery("#id").val(data.id);
				}
			});
			return false;
		} );
		

	}
);
