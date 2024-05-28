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
				<li><a href="javascript:;">End Module Exam Schedule</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">End Module Exam Schedule</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/schedules/module_content.php'; ?>
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
						var phase_id = $(this).attr('data-phase');
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
							url: baseUrl+'coordinator/schedules/delschedule',
							data:{schedule_id:schedule_id, phase_id:phase_id, _jwar_t_kn_:sqtoken_hash},
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
									
									$("#mdlSchedule").validate({
										rules:{
											exam_title:{
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
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/schedules/create",
												data : $('#mdlSchedule').serialize(),
												dataType : "json",
												success : function (data) {
													if(data.status == "ok")
													{
														document.getElementById("mdlSchedule").reset();
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
						url: baseUrl + "coordinator/schedules/edit/module",
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
								
								$("#upMdlSchedule").validate({
									rules:{
										exam_title:{
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
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/update",
											data : $('#upMdlSchedule').serialize(),
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
								$('#mdlBoxLoader').hide();
								$(".daterange-singledate").daterangepicker();
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
					var phase_id = $(this).attr('data-phase');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/schedules/module/new",
						data:{_jwar_t_kn_:sqtoken_hash, phase_id:phase_id},
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
								
								$("#mdlSchedule").validate({
									rules:{
										exam_title:{
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
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/schedules/create",
											data : $('#mdlSchedule').serialize(),
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("mdlSchedule").reset();
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
			$("#mdlSchedule").validate({
				rules:{
					exam_title:{
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
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/schedules/create",
						data : $('#mdlSchedule').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("mdlSchedule").reset();
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
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>