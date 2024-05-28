$(document).ready(function(){
	
	$(document).on('click', '.wzrd-back-faculty', function(){
		var function_to_go = $(this).attr('data-function');
		var get_pstate = $(this).attr('data-state');
		$('#proccessLoader').show();
		$.ajax({
			type : "POST",
			url : baseUrl + "faculty/registration/"+function_to_go,
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
					
					$("#regStepOneTeacher").validate({
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
								url : baseUrl + "faculty/registration/account",
								data : $('#regStepOneTeacher').serialize(),
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
										$("#regStepTwoTeacher").validate({
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
											},
											submitHandler : function () {
												$('#proccessLoader').show();
												var personalFormData = new FormData(document.getElementById('regStepTwoTeacher'));    
												$.ajax({
													type : "POST",
													url : baseUrl + "faculty/registration/personal",
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
															$("#regStepThreeTeacher").validate({
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
																},
																submitHandler : function () {
																	$('#proccessLoader').show();
																	var academicFormData = new FormData(document.getElementById('regStepThreeTeacher'));    
																	$.ajax({
																		type : "POST",
																		url : baseUrl + "faculty/registration/academic",
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
					$("#regStepTwoTeacher").validate({
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
						},
						submitHandler : function () {
							$('#proccessLoader').show();
							var personalFormData = new FormData(document.getElementById('regStepTwoTeacher'));    
							$.ajax({
								type : "POST",
								url : baseUrl + "faculty/registration/personal",
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
										
										//start step 3
										$("#regStepThreeTeacher").validate({
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
											},
											submitHandler : function () {
												$('#proccessLoader').show();
												var academicFormData = new FormData(document.getElementById('regStepThreeTeacher'));    
												$.ajax({
													type : "POST",
													url : baseUrl + "faculty/registration/academic",
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
														}else
														{
															return false;
														}
													}
												});
											}
										}); //End step 3
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
					
					//start step 3
					$("#regStepThreeTeacher").validate({
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
						},
						submitHandler : function () {
							$('#proccessLoader').show();
							var academicFormData = new FormData(document.getElementById('regStepThreeTeacher'));    
							$.ajax({
								type : "POST",
								url : baseUrl + "faculty/registration/academic",
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
									}else
									{
										return false;
									}
								}
							});
						}
					}); //End step 3
				}else{
					return false;
				}
			}
		});
	});
	
	$("#regStepOneTeacher").validate({
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
                url : baseUrl + "faculty/registration/account",
                data : $('#regStepOneTeacher').serialize(),
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
						$("#regStepTwoTeacher").validate({
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
							},
							submitHandler : function () {
								$('#proccessLoader').show();
								var personalFormData = new FormData(document.getElementById('regStepTwoTeacher'));    
								$.ajax({
									type : "POST",
									url : baseUrl + "faculty/registration/personal",
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
											$("#regStepThreeTeacher").validate({
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
												},
												submitHandler : function () {
													$('#proccessLoader').show();
													var academicFormData = new FormData(document.getElementById('regStepThreeTeacher'));    
													$.ajax({
														type : "POST",
														url : baseUrl + "faculty/registration/academic",
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
	$("#regStepTwoTeacher").validate({
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
		},
		submitHandler : function () {
			$('#proccessLoader').show();
			var personalFormData = new FormData(document.getElementById('regStepTwoTeacher'));    
			$.ajax({
				type : "POST",
				url : baseUrl + "faculty/registration/personal",
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
						$("#regStepThreeTeacher").validate({
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
							},
							submitHandler : function () {
								$('#proccessLoader').show();
								var academicFormData = new FormData(document.getElementById('regStepThreeTeacher'));    
								$.ajax({
									type : "POST",
									url : baseUrl + "faculty/registration/academic",
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
	$("#regStepThreeTeacher").validate({
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
		},
		submitHandler : function () {
			$('#proccessLoader').show();
			var academicFormData = new FormData(document.getElementById('regStepThreeTeacher'));    
			$.ajax({
				type : "POST",
				url : baseUrl + "faculty/registration/academic",
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
					}else
					{
						return false;
					}
				}
			});
		}
	}); //End step 2
});