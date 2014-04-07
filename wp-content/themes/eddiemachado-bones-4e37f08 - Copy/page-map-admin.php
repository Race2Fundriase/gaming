<?php
/*
Template Name: Map Admin
*/
?>

<?php get_currentuserinfo(); if (!current_user_can('publish_posts')) die("Access denied");?>

<?php get_header(); ?>
<script>

var paper;
var scale = 1.0;
var mapWidth = 3506;
var mapHeight = 4440;
var cellWidth = 75;
var cellHeight = 75;
var gridWidth = 47;
var gridHeight = 60;
var xoff = 0;
var yoff = 0;

var selectedCell;

var map = "/race2fundraise.com/map.jpg";
var mapImage;

function drawGrid() {

	if (paper) paper.clear();

	paper = Raphael("paperParent", mapWidth*scale, mapHeight*scale);
	paper.image(map, 0, 0, mapWidth*scale, mapHeight*scale);

	var x, y;
	var w = cellWidth * scale;
	var h = cellHeight * scale;

	for (x=0;x<gridWidth;x++) {
		var curx = x * w;
		for (y=0;y<gridHeight;y++) {
			var cury = y * h;
			var g = paper.path("M"+curx+" "+cury+"L"+(curx+w)+" "+cury+"L"+(curx+w)+" "+(cury+h));
			
		}
	}
}

function selectGrid(x, y) {

	
	// bring back to origin of paper
	//x = (x - xoff);
	//y = (y - yoff);
	
	// add the scroll of the div
	

	curx = x;
	curx = curx / (cellWidth * scale);
	
	cury = y;
	cury = cury / (cellHeight * scale);
	
	curx = Math.floor(curx);
	cury = Math.floor(cury);
	
	if (selectedCell) selectedCell.remove();
	

	selectedCell = paper.rect(curx * cellWidth * scale, cury * cellWidth * scale, cellWidth * scale, cellWidth * scale, 5 * scale).attr("fill", "#00f");

}

function handleEvent(e){
 var elem, evt = e ? e:window.event;
 var clickX=0, clickY=0;

 if (evt.srcElement)  elem = evt.srcElement;
 else if (evt.target) elem = evt.target;
 if (elem && elem.tagName.toLowerCase()=='a') return true;

 if ((evt.clientX || evt.clientY) &&
     document.body &&
     document.body.scrollLeft!=null) {
  clickX = evt.clientX + document.body.scrollLeft;
  clickY = evt.clientY + document.body.scrollTop;
 }
 if ((evt.clientX || evt.clientY) &&
     document.compatMode=='CSS1Compat' && 
     document.documentElement && 
     document.documentElement.scrollLeft!=null) {
  clickX = evt.clientX + document.documentElement.scrollLeft;
  clickY = evt.clientY + document.documentElement.scrollTop;
 }
 if (evt.pageX || evt.pageY) {
  clickX = evt.pageX;
  clickY = evt.pageY;
 }

 //selectGrid(clickX, clickY);
 
 return false;
}


window.onload = function () {

	scale = 0.2;
	xoff = 400;
	yoff = 100;
	
	drawGrid();
	
	jQuery("#paperParent").click(function(e) { 
	
		selectGrid(e.pageX - jQuery("#paperParent").offset().left + jQuery("#paperParent").scrollLeft(), 
			e.pageY - jQuery("#paperParent").offset().top + jQuery("#paperParent").scrollTop()); 
		
	} );
	
};
</script>

<style>

.boxShadow {
	box-shadow: 5px 5px 5px #888888;
	
}

#viewOptions {
	position: relative;
	width: 350px;
}

#mapOptions {
	position: relative;
	width: 350px;
	margin-top: 30px;
}

#cellOptions {
	position: relative;
	width: 350px;
	margin-top: 30px;
}

#cellTokenOptions {
	position: relative;
	width: 350px;
	margin-top: 30px;
}

label { display: block; }

h1 { margin: 0 }

body { font-family:Arial, Helvetica, sans-serif; }

#paperParent {
	position: absolute;
	left: 400px;
	top: 480px;
	width: 800px;
	height: 800px;
	overflow:scroll;
}

#mapDataGrid {
	position: relative;
	width: 800px;
	margin-top: 30px;
	margin-left: auto;
	margin-right: auto;
}


</style>
<link rel="stylesheet" type="text/css" media="screen" href="<?=get_template_directory_uri()?>/library/jquery.jqGrid-4.6.0/css/ui.jqgrid.css" />
<section>
<div id="content">
	<br/>
	<br/>
	<div id="mapDataGrid" class="boxShadow">
		<table id="list2"></table>
		<div id="pager2"></div>
	</div>
	<h1>Map Setup</h1>
	<p>Setup a new map and it's attributes from this page. You can assign each grid as 'In Play' or not, and assign Token attributes to each grid which will affect movement of a token through that grid square.</p>
	<div id="viewOptions" class="boxShadow">
		<h2>View Options</h2>
		<label for="scale" id="scaleLabel">Scale:<input type="text" id="scale" value="0.2"/></label>
		<input type="button" value="Apply" onclick="scale = jQuery('#scale').val(); drawGrid();"/>
	</div>
	<div id="mapOptions" class="boxShadow">
		<h2>Map Options</h2>
		<label for="mapId" id="mapIdLabel">Map Id:<input type="text" id="mapId" value=""/></label>
		<label for="mapImageUrl" id="mapImageUrlLabel">Map Image URL:<input type="text" id="mapImageUrl" value=""/></label>
		<label for="mapWidth" id="mapWidthLabel">Map Width:<input type="text" id="mapWidth" value=""/></label>
		<label for="mapHeight" id="mapHeightLabel">Map Height:<input type="text" id="mapHeight" value=""/></label>
		<label for="gridWidth" id="gridWidthLabel">Map Grid Width:<input type="text" id="gridWidth" value=""/></label>
		<label for="gridHeight" id="gridHeightLabel">Map Grid Height:<input type="text" id="gridHeight" value=""/></label>
		<label for="cellWidth" id="cellWidthLabel">Map Cell Width:<input type="text" id="cellWidth" value=""/></label>
		<label for="cellHeight" id="cellHeightLabel">Map Cell Height:<input type="text" id="cellHeight" value=""/></label>
		<input type="button" value="Apply" onclick=""/>
	</div>
	<div id="cellOptions" class="boxShadow">
		<h2>Cell Options</h2>
		<label for="gridX" id="gridXLabel">Grid X:<input type="text" id="gridX" value="" readonly/></label>
		<label for="gridY" id="gridYLabel">Grid Y:<input type="text" id="gridY" value="" readonly/></label>
		<label for="inPlay" id="inPlayLabel">In Play (1=Yes, 0=No)?:<input type="text" id="inPlay" value=""/></label>
		<input type="button" value="Apply" onclick=""/>
	</div>
	<div id="cellTokenOptions" class="boxShadow">
		<h2>Cell Token Offsets</h2>
		<p>An offset can be provided for each Token. This will increase the number of steps taken to get through this grid by a token (normally 1). Set to 0 to have no effect.</p>
		<table>
		<tr><th>Token</th><th>Offset</th></tr>
		<tr><td>Car</td><td><input type="text" id="cellToken0" value=""/></td></tr>
		<tr><td>Plane</td><td><input type="text" id="cellToken1" value=""/></td></tr>
		<tr><td>Motorbike</td><td><input type="text" id="cellToken2" value=""/></td></tr>
		</table>
			<input type="button" value="Apply" onclick=""/>
	</div>
	<div id="paperParent" class="boxShadow">
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
			url:'/race2fundraise.com/wp-admin/admin-ajax.php?action=r2f_action_get_maps',
			datatype: "json",
			colNames:['id','Map Image URL'],
			colModel:[
				{name:'id',index:'id', width:55},
				{name:'mapImageUrl',index:'mapImageUrl', width:150}
				
			],
			rowNum:10,
			rowList:[10,20,30],
			pager: '#pager2',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			caption:"Maps",
			onSelectRow: function(id){ 
				
				jQuery.ajax({
					url: "/race2fundraise.com/wp-admin/admin-ajax.php",
					type: "POST",
					data: {
						action: 'r2f_action_get_map',
						id: id
					},
					dataType: "JSON",
					success: function (data) {
						console.log(data);
						jQuery("#result").text(data.message + " " + data.error);
						if (data.error == "") {
							jQuery("#id").val(data.result.id);
							//jQuery("#tokenName").val(data.result.tokenName);
							
						}
						
					}
				});
			}
		});
		jQuery("#list2").jqGrid('navGrid','#pager2',{edit:false,add:false,del:false});
	}
);
</script>