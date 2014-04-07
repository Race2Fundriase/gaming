jQuery(document).ready
(
	function(jQuery)
	{
		
			
		jQuery("#list2").jqGrid({
			url:site_url+'/wp-admin/admin-ajax.php?action=r2f_action_get_tokens',
			datatype: "json",
			colNames:['id','Token Name', 'Token Description'],
			colModel:[
				{name:'id',index:'id', width:55},
				{name:'tokenName',index:'tokenName', width:150},
				{name:'tokenDesccription',index:'tokenDesccription', width:300}
				
			],
			rowNum:10,
			rowList:[10,20,30],
			pager: '#pager2',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			caption:"Tokens",
			onSelectRow: function(id){ 
				
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_token',
						id: id
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						if (data.error == "") {
							jQuery("#id").val(data.result.id);
							jQuery("#tokenName").val(data.result.tokenName);
							jQuery("#tokenDescription").val(data.result.tokenDescription);
							jQuery("#tokenImageUrl").val(data.result.tokenImageUrl);
							jQuery("#speed").val(data.result.speed);
							jQuery("#optimumNoOfPitstops").val(data.result.optimumNoOfPitstops);
						}
						
					}
				});
			}
		});
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
		
		jQuery("#dataForm").validate();
		
		jQuery("#upsertToken").click(function() { 
			jQuery("#dataForm").validate();
			if (!jQuery("#dataForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_token',
					id: jQuery("#id").val(),
					tokenName: jQuery("#tokenName").val(),
					tokenDescription: jQuery("#tokenDescription").val(),
					tokenImageUrl: jQuery("#tokenImageUrl").val(),
					speed: jQuery("#speed").val(),
					optimumNoOfPitstops: jQuery("#optimumNoOfPitstops").val()
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
