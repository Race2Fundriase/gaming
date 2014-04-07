jQuery(document).ready
(
	function(jQuery)
	{
		
			
		jQuery("#list2").jqGrid({
			url:site_url+'/wp-admin/admin-ajax.php?action=r2f_action_get_races',
			datatype: "json",
			colNames:['id','Race Name', 'Map Name', 'Game Status', 'Create Characters'],
			colModel:[
				{name:'id',index:'id', width:55},
				{name:'raceName',index:'raceName', width:150},
				{name:'mapName',index:'mapName', width:300},
				{name:'status',index:'status', width:150},
				{name:'create',index:'create', width:150}
				
			],
			rowNum:10,
			rowList:[10,20,30],
			pager: '#pager2',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			caption:"",
			onSelectRow: function(id){ 
				
				/*jQuery.ajax({
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
							jQuery("#weather").val(data.result.weather);
							jQuery("#weatherForecast").val(data.result.weatherForecast);
							jQuery("#energyRequired").val(data.result.energyRequired);
							jQuery("#courseAgressiveness").val(data.result.courseAgressiveness);
							jQuery("#terrain").val(data.result.terrain);
							jQuery("#courseDistance").val(data.result.courseDistance);
							jQuery("#speed").val(data.result.speed);
						}
						
					}
				});*/
			}
		});
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
		
		
	}
);
