var tokentokencategories;

jQuery(document).ready
(
	function(jQuery)
	{

		if (!is_admin) {
		
			jQuery("#maxNoOfPlayers").attr("readonly", "readonly");
			jQuery("#mapId").attr("disabled", "true");
			jQuery("#startDate").attr("readonly", "readonly");
			jQuery("#startTime").attr("readonly", "readonly");
			jQuery("#finishDate").attr("readonly", "readonly");
			jQuery("#finishTime").attr("readonly", "readonly");
			jQuery("#finishGridX").attr("readonly", "readonly");
			jQuery("#finishGridY").attr("readonly", "readonly");
			jQuery("#startGridX").attr("readonly", "readonly");
			jQuery("#startGridY").attr("readonly", "readonly");
			jQuery("#curDay").attr("readonly", "readonly");
			jQuery("#curHour").attr("readonly", "readonly");
			jQuery("#raceStatus").attr("readonly", "readonly");
			jQuery("#refreshScores").attr("readonly", "readonly");
		
		}
		
		jQuery("#startA").click(function() {
			jQuery("#startA").addClass("btn-blue");
			jQuery("#finishA").removeClass("btn-blue");
			jQuery("#startA").addClass("active");
			jQuery("#finishA").removeClass("active");
			return false;
		});
		
		jQuery("#finishA").click(function() {
			jQuery("#finishA").addClass("btn-blue");
			jQuery("#startA").removeClass("btn-blue");
			jQuery("#finishA").addClass("active");
			jQuery("#startA").removeClass("active");
			return false;
		});
	
		var raceId = qs("raceId");
		var rowHtml = jQuery("#templateDiv").html();
		var lengthInDays;
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
							jQuery("#locationDescription").val(data.rows[0].locationDescription);
							jQuery("#weatherDescription").val(data.rows[0].weatherDescription);
							jQuery("#mapId").val(data.rows[0].mapId);
							
							jQuery("#startDate").val(convertDateTimeToISODate(data.rows[0].startDate, data.rows[0].startTime));
							jQuery("#startTime").val(convertDateTimeToTime(data.rows[0].startDate, data.rows[0].startTime));
							jQuery("#startDateTime").val(jQuery("#startDate").val() + ' ' + jQuery("#startTime").val());
							jQuery("#finishDate").val(convertDateTimeToISODate(data.rows[0].finishDate, data.rows[0].finishTime));
							jQuery("#finishTime").val(convertDateTimeToTime(data.rows[0].finishDate, data.rows[0].finishTime));
							jQuery("#finishDateTime").val(jQuery("#finishDate").val() + ' ' + jQuery("#finishTime").val());
							
							//jQuery("#startDate").val(data.rows[0].startDate);
							//jQuery("#startTime").val(data.rows[0].startTime);
							//jQuery("#startDateTime").val(data.rows[0].startDate + " " + data.rows[0].startTime);
							//jQuery("#finishDate").val(data.rows[0].finishDate);
							//jQuery("#finishTime").val(data.rows[0].finishTime);
							//jQuery("#finishDateTime").val(data.rows[0].finishDate + " " + data.rows[0].finishTime);
							jQuery("#entryPrice").val(data.rows[0].entryPrice);
							
							startGridX = data.rows[0].startGridX;
							startGridY = data.rows[0].startGridY;
							finishGridX = data.rows[0].finishGridX;
							finishGridY = data.rows[0].finishGridY;
							
							
							
							jQuery("#finishGridX").val(data.rows[0].finishGridX);
							jQuery("#finishGridY").val(data.rows[0].finishGridY);
							jQuery("#startGridX").val(data.rows[0].startGridX);
							jQuery("#startGridY").val(data.rows[0].startGridY);

							jQuery.ajax({
								url: site_url+"/wp-admin/admin-ajax.php",
								type: "POST",
								data: {
									action: 'r2f_action_get_map',
									id: data.rows[0].mapId
								},
								dataType: "JSON",
								success: function (data) {
									console.log(data);
									jQuery("#result").text(data.message + " " + data.error);
									if (data.error == "") {
										mapId = data.result.id;
										mapName = data.result.mapName;
										mapImageUrl = data.result.mapImageUrl;
										mapWidth = data.result.mapWidth;
										mapHeight = data.result.mapHeight;
										gridWidth = data.result.gridWidth;
										gridHeight = data.result.gridHeight;
										cellWidth = data.result.cellWidth;
										cellHeight = data.result.cellHeight;
										mapTilesUrl = data.result.mapTilesUrl;
										minZoom = data.result.minZoom;
										maxZoom = data.result.maxZoom;
										boundaryX = data.result.boundaryX;
										boundaryY = data.result.boundaryY;

										drawMap('paperParentSF', true);

										map.on('click', function(e) {
						
											var p = getPoint(e.latlng);
											if (jQuery("#startA").hasClass("btn-blue")) {
												startGridX = p.x;
												startGridY = p.y;
											} else {
												finishGridX = p.x;
												finishGridY = p.y;
											}
											jQuery("#startGridX").val(startGridX);
											jQuery("#startGridY").val(startGridY);
											jQuery("#finishGridX").val(finishGridX);
											jQuery("#finishGridY").val(finishGridY);
											
											drawStart();
											drawFinish();
										});
									}
									
								}
							});

							jQuery("#curDay").val(data.rows[0].curDay);
							jQuery("#curHour").val(data.rows[0].curHour);
							jQuery("#raceStatus").val(data.rows[0].raceStatus);
							jQuery("#paymentMethodEmail").val(data.rows[0].paymentMethodEmail);
							jQuery("#justGivingCharityId").val(data.rows[0].justGivingCharityId);
							jQuery("#private").val(data.rows[0].private);
							jQuery("#prizeDesc").val(data.rows[0].prizeDesc);
							jQuery("#refreshScores").val(data.rows[0].refreshScores);
							
							jQuery("#sponserLogoUrl").val(data.rows[0].sponserLogoUrl);
							jQuery("#sponserLogoImg").attr("src", data.rows[0].sponserLogoUrl);
							jQuery("#sponserUrl").val(data.rows[0].sponserUrl);
							jQuery("#offline").val(data.rows[0].offline);
							jQuery("#entryCurrency").val(data.rows[0].entryCurrency);
							
							var row = "";
							lengthInDays = data.rows[0].lengthInDays;
							for(i=0;i<lengthInDays;i++) {
								r = rowHtml;
								r = r.replace(/{day}/g, i+1);
								row += r;	
							}
							jQuery("#weatherResults").append(row);
							
							jQuery.ajax({
								url: site_url+"/wp-admin/admin-ajax.php",
								type: "POST",
								data: {
									action: 'r2f_action_get_raceweather',
									raceId: raceId
								},
								dataType: "JSON",
								success: function (data) {
									console.log(data);
									var option = '';
									for (i=0;i<data.rows.length;i++){
									   jQuery("#weatherDay"+(i+1)).val(data.rows[i].weather);
									   jQuery("#weatherForecastDay"+(i+1)).val(data.rows[i].weatherForecast);
									   if (!is_admin) {
										jQuery("#weatherDay"+(i+1)).attr("disabled", true);
										jQuery("#weatherForecastDay"+(i+1)).attr("disabled", true);
									   }
									}
									
									
								}
							});
							
							jQuery.ajax({
								url: site_url+"/wp-admin/admin-ajax.php",
								type: "POST",
								data: {
									action: 'r2f_action_get_leaderboard',
									raceId: raceId,
									rows: 100000
								},
								dataType: "JSON",
								success: function (data) {
									console.log(data);
									
									var li = '';
									if (data.rows) {
										for (i=0;i<data.rows.length;i++){
										   li += '<li>'+ data.rows[i].pos + '. '+ data.rows[i].name + ' ('+data.rows[i].user_email+')</li>';
										}
										jQuery('#leaderboard').append(li);
									}
								}
							});
						}
					});
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
		
		jQuery("#addmore").click(function() { 
			location.href = site_url+"/add-to-game/?raceId="+raceId;
		});
	
		jQuery("#continue").click(function() { 
		
			var s = moment(jQuery("#startDate").val()+" "+jQuery("#startTime").val());
			s.zone(0);
			var startDate = s.format("YYYY-MM-DD");
			var startTime = s.format("HH:mm");
			
			var f = moment(jQuery("#finishDate").val()+" "+jQuery("#finishTime").val());
			f.zone(0);
			var finishDate = f.format("YYYY-MM-DD");
			var finishTime = f.format("HH:mm");
			console.log(s);
			console.log(f);
			if (!s.isBefore(f)) {
				var n = noty({text: "Your start date must be before your finish date"});
				//alert("Your start date must be before your finish date");
				return false;
			}
		
			jQuery(document).ajaxStop(function() {
				// place code to be executed on completion of last outstanding ajax call here
				var n = noty({text: "Race Updated. Please wait..."});
				location.href = site_url+"/active-race/?raceId="+raceId;
			});
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_upsert_race',
					id: raceId,
					maxNoOfPlayers: jQuery("#maxNoOfPlayers").val(),
					raceName: jQuery("#raceName").val(),
					raceDescription: jQuery("#raceDescription").val(),
					locationDescription: jQuery("#locationDescription").val(),
					weatherDescription: jQuery("#weatherDescription").val(),
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
					curHour: jQuery("#curHour").val(),
					raceStatus: jQuery("#raceStatus").val(),
					paymentMethodEmail: jQuery("#paymentMethodEmail").val(),
					justGivingCharityId: jQuery("#justGivingCharityId").val(),
					private: jQuery("#private").val(),
					prizeDesc: jQuery("#prizeDesc").val(),
					refreshScores: jQuery("#refreshScores").val(),
					offline: jQuery("#offline").val(),
					entryCurrency: jQuery("#entryCurrency").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					//jQuery("#result").text(data.message + " " + data.error);
					//options(data.id);
					//var n = noty({text: data.message + " " + data.error});
					var i;
					for (i=0;i<lengthInDays;i++) {
						jQuery.ajax({
							url: site_url+"/wp-admin/admin-ajax.php",
							type: "POST",
							data: {
								action: 'r2f_action_upsert_raceweather',
								raceId: raceId,
								day: i,
								weather: jQuery("#weatherDay"+(i+1)).val(),
								weatherForecast: jQuery("#weatherForecastDay"+(i+1)).val()
							},
							dataType: "JSON",
							success: function (data) {
								console.log(data);
								//jQuery("#result").text(data.message + " " + data.error);
								//options(data.id);
								//var n = noty({text: data.message + " " + data.error});
							}
						});
					}
					
					jQuery.ajax({
						url: site_url+"/wp-admin/admin-ajax.php",
						type: "POST",
						data: {
							action: 'r2f_action_update_racesponserLogo',
							raceId: raceId,
							sponserLogoUrl: jQuery("#sponserLogoUrl").val(),
							sponserUrl: jQuery("#sponserUrl").val()
						},
						dataType: "JSON",
						success: function (data) {
							console.log(data);
								
						}
					});
				}
			});
			
			return false;
		} );
		
		jQuery("#sponserLogo").change(function(e) {
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_get_image_url',
					file: jQuery("#sponserLogo").val()
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					if (data.url!="") {
						jQuery("#sponserLogoUrl").val(data.url);
						jQuery("#sponserLogoImg").attr("src", data.url);
						jQuery("#sponserLogoImg").removeClass("myhidden");
					}
				}
			});
		});
		
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
		
		jQuery("#startDateTime, #finishDateTime").datetimepicker({ dateFormat: "yy-mm-dd" });

		jQuery("#delete").click(function(e) { 
			e.preventDefault();
			yn = confirm("Are you sure you want to delete this race?");
			if (!yn) return false;
			
			jQuery.ajax({
				url: site_url+"/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: 'r2f_action_delete_race',
					id: raceId
				},
				dataType: "JSON",
				success: function (data) {
					console.log(data);
					var n = noty({text: data.message + " " + data.error});
					location.href = site_url + "/admin-dashboard";
				}
			});
			
		});
		
		jQuery("#startGridX,#startGridY,#finishGridX,#finishGridY").change(function(e) {
			startGridX = jQuery("#startGridX").val();
			startGridY = jQuery("#startGridY").val();
			finishGridX = jQuery("#finishGridX").val();
			finishGridY = jQuery("#finishGridY").val();
			drawGrid();
		});


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
			var rowHtml = jQuery("#templateDiv2").html();
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
							jQuery("#token_"+data.rows[i].tokenId).addClass("active");
						}
						
					}
				});
			}
			
			
		}
	});
}