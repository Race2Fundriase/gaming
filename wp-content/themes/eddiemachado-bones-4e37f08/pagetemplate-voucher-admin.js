jQuery(document).ready
(
	function(jQuery)
	{
		jQuery("#expires").datetimepicker({ dateFormat: "yy-mm-dd" });
			
		jQuery("#list2").jqGrid({
			url:site_url+'/wp-admin/admin-ajax.php?action=r2f_action_get_vouchers',
			datatype: "json",
			colNames:['id','Voucher Code'],
			colModel:[
				{name:'id',index:'id', width:55},
				{name:'code',index:'code', width:150}
				
			],
			rowNum:10,
			rowList:[10,20,30,150],
			pager: '#pager2',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			caption:"Vouchers",
			onSelectRow: function(id){ 
				
				jQuery.ajax({
					url: site_url+"/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_voucher',
						id: id
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						if (data.error == "") {
							jQuery("#id").val(data.result.id);
							jQuery("#voucherCode").val(data.result.voucherCode);
							jQuery("#maxUses").val(data.result.maxUses);
							jQuery("#uses").val(data.result.uses);
							jQuery("#expires").val(data.result.expires);
							jQuery("#discount_amount").val(data.result.discount_amount);
							jQuery("#discount_percent").val(data.result.discount_percent);
						}
						
					}
				});
			}
		});
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
		
		jQuery("#dataForm").validate();
		
		jQuery("#upsertVoucher").click(function() { 
			jQuery("#dataForm").validate();
			if (!jQuery("#dataForm").valid()) return false;
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_voucher',
					id: jQuery("#id").val(),
					voucherCode: jQuery("#voucherCode").val(),
					maxUses: jQuery("#maxUses").val(),
					uses: jQuery("#uses").val(),
					expires: jQuery("#expires").val(),
					discount_amount: jQuery("#discount_amount").val(),
					discount_percent: jQuery("#discount_percent").val()
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
