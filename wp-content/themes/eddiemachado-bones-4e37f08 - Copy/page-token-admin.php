<?php
/*
Template Name: Token Admin
*/
?>

<?php get_currentuserinfo(); if (!current_user_can('publish_posts')) die("Access denied");?>

<?php get_header(); ?>
<style>
.boxShadow {
	box-shadow: 5px 5px 5px #888888;
	
}

#tokenOptions {
	position: relative;
	width: 800px;
	margin-top: 30px;
	margin-left: auto;
	margin-right: auto;
}

#tokenDataGrid {
	position: relative;
	width: 800px;
	margin-top: 30px;
	margin-left: auto;
	margin-right: auto;
}


#result {
	width: 800px;
	margin-left:auto;
	margin-right:auto;
}

label { display: block; padding: 10px 10px 10px 10px; line-spacing: normal; line-height: normal;}

.myfields label, .myfields input {
	display: inline-block;
}

.myfields label {
	width: 200px;
}

h1 { margin: 0 }

body { font-family:Arial, Helvetica, sans-serif; }

.error { color: red };
</style>
<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content">

	<br/>
	<div id="tokenDataGrid" class="boxShadow">
		<table id="list2"></table>
		<div id="pager2"></div>
	</div>
	<div id="tokenOptions" class="boxShadow">
		<H2>Token Options</h2>
		<form id="dataForm">
		<fieldset class="myfields">
		<div><label for="id" id="scaleLabel">id:</label><input type="text" id="id" value="" readonly/></div>
		<div><label for="tokenName" id="scaleLabel">Token Name:</label><input type="text" id="tokenName" value="" required /></div>
		<div><label for="tokenDescription" id="scaleLabel">Token Description:</label><input type="text" id="tokenDescription" value="" required /></div>
		<div><label for="tokenImageUrl" id="scaleLabel">Token Image URL:</label><input type="text" id="tokenImageUrl" value="" required /></div>
		<div><label for="weather" id="scaleLabel">Weather:</label><input type="text" id="weather" value=""/></div>
		<div><label for="weatherForecast" id="scaleLabel">Weather Forecast:</label><input type="text" id="weatherForecast" value=""/></div>
		<div><label for="energyRequired" id="scaleLabel">Energy Required:</label><input type="text" id="energyRequired" value=""/></div>
		<div><label for="courseAgressiveness" id="scaleLabel">Course Agressiveness:</label><input type="text" id="courseAgressiveness" value=""/></div>
		<div><label for="terrain" id="scaleLabel">Terrain:</label><input type="text" id="terrain" value=""/></div>
		<div><label for="courseDistance" id="scaleLabel">Course Distance:</label><input type="text" id="courseDistance" value=""/></div>
		<div><label for="speed" id="scaleLabel">Speed:</label><input type="text" id="speed" value=""/></div>
		<input type="button" value="Apply" id="upsertToken"/>
		</fieldset>
		</form>
	</div>
	<div id="result" class="boxShadow"></div>
</div>
</section>
<?php get_footer(); ?>

<script>
jQuery(document).ready
(
	function(jQuery)
	{
		
			
		jQuery("#list2").jqGrid({
			url:'<?=site_url();?>/wp-admin/admin-ajax.php?action=r2f_action_get_tokens',
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
					url: "<?=site_url();?>/wp-admin/admin-ajax.php",
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
				});
			}
		});
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
		
		jQuery("#dataForm").validate();
		
		jQuery("#upsertToken").click(function() { 
			jQuery("#dataForm").validate();
			if (!jQuery("#dataForm").valid()) return false;
			jQuery.ajax({
				url: "<?=site_url();?>/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_token',
					id: jQuery("#id").val(),
					tokenName: jQuery("#tokenName").val(),
					tokenDescription: jQuery("#tokenDescription").val(),
					tokenImageUrl: jQuery("#tokenImageUrl").val(),
					weather: jQuery("#weather").val(),
					weatherForecast: jQuery("#weatherForecast").val(),
					energyRequired: jQuery("#energyRequired").val(),
					courseAgressiveness: jQuery("#courseAgressiveness").val(),
					terrain: jQuery("#terrain").val(),
					courseDistance: jQuery("#courseDistance").val(),
					speed: jQuery("#speed").val()
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
</script>