<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Schedule</a></li>
				<li><a href="javascript:;">SDT <?php echo $sdt_type; ?> Schedules</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">SDT <?php echo $sdt_type; ?> Schedules</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/schedules/sdt/contents.php'; ?>
					</div>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->
		
		<script type="text/javascript">
			$(document).ready(function(){
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				$(document).on('click', '.remove-row', function(){
					if(confirm('Are you sure?', true))
					{
						var schedule_id = $(this).attr('data-schedule');
						var sdt_id = $(this).attr('data-phase');
						$('.items-row-'+schedule_id).remove();
						if(document.querySelector('.cnt-row'))
						{
							var total_row = document.querySelector('.cnt-row').length + 1;
						}else
						{
							var total_row = 1;
						}
						
						if(total_row == 1)
						{
							$('.appnd-not-fnd-row').html(not_data);
						}
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/schedules/sdt_delschedule',
							data:{schedule_id:schedule_id, sdt_id:sdt_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function()
							{
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.module-form-number-'+schedule_id))
									{
										$('.module-form-number-'+schedule_id).remove();
										$('#onPgaeLoadingForm').html(data.content);
									}
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
									
									$("#createData").validate({
										rules:{
											schedule_title:{
												required: true,
											},
											from_date:{
												required: true,
											},
											to_date:{
												required: true,
											},
										},
										messages:{
											schedule_title:{
												required: null,
											},
											from_date:{
												required: null,
											},
											to_date:{
												required: null,
											},
										},
										submitHandler : function () {
											$('#loader').show();
											// your function if, validate is success
											var getFrmData = new FormData(document.getElementById('createData'));
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/schedules/sdt_create",
												data : getFrmData,
												dataType : "json",
												cache: false,
												contentType: false,
												processData: false,
												success : function (data) {
													if(data.status == "ok")
													{
														document.getElementById("createData").reset();
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#alert').html(data.success);
														$('#loader').hide();
														$('#getContents').html(data.content);
														$('#data-table').DataTable();
														return false;
													}else if(data.status == "error"){
														$('#alert').html(data.error);
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#loader').hide();
														return false;
													}else
													{
														//have end check.
													}
													return false;
												}
											});
										}
									});
									$(".daterange-singledate").daterangepicker();
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else
					{
						return false;
					}
				});
				
				$(document).on('click', '.btn-remove-form', function(){
					$(this).parent().parent().parent().hide();
					$('.display-crtbtn').show();
				});
				
				$(document).on('click', '.display-create-frm', function(){
					$(this).parent().hide();
					$('.form-cntnt').show();
				});
				
				$(document).on('click', '.row-action-edit', function(){
					$('#onPgaeLoadingForm').html('');
					var schedule_id = $(this).attr('data-schedule');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/schedules/sdt_edit",
						data:{schedule_id:schedule_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#onPgaeLoadingForm').html(data.content);
								
								$(document).on('click', '.del-student-resource', function(){
									var endmschedule_id = $(this).attr('data-id');
									if(confirm('Are you sure?', true))
									{
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_delete_student_resource",
											data : {endmschedule_id:endmschedule_id},
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
										$(this).parent().remove();
									}
								});
								
								$(document).on('click', '.del-faculty-resource', function(){
									var endmschedule_id = $(this).attr('data-id');
									if(confirm('Are you sure?', true))
									{
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_delete_faculty_resource",
											data : {endmschedule_id:endmschedule_id},
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
										$(this).parent().remove();
									}
								});
								
								$("#updateData").validate({
									rules:{
										schedule_title:{
											required: true,
										},
										from_date:{
											required: true,
										},
										to_date:{
											required: true,
										},
									},
									messages:{
										exam_title:{
											required: null,
										},
										from_date:{
											required: null,
										},
										to_date:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										var getFrmData = new FormData(document.getElementById('updateData'));
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_update",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#loader').hide();
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
									}
								});
								$('#mdlBoxLoader').hide();
								
								$(".daterange-singledate").daterangepicker();
								$(".datetimepicker2").datetimepicker({
									format: "LT"
								});
								
								sqtoken_hash = data._jwar_t_kn_;
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
				
				$(document).on('click', '.retrive-create-again', function(){
					var sdt_id = $(this).attr('data-phase');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/schedules/sdt_schedule",
						data:{_jwar_t_kn_:sqtoken_hash, sdt_id:sdt_id},
						dataType: 'json',
						beforeSend: function()
						{
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#onPgaeLoadingForm').html(data.content);
								sqtoken_hash = data._jwar_t_kn_;
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								
								$("#createData").validate({
									rules:{
										schedule_title:{
											required: true,
										},
										from_date:{
											required: true,
										},
										to_date:{
											required: true,
										},
									},
									messages:{
										schedule_title:{
											required: null,
										},
										from_date:{
											required: null,
										},
										to_date:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										var getFrmData = new FormData(document.getElementById('createData'));
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_create",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("createData").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#loader').hide();
													return false;
												}else
												{
													//have end check.
												}
												$(".daterange-singledate").daterangepicker();
												return false;
											}
										});
									}
								});
								$('#mdlBoxLoader').hide();
								$(".daterange-singledate").daterangepicker();
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
			});
		</script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$("#createData").validate({
					rules:{
						schedule_title:{
							required: true,
						},
						from_date:{
							required: true,
						},
						to_date:{
							required: true,
						},
					},
					messages:{
						schedule_title:{
							required: null,
						},
						from_date:{
							required: null,
						},
						to_date:{
							required: null,
						},
					},
					submitHandler : function () {
						$('#loader').show();
						// your function if, validate is success
						var getFrmData = new FormData(document.getElementById('createData'));
						$.ajax({
							type : "POST",
							url : baseUrl + "coordinator/schedules/sdt_create",
							data : getFrmData,
							dataType : "json",
							cache: false,
							contentType: false,
							processData: false,
							success : function (data) {
								if(data.status == "ok")
								{
									document.getElementById("createData").reset();
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#alert').html(data.success);
									$('#loader').hide();
									$('#getContents').html(data.content);
									$('#data-table').DataTable();
									return false;
								}else if(data.status == "error"){
									$('#alert').html(data.error);
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#loader').hide();
									return false;
								}else
								{
									//have end check.
								}
								return false;
							}
						});
					}
				});
			})
		</script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				
				$(document).on('click', '.row-action-center', function(){
					var schedule_id = $(this).attr('data-schedule');
					$.ajax({
						type: 'POST',
						url: baseUrl + 'coordinator/schedules/sdt_lesson',
						data:{schedule_id:schedule_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#moduleLessonDisplay').html(data.content);
								$('#mdlBoxLoader').hide();
								
								$("#createCenterData").validate({
									rules:{
										center_id:{
											required: true,
										},
										to_date:{
											required: true,
										},
										to_time:{
											required: true,
										},
										max_sit:{
											required: true,
										},
										close_date:{
											required: true,
										},
										close_time:{
											required: true,
										},
									},
									messages:{
										center_id:{
											required: null,
										},
										to_date:{
											required: null,
										},
										to_time:{
											required: null,
										},
										max_sit:{
											required: null,
										},
										close_date:{
											required: null,
										},
										close_time:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_createlesson",
											data : $('#createCenterData').serialize(),
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("createCenterData").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#changePosition').html(data.change_position);
													$('.note-editable').html('');
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#loader').hide();
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
									}
								});
								
								$(".daterange-singledate").daterangepicker();
								$(".datetimepicker2").datetimepicker({
									format: "LT"
								});
								
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#data-table').DataTable();
								return false;
							}else
							{
								return false;
							}
						},
					});
				});
				
				//edit lesson
				$(document).on('click', '.return-create-lesson', function(){
					$('#onPgaeLoadingForm').html('');
					var schedule_id = $(this).attr('data-schedule');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/schedules/sdt_getlessoncreate",
						data : {schedule_id:schedule_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('#mdlBoxLoader').hide();
								$('#onPgaeLoadingForm').html(data.content);
								$('.form-cntnt').show();
								$('.display-crtbtn').hide();
								
								$("#createCenterData").validate({
									rules:{
										center_id:{
											required: true,
										},
										to_date:{
											required: true,
										},
										to_time:{
											required: true,
										},
										max_sit:{
											required: true,
										},
										close_date:{
											required: true,
										},
										close_time:{
											required: true,
										},
									},
									messages:{
										center_id:{
											required: null,
										},
										to_date:{
											required: null,
										},
										to_time:{
											required: null,
										},
										max_sit:{
											required: null,
										},
										close_date:{
											required: null,
										},
										close_time:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_createlesson",
											data : $('#createCenterData').serialize(),
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("createCenterData").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('.note-editable').html('');
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#loader').hide();
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
									}
								});
								
								$(".daterange-singledate").daterangepicker();
								$(".datetimepicker2").datetimepicker({
									format: "LT"
								});
								
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				});
				
				$(document).on('click', '.row-action-edit-lesson', function(){
					$('#onPgaeLoadingForm').html('');
					var schedule_id = $(this).attr('data-schedule');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/schedules/sdt_editlesson",
						data : {schedule_id:schedule_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('#mdlBoxLoader').hide();
								$('#onPgaeLoadingForm').html(data.content);
								
								$("#updateCenterData").validate({
									rules:{
										center_id:{
											required: true,
										},
										to_date:{
											required: true,
										},
										to_time:{
											required: true,
										},
										max_sit:{
											required: true,
										},
										close_date:{
											required: true,
										},
										close_time:{
											required: true,
										},
									},
									messages:{
										center_id:{
											required: null,
										},
										to_date:{
											required: null,
										},
										to_time:{
											required: null,
										},
										max_sit:{
											required: null,
										},
										close_date:{
											required: null,
										},
										close_time:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_updatelesson",
											data : $('#updateCenterData').serialize(),
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#loader').hide();
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
									}
								});
								
								$(".daterange-singledate").daterangepicker();
								$(".datetimepicker2").datetimepicker({
									format: "LT"
								});
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				});
				
				//remove lesson
				$(document).on('click', '.remove-row-lesson', function(){
					if(confirm('Are you sure?', true))
					{
						var schedule_id = $(this).attr('data-schedule');
						var parent_schedule_id = $(this).attr('data-parent-schedule');
						$('.items-row-'+schedule_id).remove();
						
						if(document.querySelector('.cnt-row'))
						{
							var total_row = document.querySelector('.cnt-row').length + 1;
						}else
						{
							var total_row = 1;
						}
						
						if(total_row == 1)
						{
							$('.appnd-not-fnd-row').html(not_data);
						}
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/schedules/sdt_dellesson',
							data:{schedule_id:schedule_id, parent_schedule_id:parent_schedule_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function(){
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.lesson-form-number-'+schedule_id))
									{
										$('.lesson-form-number-'+schedule_id).remove();
										$('#onPgaeLoadingForm').html(data.retrive_button);
									}
									$('#mdlBoxLoader').hide();
									
									$("#createCenterData").validate({
										rules:{
											section_title:{
												required: true,
											},
										},
										messages:{
											section_title:{
												required: null,
											},
										},
										submitHandler : function () {
											$('#loader').show();
											// your function if, validate is success
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/schedules/sdt_createlesson",
												data : $('#createCenterData').serialize(),
												dataType : "json",
												success : function (data) {
													if(data.status == "ok")
													{
														document.getElementById("createCenterData").reset();
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#alert').html(data.success);
														$('#loader').hide();
														$('#changePosition').html(data.change_position);
														$('.note-editable').html('');
														$('#getContents').html(data.content);
														$('#data-table').DataTable();
														return false;
													}else if(data.status == "error"){
														$('#alert').html(data.error);
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#loader').hide();
														return false;
													}else
													{
														//have end check.
													}
													return false;
												}
											});
										}
									});
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else
					{
						return false;
					}
				});
				
				$(document).on('click', '.back-to-modules', function(){
					var sdt_id = $(this).attr('data-phase');
					$.ajax({
					   type:"POST",
					   url: baseUrl + "coordinator/schedules/sdt_backtoschedules",
					   data: {sdt_id:sdt_id, _jwar_t_kn_:sqtoken_hash},
					   dataType: 'json',
					   cache: false,
					   beforeSend: function(){
						 $('#mdlBoxLoader').show();  
					   },
					   success: function(data){
						   if(data.status == 'ok')
						   {
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#moduleLessonDisplay').html(data.content);
								$('#mdlBoxLoader').hide();
								$("#createData").validate({
									rules:{
										schedule_title:{
											required: true,
										},
										from_date:{
											required: true,
										},
										to_date:{
											required: true,
										},
									},
									messages:{
										schedule_title:{
											required: null,
										},
										from_date:{
											required: null,
										},
										to_date:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										var getFrmData = new FormData(document.getElementById('createData'));
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/sdt_create",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("createData").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#loader').hide();
													return false;
												}else
												{
													//have end check.
												}
												return false;
											}
										});
									}
								});
								$(".daterange-singledate").daterangepicker();
								$('#data-table').DataTable();
								return false;
						   }else
						   {
							   //have error.
							   return false;
						   }
						   return false;
					   }
					});
				});
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>