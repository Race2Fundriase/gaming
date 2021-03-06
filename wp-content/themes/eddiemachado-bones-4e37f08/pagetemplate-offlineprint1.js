
jQuery(document).ready
(
	
	function(jQuery)
	{
		var raceId = qs("raceId");
		var md = false;
		var share = qs("share");
		
		
		
		
		
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
				jQuery("#result").text(data.message + " " + data.error);
				var dateParts = data.rows[0].startDate.split("-");
				var d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
				jQuery("#startDate").html(d.ddmmyyyy());
				jQuery("#startTime").html(data.rows[0].startTime);
				dateParts = data.rows[0].finishDate.split("-");
				d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
				jQuery("#finishDate").html(d.ddmmyyyy());
				jQuery("#finishTime").html(data.rows[0].finishTime);

				jQuery("#raceName").html(data.rows[0].raceName);
				jQuery("#entryPrice").html(data.rows[0].entryPrice);
				jQuery("#raceDescription").html(data.rows[0].raceName);
				jQuery("#mapName").html(data.rows[0].mapName);
				jQuery("#weather").html(data.rows[0].weather);
				jQuery("#terrain").html(data.rows[0].terrain);
				jQuery("#featured").prop("checked", (data.rows[0].featured == 1));
				if (data.rows[0].prizeDesc)
					jQuery("#prize").html("Prize: "+data.rows[0].prizeDesc);
				
				startGridX = data.rows[0].startGridX;
				startGridY = data.rows[0].startGridY;
				finishGridX = data.rows[0].finishGridX;
				finishGridY = data.rows[0].finishGridY;
				
				curDay = data.rows[0].curDay;
				curHour = data.rows[0].curHour;
				raceStatus = data.rows[0].raceStatus;
				var createdBy = data.rows[0].createdBy;
				
				jQuery("#sponserLogoUrl").attr("src", data.rows[0].sponserLogoUrl);
				jQuery("#sponserUrl").attr("href", data.rows[0].sponserUrl);
				if (data.rows[0].sponserLogoUrl != "")
					jQuery("#sponserDiv").removeClass("myhidden");
				
					
				
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
						var row = "";
						var rowHtml = jQuery("#templateDiv").html();
						for(i=0;i<data.rows.length;i++) {
							r = rowHtml;
							r = r.replace(/{image}/g, site_url+'/'+data.rows[i].tokenImageUrl);
							r = r.replace(/{tokenName}/g, data.rows[i].tokenName);
							r = r.replace(/{index}/g, i);
							
							//if ((i % 9) == 8) 
								//r +=  '<br/>' + jQuery("#printheader").html();
							
							row += r;
							
							
						}
						jQuery("#charactersResults").html(row);
						
						for (i=0;i<data.rows.length;i++){
					
							jQuery("#token_"+i).click(function() { 

								return false;
							} );
							
							if ((i % 3) == 0)
								jQuery("#wrapper_"+i).addClass("first");
							if ((i % 3) == 2)
								jQuery("#wrapper_"+i).addClass("last");		

							jQuery("#wrapper_"+i).qtip({
							   content: data.rows[i].tokenTip,
							   show: 'mouseover',
							   hide: 'mouseout',
							   position: {
								my: 'bottom center',
								at: 'top center'
							   }
							});		
	
							
							
						}
						
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_get_charity',
								id: createdBy
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);
								jQuery("#result").text(data.message + " " + data.error);
								jQuery("#charityProfileName").html(data.user.data.charityName);
								jQuery("#charityProfileWebsite").html(data.user.data.website);
								jQuery("#charityProfileDesc").html(data.user.data.description);
								
								window.print();
								
							}
						});
					}
				});
				
				
				
				
				
				
			}
		});
		
		

	}
);

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]); // padding
  };
  
Date.prototype.ddmmyyyy = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return (dd[1]?dd:"0"+dd[0]) + "/" + (mm[1]?mm:"0"+mm[0]) + "/" + yyyy; // padding
  };