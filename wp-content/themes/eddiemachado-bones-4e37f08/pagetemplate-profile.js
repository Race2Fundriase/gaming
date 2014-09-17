
jQuery(document).ready
(
	
	function(jQuery)
	{
		var charityId = qs("charityId");
		
		var activeRaces;
		var completeRaces;
		
		if (!charityId) charityId = url_id;
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_charity',
				id: charityId
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				jQuery("#result").text(data.message + " " + data.error);
				jQuery("#charityProfileName").html(data.user.data.charityName);
				jQuery("#charityProfileName2").html(data.user.data.charityName);
				jQuery("#charityProfileWebsite").html(data.user.data.website);
				jQuery("#charityProfileDesc").html(data.user.data.description);
				jQuery("#linkTo").html('Link to this charity: <a href="'+site_url+'/charity/'+charityId+'">'+site_url+'/charity/'+charityId+'</a>');
				
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_races',
				createdBy: charityId,
				raceStatus: 0
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var li = "";
				for(i=0;i<data.rows.length;i++) {
					li += '<div class="headings-3-col" id="activeRace_'+i+'" data-selection="'+i+'"><p class="highlight"><a href="'+site_url+'/active-race/?raceId='+data.rows[i].cell[0]+'">'+ data.rows[i].cell[1] +'</a></p><p class="highlight">'+ data.rows[i].cell[6] +'</p><p class="highlight">'+data.rows[i].cell[8]+'</p></div>'
					
				}
				jQuery("#activeRaces").append(li);
				activeRaces = data.rows;
				
				for(i=0;i<data.rows.length;i++) {
					jQuery("#activeRace_"+i).addClass("mypointer");
					jQuery("#activeRace_"+i).click(function(e) {
					
						var j = jQuery(this).attr("data-selection");
						jQuery("#featureRaceName").html(activeRaces[j].cell[1]);
						jQuery("#featureRaceData").html(activeRaces[j].cell[2]);
						jQuery("#featureRaceDescription").html(activeRaces[j].cell[13]);
						
						var dateParts = activeRaces[j].cell[6].split("-");
						var d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
						jQuery("#featurestartDate").html(d.ddmmyyyy());
						jQuery("#featurestartTime").html(activeRaces[j].cell[7]);
						dateParts = activeRaces[j].cell[8].split("-");
						d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
						jQuery("#featurefinishDate").html(d.ddmmyyyy());
						jQuery("#featurefinishTime").html(activeRaces[j].cell[9]);
						
						if (activeRaces[j].canEnter) {
							jQuery("#featureenterRace").removeClass("myhidden");
							jQuery("#featureenterRace").attr("href", site_url+'/active-race/?raceId='+activeRaces[j].cell[0]);
						} else {
							jQuery("#featureenterRace").addClass("myhidden");
							jQuery("#featureenterRace").attr("href", "");
						}
						
						jQuery("#featureImage").attr("src", activeRaces[j].cell[10]);
					});
				}
				if (data.rows) {
					jQuery("#activeRace_0").click();
					jQuery("#profile-excerpt").removeClass("myhidden");
				}
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_races',
				createdBy: charityId,
				raceStatus: 1
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				var li = "";
				for(i=0;i<data.rows.length;i++) {
					li += '<div class="headings-3-col" id="completeRace_'+i+'" data-selection="'+i+'"><p class="highlight"><a href="'+site_url+'/active-race/?raceId='+data.rows[i].cell[0]+'">'+ data.rows[i].cell[1] +'</a></p><p class="highlight">'+ data.rows[i].cell[6] +'</p><p class="highlight">'+data.rows[i].cell[8]+'</p></div>'
				}
				jQuery("#completeRaces").append(li);
				completeRaces = data.rows;
				
				for(i=0;i<data.rows.length;i++) {
					jQuery("#completeRace_"+i).addClass("mypointer");
					jQuery("#completeRace_"+i).click(function(e) {
					
						var j = jQuery(this).attr("data-selection");
						jQuery("#featureRaceName").html(completeRaces[j].cell[1]);
						jQuery("#featureRaceData").html(completeRaces[j].cell[2]);
						jQuery("#featureRaceDescription").html(completeRaces[j].cell[13]);
						
						var dateParts = completeRaces[j].cell[6].split("-");
						var d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
						jQuery("#featurestartDate").html(d.ddmmyyyy());
						jQuery("#featurestartTime").html(completeRaces[j].cell[7]);
						dateParts = completeRaces[j].cell[8].split("-");
						d = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0,2));
						jQuery("#featurefinishDate").html(d.ddmmyyyy());
						jQuery("#featurefinishTime").html(completeRaces[j].cell[9]);
						
						if (completeRaces[j].canEnter) {
							jQuery("#featureenterRace").removeClass("myhidden");
							jQuery("#featureenterRace").attr("href", site_url+'/active-race/?raceId='+completeRaces[j].cell[0]);
						} else {
							jQuery("#featureenterRace").addClass("myhidden");
							jQuery("#featureenterRace").attr("href", "");
						}
					});
				}
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