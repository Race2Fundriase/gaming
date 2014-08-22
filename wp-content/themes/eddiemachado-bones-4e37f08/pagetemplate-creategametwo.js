
var tokentokencategories;

jQuery(document).ready
(
	function(jQuery)
	{

		var raceId = qs("raceId");
				
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
				var option = '';
				for (i=0;i<data.records;i++){
				   option += '<option value="'+ data.rows[i].cell[0] + '">' + data.rows[i].cell[2] + '</option>';
				}
				jQuery('#mapId').append(option);
				if (raceId) {
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
							jQuery("#maxNoOfPlayers").val(data.rows[0].maxNoOfPlayers);
							jQuery("#raceName").val(data.rows[0].raceName);
							jQuery("#raceDescription").val(data.rows[0].raceDescription);
							jQuery("#mapId").val(data.rows[0].mapId);
							jQuery("#startDate").val(data.rows[0].startDate);
							jQuery("#startTime").val(data.rows[0].startTime);
							jQuery("#startDateTime").val(data.rows[0].startDate + " " + data.rows[0].startTime);
							jQuery("#finishDate").val(data.rows[0].finishDate);
							jQuery("#finishTime").val(data.rows[0].finishTime);
							jQuery("#finishDateTime").val(data.rows[0].finishDate + " " + data.rows[0].finishTime);
							jQuery("#entryPrice").val(data.rows[0].entryPrice);
							jQuery("#finishGridX").val(data.rows[0].finishGridX);
							jQuery("#finishGridY").val(data.rows[0].finishGridY);
							jQuery("#startGridX").val(data.rows[0].startGridX);
							jQuery("#startGridY").val(data.rows[0].startGridY);
							jQuery("#curDay").val(data.rows[0].curDay);
							jQuery("#paymentMethodEmail").val(data.rows[0].paymentMethodEmail);
							jQuery("#justGivingCharityId").val(data.rows[0].justGivingCharityId);
							jQuery("#private").val(data.rows[0].private);
							jQuery("#prizeDesc").val(data.rows[0].prizeDesc);
							jQuery("#entryCurrency").val(data.rows[0].entryCurrency);
							
							
						}
					});
				} else {
					jQuery("#maxNoOfPlayers").val(qs("qty"));
				}
			}
		});
	
		
	
		getTokens(raceId);
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: 'r2f_action_get_tokencategories',
				page: 1,
				rows: 1000
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				if (data.error == "") {
					var option = '';
					option += '<option value="0">All</option>';
					for (i=0;i<data.records;i++){
						option += '<option value="'+ data.rows[i].cell[0] + '">' + data.rows[i].cell[1] + '</option>';
					}
					
					jQuery('#tokenCategories').append(option);
					jQuery('#tokenCategories').change(function() {
						var tokenCategoryId = jQuery(this).val();
						// hide all
						jQuery(".token").addClass("myhidden");
						if (tokenCategoryId != 0) {
							for (i=0;i< tokentokencategories.length;i++) {
								var r = tokentokencategories[i].cell;
								if (r[2] == tokenCategoryId)
									jQuery('.token[data-selection="'+r[1]+'"]').removeClass("myhidden");
							}
						} else 
							jQuery(".token").removeClass("myhidden");
					});
				}
				
				
			}
		});
		
		jQuery.ajax({
			url: site_url+"/wp-admin/admin-ajax.php",
			type: "GET",
			data: {
				action: 'r2f_action_get_alltokentokencategories',
				page: 1,
				rows: 10000
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);
				tokentokencategories = data.rows;
				//console.log(tokentokencategories);
				
				
				
			}
		});
	
		jQuery("#continue").click(function() { 
			
			jQuery("#create-game").validate();
			if (!jQuery("#create-game").valid()) return false;
			
			var s = moment(jQuery("#startDate").val()+" "+jQuery("#startTime").val());
			s.zone(0);
			var startDate = s.format("YYYY-MM-DD");
			var startTime = s.format("HH:mm");
			
			var f = moment(jQuery("#finishDate").val()+" "+jQuery("#finishTime").val());
			f.zone(0);
			var finishDate = f.format("YYYY-MM-DD");
			var finishTime = f.format("HH:mm");
			
			if (!s.isBefore(f)) {
				var n = noty({text: "Your start date must be before your finish date"});
				//alert("Your start date must be before your finish date");
				return false;
			}
			
			if (!jQuery("#raceTokens").val()) {
				var n = noty({text: "You must select at least one token"});
				return false;
			}
			
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_race',
					id: raceId,
					maxNoOfPlayers: jQuery("#maxNoOfPlayers").val(),
					raceName: jQuery("#raceName").val(),
					raceDescription: jQuery("#raceDescription").val(),
					mapId: jQuery("#mapId").val(),
					startDate: startDate,
					startTime: startTime,
					finishDate: finishDate,
					finishTime: finishTime,
					entryPrice: jQuery("#entryPrice").val(),
					raceTokens: jQuery("#raceTokens").val(),
					finishGridX: jQuery("#finishGridX").val(),
					finishGridY: jQuery("#finishGridY").val(),
					startGridX: jQuery("#startGridX").val(),
					startGridY: jQuery("#startGridY").val(),
					curDay: jQuery("#curDay").val(),
					curHour: 0,
					paymentMethodEmail: jQuery("#paymentMethodEmail").val(),
					justGivingCharityId: jQuery("#justGivingCharityId").val(),
					createdBy: current_user_id,
					private: jQuery("#private").val(),
					prizeDesc: jQuery("#prizeDesc").val(),
					entryCurrency: jQuery("#entryCurrency").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					jQuery("#result").text(data.message + " " + data.error);
					if (data.error == "")
						location.href = site_url+"/create-online-race-3/?raceId="+data.id;
						
					else
						var n = noty({text: data.error});
				}
			});
			
			return false;
		} );
		
		jQuery("#startDateTime").change(function(e) {
			// Build weather grid (and populate if it's already got data)
			ds = jQuery(this).val().split(" ");
			jQuery("#startDate").val(ds[0]);
			jQuery("#startTime").val(ds[1]);

		});
		
		jQuery("#finishDateTime").change(function(e) {
			// Build weather grid (and populate if it's already got data)
			ds = jQuery(this).val().split(" ");
			jQuery("#finishDate").val(ds[0]);
			jQuery("#finishTime").val(ds[1]);

		});
		
		//Timepicker
		
		jQuery("#startDateTime, #finishDateTime").datetimepicker({ dateFormat: "yy-mm-dd" });
		
	}
);

function options(raceId) {
	location.href = site_url+'/options?raceId='+raceId;
}

function qs(key) {
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx meta chars
    var match = location.search.match(new RegExp("[?&]"+key+"=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

function getTokens(raceId, tokenCategoryId) {
	jQuery.ajax({
		url: site_url+"/wp-admin/admin-ajax.php",
		type: "GET",
		data: {
			action: 'r2f_action_get_tokens',
			page: 0,
			rows: 100,
			tokenCategoryId: tokenCategoryId
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			var rowHtml = jQuery("#templateDiv").html();
			var row = "";
			var option = '';
			for (i=0;i<data.records;i++){
				option += '<option value="'+ data.rows[i].cell[0] + '">' + data.rows[i].cell[1] + '</option>';
				r = rowHtml;
				r = r.replace(/{index}/g, i);
				r = r.replace(/{tokenId}/g, data.rows[i].cell[0]);
				r = r.replace(/{tokenName}/g, data.rows[i].cell[1]);
				r = r.replace(/{imageUrl}/g,site_url+data.rows[i].cell[3]);
				row += r;
			}
			jQuery("#raceTokenResults").html(row);
			jQuery('#raceTokens').append(option);
			
			for (i=0;i<data.records;i++){
				
				jQuery("#token_"+i).click(function() { 

					return false;
				} );
				
				if ((i % 3) == 0)
					jQuery("#wrapper_"+i).addClass("first");
				if ((i % 3) == 2)
					jQuery("#wrapper_"+i).addClass("last");	

				//jQuery("#token_"+data.rows[i].cell[0]).qtip({
				jQuery("#wrapper_"+i).qtip({
				   content: data.rows[i].cell[4],
				   show: 'mouseover',
				   hide: 'mouseout',
				   position: {
					my: 'bottom center',
					at: 'top center'
				   }
				});
			}
			
			
			
			jQuery(".optionselect").bind("click", function(e) {
				var selection = jQuery(this).data('selection');        
				
				if (!jQuery(this).hasClass("active")) {
					jQuery(this).addClass("active");
					jQuery("#raceTokens option[value='"+selection+"']").prop("selected", true);
				} else {
					jQuery(this).removeClass("active");
					jQuery("#raceTokens option[value='"+selection+"']").prop("selected", false);
				}
				
				e.preventDefault();
			});    
			
			if (raceId) {
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
						
						for(i=0;i<data.rows.length;i++) {
							jQuery("#raceTokens option[value='"+data.rows[i].tokenId+"']").prop("selected", true);
						}
						
					}
				});
			}
			
			
		}
	});
}