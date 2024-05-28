$(document).ready(function(){
	$(document).on('click', '.wzrd-back', function(){
		var function_to_go = $(this).attr('data-function');
		var get_pstate = $(this).attr('data-state');
		$('#proccessLoader').show();
		$.ajax({
			type : "POST",
			url : baseUrl + "student/registration/"+function_to_go,
			data : {check:1},
			dataType : "json",
			cache: false,
			contentType: false,
			processData: false,
			success : function (data) {
				if(data.status == 'ok')
				{
					document.title = 'Wait for coordinator approval';
					window.history.pushState(null, null, get_pstate);
					$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
					$('#stepWizard').html(data.wizard);	
					$('#formDescField').html(data.content);
					$('html, body').animate({
						scrollTop: $("body").offset().top
					 }, 1000);
					$('#proccessLoader').hide();
					
					$("#regStepOneStudent").validate({
						rules:{
							email:{
								required: true,
								email:true,
							},
							password:{
								required: true,
							},
							re_password:{
								required: true,
								equalTo: "#mainPass",
							},
						},
						submitHandler : function () {
							$('#proccessLoader').show();
							$.ajax({
								type : "POST",
								url : baseUrl + "student/registration/account",
								data : $('#regStepOneStudent').serialize(),
								dataType : "json",
								cache: false,
								success : function (data) {
									if(data.status == 'ok')
									{
										document.title = 'Personal Information';
										window.history.pushState(null, null, 'personal');
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										$('#stepWizard').html(data.wizard);	
										$('#formDescField').html(data.content);
										$('html, body').animate({
											scrollTop: $("body").offset().top
										 }, 1000);
										$('#proccessLoader').hide();
										
										//start step 2
										$("#regStepTwoStudent").validate({
											rules:{
												first_name:{
													required: true,
												},
												last_name:{
													required: true,
												},
												birthday:{
													required: true,
												},
												gender:{
													required: true,
												},
												mobile:{
													required: true,
													number:true,
												},
												current_address:{
													required: true,
												},
												father_name:{
													required: true,
												},
												mother_name:{
													required: true,
												},
											},
											submitHandler : function () {
												$('#proccessLoader').show();
												var personalFormData = new FormData(document.getElementById('regStepTwoStudent'));    
												$.ajax({
													type : "POST",
													url : baseUrl + "student/registration/personal",
													data : personalFormData,
													dataType : "json",
													cache: false,
													contentType: false,
													processData: false,
													success : function (data) {
														if(data.status == 'ok')
														{
															document.title = 'Professional & Academic Information';
															window.history.pushState(null, null, 'academic');
															$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
															$('#stepWizard').html(data.wizard);	
															$('#formDescField').html(data.content);
															$('html, body').animate({
																scrollTop: $("body").offset().top
															 }, 1000);
															$('#proccessLoader').hide();
															
															//start step 2
															$("#regStepThreeStudent").validate({
																rules:{
																	designation:{
																		required: true,
																	},
																	degree_1:{
																		required: true,
																	},
																	degree_2:{
																		required: true,
																	},
																	degree_3:{
																		required: true,
																	},
																	year_1:{
																		required: true,
																	},
																	year_2:{
																		required: true,
																	},
																	year_3:{
																		required: true,
																	},
																	institute_1:{
																		required: true,
																	},
																	institute_2:{
																		required: true,
																	},
																	institute_3:{
																		required: true,
																	},
																	cgpa_1:{
																		required: true,
																	},
																	cgpa_2:{
																		required: true,
																	},
																	cgpa_3:{
																		required: true,
																	},
																	bmanddc_number:{
																		required: true,
																	},
																	
																},
																submitHandler : function () {
																	$('#proccessLoader').show();
																	var academicFormData = new FormData(document.getElementById('regStepThreeStudent'));    
																	$.ajax({
																		type : "POST",
																		url : baseUrl + "student/registration/academic",
																		data : academicFormData,
																		dataType : "json",
																		cache: false,
																		contentType: false,
																		processData: false,
																		success : function (data) {
																			if(data.status == 'ok')
																			{
																				document.title = 'Wait for coordinator approval';
																				window.history.pushState(null, null, 'approval');
																				$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
																				$('#stepWizard').html(data.wizard);	
																				$('#formDescField').html(data.content);
																				$('html, body').animate({
																					scrollTop: $("body").offset().top
																				 }, 1000);
																				$('#proccessLoader').hide();
																				return false;
																			}else if(data.status == 'error'){
																				$('#messaging').html(data.error);
																				$('html, body').animate({
																					scrollTop: $("body").offset().top
																				 }, 1000);
																				$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
																				$('#proccessLoader').hide();
																			}else
																			{
																				return false;
																			}
																		}
																	});
																}
															}); //End step 2
															return false;
														}else if(data.status == 'error'){
															$('#messaging').html(data.error);
															$('html, body').animate({
																scrollTop: $("body").offset().top
															 }, 1000);
															$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
															$('#proccessLoader').hide();
														}else{
															return false;
														}
													}
												});
											}
										}); //End step 2
										
										return false;
									}else if(data.status == 'error'){
										$('#messaging').html(data.error);
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										$('#proccessLoader').hide();
										return false;
									}else
									{
										return false;
									}
								}
							});
						}
					});
					
					//start step 2
					$("#regStepTwoStudent").validate({
						rules:{
							first_name:{
								required: true,
							},
							last_name:{
								required: true,
							},
							birthday:{
								required: true,
							},
							gender:{
								required: true,
							},
							mobile:{
								required: true,
								number:true,
							},
							current_address:{
								required: true,
							},
							father_name:{
								required: true,
							},
							mother_name:{
								required: true,
							},
						},
						submitHandler : function () {
							$('#proccessLoader').show();
							var personalFormData = new FormData(document.getElementById('regStepTwoStudent'));    
							$.ajax({
								type : "POST",
								url : baseUrl + "student/registration/personal",
								data : personalFormData,
								dataType : "json",
								cache: false,
								contentType: false,
								processData: false,
								success : function (data) {
									if(data.status == 'ok')
									{
										document.title = 'Professional & Academic Information';
										window.history.pushState(null, null, 'academic');
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										$('#stepWizard').html(data.wizard);	
										$('#formDescField').html(data.content);
										$('html, body').animate({
											scrollTop: $("body").offset().top
										 }, 1000);
										$('#proccessLoader').hide();
										
										//start step 2
										$("#regStepThreeStudent").validate({
											rules:{
												designation:{
													required: true,
												},
												degree_1:{
													required: true,
												},
												degree_2:{
													required: true,
												},
												degree_3:{
													required: true,
												},
												year_1:{
													required: true,
												},
												year_2:{
													required: true,
												},
												year_3:{
													required: true,
												},
												institute_1:{
													required: true,
												},
												institute_2:{
													required: true,
												},
												institute_3:{
													required: true,
												},
												cgpa_1:{
													required: true,
												},
												cgpa_2:{
													required: true,
												},
												cgpa_3:{
													required: true,
												},
												bmanddc_number:{
													required: true,
												},
											},
											submitHandler : function () {
												$('#proccessLoader').show();
												var academicFormData = new FormData(document.getElementById('regStepThreeStudent'));    
												$.ajax({
													type : "POST",
													url : baseUrl + "student/registration/academic",
													data : academicFormData,
													dataType : "json",
													cache: false,
													contentType: false,
													processData: false,
													success : function (data) {
														if(data.status == 'ok')
														{
															document.title = 'Wait for coordinator approval';
															window.history.pushState(null, null, 'approval');
															$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
															$('#stepWizard').html(data.wizard);	
															$('#formDescField').html(data.content);
															$('html, body').animate({
																scrollTop: $("body").offset().top
															 }, 1000);
															$('#proccessLoader').hide();
															return false;
														}else if(data.status == 'error'){
															$('#messaging').html(data.error);
															$('html, body').animate({
																scrollTop: $("body").offset().top
															 }, 1000);
															$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
															$('#proccessLoader').hide();
														}else
														{
															return false;
														}
													}
												});
											}
										}); //End step 2
										return false;
									}else if(data.status == 'error'){
										$('#messaging').html(data.error);
										$('html, body').animate({
											scrollTop: $("body").offset().top
										 }, 1000);
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										$('#proccessLoader').hide();
									}else{
										return false;
									}
								}
							});
						}
					}); //End step 2
					
					//start step 2
					$("#regStepThreeStudent").validate({
						rules:{
							designation:{
								required: true,
							},
							degree_1:{
								required: true,
							},
							degree_2:{
								required: true,
							},
							degree_3:{
								required: true,
							},
							year_1:{
								required: true,
							},
							year_2:{
								required: true,
							},
							year_3:{
								required: true,
							},
							institute_1:{
								required: true,
							},
							institute_2:{
								required: true,
							},
							institute_3:{
								required: true,
							},
							cgpa_1:{
								required: true,
							},
							cgpa_2:{
								required: true,
							},
							cgpa_3:{
								required: true,
							},
							bmanddc_number:{
								required: true,
							},
						},
						submitHandler : function () {
							$('#proccessLoader').show();
							var academicFormData = new FormData(document.getElementById('regStepThreeStudent'));    
							$.ajax({
								type : "POST",
								url : baseUrl + "student/registration/academic",
								data : academicFormData,
								dataType : "json",
								cache: false,
								contentType: false,
								processData: false,
								success : function (data) {
									if(data.status == 'ok')
									{
										document.title = 'Wait for coordinator approval';
										window.history.pushState(null, null, 'approval');
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										$('#stepWizard').html(data.wizard);	
										$('#formDescField').html(data.content);
										$('html, body').animate({
											scrollTop: $("body").offset().top
										 }, 1000);
										$('#proccessLoader').hide();
										return false;
									}else if(data.status == 'error'){
										$('#messaging').html(data.error);
										$('html, body').animate({
												scrollTop: $("body").offset().top
											 }, 1000);
										$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
										$('#proccessLoader').hide();
									}else
									{
										return false;
									}
								}
							});
						}
					}); //End step 2
					
					return false;
				}else if(data.status == 'error'){
						$('#messaging').html(data.error);
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#proccessLoader').hide();
						return false;
				}else
				{
					return false;
				}
			}
		});
	});
	
	$("#regStepOneStudent").validate({
		rules:{
			email:{
				required: true,
				email:true,
			},
			password:{
				required: true,
			},
			re_password:{
				required: true,
				equalTo: "#mainPass",
			},
		},
        submitHandler : function () {
			$('#proccessLoader').show();
            $.ajax({
                type : "POST",
                url : baseUrl + "student/registration/account",
                data : $('#regStepOneStudent').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == 'ok')
					{
						document.title = 'Personal Information';
						window.history.pushState(null, null, 'personal');
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#stepWizard').html(data.wizard);	
						$('#formDescField').html(data.content);
						$('html, body').animate({
							scrollTop: $("body").offset().top
						 }, 1000);
						$('#proccessLoader').hide();
						
						//start step 2
						$("#regStepTwoStudent").validate({
							rules:{
								first_name:{
									required: true,
								},
								last_name:{
									required: true,
								},
								birthday:{
									required: true,
								},
								gender:{
									required: true,
								},
								mobile:{
									required: true,
									number:true,
								},
								current_address:{
									required: true,
								},
								father_name:{
									required: true,
								},
								mother_name:{
									required: true,
								},
							},
							submitHandler : function () {
								$('#proccessLoader').show();
								var personalFormData = new FormData(document.getElementById('regStepTwoStudent'));    
								$.ajax({
									type : "POST",
									url : baseUrl + "student/registration/personal",
									data : personalFormData,
									dataType : "json",
									cache: false,
									contentType: false,
									processData: false,
									success : function (data) {
										if(data.status == 'ok')
										{
											document.title = 'Professional & Academic Information';
											window.history.pushState(null, null, 'academic');
											$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
											$('#stepWizard').html(data.wizard);	
											$('#formDescField').html(data.content);
											$('html, body').animate({
												scrollTop: $("body").offset().top
											 }, 1000);
											$('#proccessLoader').hide();
											
											//start step 2
											$("#regStepThreeStudent").validate({
												rules:{
													designation:{
														required: true,
													},
													degree_1:{
														required: true,
													},
													degree_2:{
														required: true,
													},
													degree_3:{
														required: true,
													},
													year_1:{
														required: true,
													},
													year_2:{
														required: true,
													},
													year_3:{
														required: true,
													},
													institute_1:{
														required: true,
													},
													institute_2:{
														required: true,
													},
													institute_3:{
														required: true,
													},
													cgpa_1:{
														required: true,
													},
													cgpa_2:{
														required: true,
													},
													cgpa_3:{
														required: true,
													},
													bmanddc_number:{
														required: true,
													},
												},
												submitHandler : function () {
													$('#proccessLoader').show();
													var academicFormData = new FormData(document.getElementById('regStepThreeStudent'));    
													$.ajax({
														type : "POST",
														url : baseUrl + "student/registration/academic",
														data : academicFormData,
														dataType : "json",
														cache: false,
														contentType: false,
														processData: false,
														success : function (data) {
															if(data.status == 'ok')
															{
																document.title = 'Wait for coordinator approval';
																window.history.pushState(null, null, 'approval');
																$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
																$('#stepWizard').html(data.wizard);	
																$('#formDescField').html(data.content);
																$('html, body').animate({
																	scrollTop: $("body").offset().top
																 }, 1000);
																$('#proccessLoader').hide();
																return false;
															}else if(data.status == 'error'){
																$('#messaging').html(data.error);
																$('html, body').animate({
																	scrollTop: $("body").offset().top
																 }, 1000);
																$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
																$('#proccessLoader').hide();
															}else
															{
																return false;
															}
														}
													});
												}
											}); //End step 2
											return false;
										}else if(data.status == 'error'){
											$('#messaging').html(data.error);
											$('html, body').animate({
												scrollTop: $("body").offset().top
											 }, 1000);
											$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
											$('#proccessLoader').hide();
										}else{
											return false;
										}
									}
								});
							}
						}); //End step 2
						
						return false;
					}else if(data.status == 'error'){
						$('#messaging').html(data.error);
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#proccessLoader').hide();
						return false;
					}else
					{
						return false;
					}
                }
            });
        }
    });
	
	//start step 2
	$("#regStepTwoStudent").validate({
		rules:{
			first_name:{
				required: true,
			},
			last_name:{
				required: true,
			},
			birthday:{
				required: true,
			},
			gender:{
				required: true,
			},
			mobile:{
				required: true,
				number:true,
			},
			current_address:{
				required: true,
			},
			father_name:{
				required: true,
			},
			mother_name:{
				required: true,
			},
		},
		submitHandler : function () {
			$('#proccessLoader').show();
			var personalFormData = new FormData(document.getElementById('regStepTwoStudent'));    
			$.ajax({
				type : "POST",
				url : baseUrl + "student/registration/personal",
				data : personalFormData,
				dataType : "json",
				cache: false,
				contentType: false,
				processData: false,
				success : function (data) {
					if(data.status == 'ok')
					{
						document.title = 'Professional & Academic Information';
						window.history.pushState(null, null, 'academic');
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#stepWizard').html(data.wizard);	
						$('#formDescField').html(data.content);
						$('html, body').animate({
							scrollTop: $("body").offset().top
						 }, 1000);
						$('#proccessLoader').hide();
						
						//start step 2
						$("#regStepThreeStudent").validate({
							rules:{
								designation:{
									required: true,
								},
								degree_1:{
									required: true,
								},
								degree_2:{
									required: true,
								},
								degree_3:{
									required: true,
								},
								year_1:{
									required: true,
								},
								year_2:{
									required: true,
								},
								year_3:{
									required: true,
								},
								institute_1:{
									required: true,
								},
								institute_2:{
									required: true,
								},
								institute_3:{
									required: true,
								},
								cgpa_1:{
									required: true,
								},
								cgpa_2:{
									required: true,
								},
								cgpa_3:{
									required: true,
								},
								bmanddc_number:{
									required: true,
								},
							},
							submitHandler : function () {
								$('#proccessLoader').show();
								var academicFormData = new FormData(document.getElementById('regStepThreeStudent'));    
								$.ajax({
									type : "POST",
									url : baseUrl + "student/registration/academic",
									data : academicFormData,
									dataType : "json",
									cache: false,
									contentType: false,
									processData: false,
									success : function (data) {
										if(data.status == 'ok')
										{
											document.title = 'Wait for coordinator approval';
											window.history.pushState(null, null, 'approval');
											$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
											$('#stepWizard').html(data.wizard);	
											$('#formDescField').html(data.content);
											$('html, body').animate({
												scrollTop: $("body").offset().top
											 }, 1000);
											$('#proccessLoader').hide();
											return false;
										}else if(data.status == 'error'){
											$('#messaging').html(data.error);
											$('html, body').animate({
												scrollTop: $("body").offset().top
											 }, 1000);
											$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
											$('#proccessLoader').hide();
										}else
										{
											return false;
										}
									}
								});
							}
						}); //End step 2
						return false;
					}else if(data.status == 'error'){
						$('#messaging').html(data.error);
						$('html, body').animate({
							scrollTop: $("body").offset().top
						 }, 1000);
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#proccessLoader').hide();
					}else{
						return false;
					}
				}
			});
		}
	}); //End step 2
	
	//start step 2
	$("#regStepThreeStudent").validate({
		rules:{
			designation:{
				required: true,
			},
			degree_1:{
				required: true,
			},
			degree_2:{
				required: true,
			},
			degree_3:{
				required: true,
			},
			year_1:{
				required: true,
			},
			year_2:{
				required: true,
			},
			year_3:{
				required: true,
			},
			institute_1:{
				required: true,
			},
			institute_2:{
				required: true,
			},
			institute_3:{
				required: true,
			},
			cgpa_1:{
				required: true,
			},
			cgpa_2:{
				required: true,
			},
			cgpa_3:{
				required: true,
			},
			bmanddc_number:{
				required: true,
			},
		},
		submitHandler : function () {
			$('#proccessLoader').show();
			var academicFormData = new FormData(document.getElementById('regStepThreeStudent'));    
			$.ajax({
				type : "POST",
				url : baseUrl + "student/registration/academic",
				data : academicFormData,
				dataType : "json",
				cache: false,
				contentType: false,
				processData: false,
				success : function (data) {
					if(data.status == 'ok')
					{
						document.title = 'Wait for coordinator approval';
						window.history.pushState(null, null, 'approval');
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#stepWizard').html(data.wizard);	
						$('#formDescField').html(data.content);
						$('html, body').animate({
							scrollTop: $("body").offset().top
						 }, 1000);
						$('#proccessLoader').hide();
						return false;
					}else if(data.status == 'error'){
											$('#messaging').html(data.error);
											$('html, body').animate({
												scrollTop: $("body").offset().top
											 }, 1000);
											$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
											$('#proccessLoader').hide();
										}else
					{
						return false;
					}
				}
			});
		}
	}); //End step 2
	
	$("#regStepFiveStudent").validate({
		submitHandler : function () {
			$('#proccessLoader').show();
			$.ajax({
				type : "POST",
				url : baseUrl + "student/registration/payment",
				data : $('#regStepFiveStudent').serialize(),
				dataType : "json",
				success : function (data) {
					if(data.status == 'ok')
					{
						window.location.href = baseUrl+'payment/online/pay';
						return false;
					}else
					{
						return false;
					}
				}
			});
		}
	}); //End step 2
	
	$("#depositType").validate({
		rules:{
			bank_name:{
				required: true,
			},
			ac_number:{
				required: true,
			},
			branch_name:{
				required: true,
			},
		},
		submitHandler : function () {
			$('#depositLoader').show();
			var depositFormData = new FormData(document.getElementById('depositType')); 
			$.ajax({
				type : "POST",
				url : baseUrl + "student/registration/updeposit",
				data : depositFormData,
				dataType : "json",
				cache: false,
				contentType: false,
				processData: false,
				success : function (data) {
					if(data.status == 'ok')
					{
						window.location.href = baseUrl+'student/onboard/success?type=deposit&SID='+data.sid+'&SUCCESS=TRUE&ADDITIONAL=TRUE';
						return false;
					}else if(data.status == 'error'){
						$('#errmsg').html(data.error);
						$('#depositLoader').hide();
					}else{
						return false;
					}
				}
			});
		}
	}); //End step 2
	
	$(document).on("click", ".sel-chk", function(){
		if ($('input.other-chk').is(':checked')) {
			$('#otherField').html('<div class="form-group"><input type="text" class="form-control" name="other_specialization" /></div>');
		}else
		{
			$('#otherField').html('');
		}
	});
});