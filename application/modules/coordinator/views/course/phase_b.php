<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Course</a></li>
				<li><a href="javascript:;">Chapter 2 (Books/Modules)</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Chapter 2 (Books/Modules)</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/course/module_content.php'; ?>
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
						var module_id = $(this).attr('data-module');
						var phase_id = $(this).attr('data-phase');
						$('.items-row-'+module_id).remove();
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
							url: baseUrl+'coordinator/course/delmodule',
							data:{module_id:module_id, phase_id:phase_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function()
							{
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.module-form-number-'+module_id))
									{
										$('.module-form-number-'+module_id).remove();
										$('#onPgaeLoadingForm').html(data.content);
									}
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
									
									$("#phaseA").validate({
										rules:{
											module_name:{
												required: true,
											},
											module_title:{
												required: true,
											},
										},
										messages:{
											module_name:{
												required: null,
											},
											module_title:{
												required: null,
											},
										},
										submitHandler : function () {
											$('#loader').show();
											// your function if, validate is success
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/course/create",
												data : $('#phaseA').serialize(),
												dataType : "json",
												success : function (data) {
													if(data.status == "ok")
													{
														document.getElementById("phaseA").reset();
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#alert').html(data.success);
														$('#loader').hide();
														$('#getContents').html(data.content);
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
					var module_id = $(this).attr('data-module');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/course/edit/module",
						data:{module_id:module_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#onPgaeLoadingForm').html(data.content);
								sqtoken_hash = data._jwar_t_kn_;
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								
								$("#upPhaseA").validate({
									rules:{
										module_name:{
											required: true,
										},
										module_title:{
											required: true,
										},
									},
									messages:{
										module_name:{
											required: null,
										},
										module_title:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/course/update",
											data : $('#upPhaseA').serialize(),
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
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
						url: baseUrl + "coordinator/course/module/new",
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
								
								$("#phaseA").validate({
									rules:{
										module_name:{
											required: true,
										},
										module_title:{
											required: true,
										},
									},
									messages:{
										module_name:{
											required: null,
										},
										module_title:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/course/create",
											data : $('#phaseA').serialize(),
											dataType : "json",
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("phaseA").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
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
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				
				$(document).on('click', '.row-action-lesson', function(){
					var module_id = $(this).attr('data-module');
					var phase_id = $(this).attr('data-phase');
					$.ajax({
						type: 'POST',
						url: baseUrl + 'coordinator/course/lesson',
						data:{module_id:module_id, phase_id:phase_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#moduleLessonDisplay').html(data.content);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#mdlBoxLoader').hide();
								CKEDITOR.replace( 'description' );
								$("#data-table").DataTable();
								$('input.note-image-input').removeClass('form-control');
								
								$("#phaseAlession").validate({
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
										var getFrmData = new FormData(document.getElementById('phaseAlession'));
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/course/createlesson",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													CKEDITOR.replace('description');
													document.getElementById("phaseAlession").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#changePosition').html(data.change_position);
													$('.note-editable').html('');
													$('#getContents').html(data.content);
													return false;
												}else if(data.status == "error"){
													CKEDITOR.replace('description');
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
								
								$("#upPhaseAlession").validate({
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
										var getFrmData = new FormData(document.getElementById('upPhaseAlession'));
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/course/createlesson",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													CKEDITOR.replace('description');
													document.getElementById("upPhaseAlession").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#changePosition').html(data.change_position);
													$('#getContents').html(data.content);
													return false;
												}else if(data.status == "error"){
													CKEDITOR.replace('description');
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
								return false;
							}else
							{
								return false;
							}
						},
					});
				});
				
				//View lesson
				$(document).on('click', '.row-action-view-lesson', function(){
					$('#onPgaeLoadingForm').html('');
					var lesson_id = $(this).attr('data-lesson');
					var module_id = $(this).attr('data-module');
					var phase_id = $(this).attr('data-phase');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/course/viewlesson",
						data : {lesson_id:lesson_id, module_id:module_id, phase_id:phase_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content);
								$('#mdlBoxLoader').hide();
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				});
				
				//edit lesson
				$(document).on('click', '.return-create-lesson', function(){
					$('#onPgaeLoadingForm').html('');
					var phase_id = $(this).attr('data-phase');
					var module_id = $(this).attr('data-module');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/course/getlessoncreate",
						data : {phase_id:phase_id, module_id:module_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#mdlBoxLoader').hide();
								$('#onPgaeLoadingForm').html(data.content);
								$('.form-cntnt').show();
								$('.display-crtbtn').hide();
								CKEDITOR.replace( 'description' );
								$('input.note-image-input').removeClass('form-control');
								$("#phaseAlession").validate({
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
										var getFrmData = new FormData(document.getElementById('phaseAlession'));
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/course/createlesson",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													CKEDITOR.replace('description');
													document.getElementById("phaseAlession").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#changePosition').html(data.change_position);
													$('.note-editable').html('');
													$('#getContents').html(data.content);
													return false;
												}else if(data.status == "error"){
													CKEDITOR.replace('description');
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
					var lesson_id = $(this).attr('data-lesson');
					var phase_id = $(this).attr('data-phase');
					var module_id = $(this).attr('data-module');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/course/editlesson",
						data : {lesson_id:lesson_id, phase_id:phase_id, module_id:module_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#mdlBoxLoader').hide();
								$('#onPgaeLoadingForm').html(data.content);
								CKEDITOR.replace( 'description' );
								$('input.note-image-input').removeClass('form-control');
								
								$("#upPhaseAlession").validate({
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
										var getFrmData = new FormData(document.getElementById('upPhaseAlession'));
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/course/updatelesson",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													CKEDITOR.replace('description');
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
													return false;
												}else if(data.status == "error"){
													CKEDITOR.replace('description');
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
						var lesson_id = $(this).attr('data-lesson');
						var module_id = $(this).attr('data-module');
						var phase_id = $(this).attr('data-phase');
						$('.items-row-'+lesson_id).remove();
						
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
							url: baseUrl+'coordinator/course/dellesson',
							data:{lesson_id:lesson_id, module_id:module_id, phase_id:phase_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function(){
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.lesson-form-number-'+lesson_id))
									{
										$('.lesson-form-number-'+lesson_id).remove();
										$('#onPgaeLoadingForm').html(data.retrive_button);
									}
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
									
									$("#phaseAlession").validate({
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
											var getFrmData = new FormData(document.getElementById('phaseAlession'));
											// your function if, validate is success
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/course/createlesson",
												data : getFrmData,
												dataType : "json",
												cache: false,
												contentType: false,
												processData: false,
												success : function (data) {
													if(data.status == "ok")
													{
														CKEDITOR.replace('description');
														document.getElementById("phaseAlession").reset();
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#alert').html(data.success);
														$('#loader').hide();
														$('#changePosition').html(data.change_position);
														$('.note-editable').html('');
														$('#getContents').html(data.content);
														return false;
													}else if(data.status == "error"){
														CKEDITOR.replace('description');
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
					var phase_id = $(this).attr('data-phase');
					$.ajax({
					   type:"POST",
					   url: baseUrl + "coordinator/course/backtomodules",
					   data: {phase_id:phase_id, _jwar_t_kn_:sqtoken_hash},
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
			
			function sendFile(file, editor, welEditable) {
				var data = new FormData();
				data.append('file', file);
				data.append('_jwar_t_kn_', sqtoken_hash);
				 $.ajax({
				   type:"POST",
				   url: baseUrl + "coordinator/course/catalog_up",
				   data: data,
				   dataType: 'json',
				   contentType: false,
				   cache: false,
				   processData: false,
				   beforeSend: function(){
					 $('#mdlBoxLoader').show();  
				   },
				   success: function(data){
					   if(data.status == 'ok')
					   {
							editor.insertImage(welEditable, data.imgurl);
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash=data._jwar_t_kn_;
							$('#mdlBoxLoader').hide();
							return false;
					   }else
					   {
						   //have error.
						   return false;
					   }
					   return false;
				   }
				});
			}
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>