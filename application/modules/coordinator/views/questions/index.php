<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Exam Question</a></li>
				<li><a href="javascript:;">End-Of-Lesson Exam Questions</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">End-Of-Lesson Exam Questions</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/questions/contents.php'; ?>
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
		<!-- end #content -->
		<div class="modal" id="modal-without-animation-question">
			<div class="modal-dialog" style="width:700px">
				<div class="modal-content" id="viewCntAnswer"></div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				$(document).on('click', '.remove-row', function(){
					if(confirm('Are you sure?', true))
					{
						var id = $(this).attr('data-id');
						$('.items-row-'+id).remove();
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
							url: baseUrl+'coordinator/questions/delete',
							data:{id:id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function()
							{
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.form-number-'+id))
									{
										$('.form-number-'+id).remove();
										$('#onPgaeLoadingForm').html(data.content);
									}
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
									
									$("#createData").validate({
										rules:{
											title:{
												required: true,
											},phase_level:{
												required: true,
											},module:{
												required: true,
											},answer_1:{
												required: true,
											},answer_2:{
												required: true,
											},answer_3:{
												required: true,
											},answer_4:{
												required: true,
											},
										},
										messages:{
											title:{
												required: null,
											},phase_level:{
												required: null,
											},module:{
												required: null,
											},answer_1:{
												required: null,
											},answer_2:{
												required: null,
											},answer_3:{
												required: null,
											},answer_4:{
												required: null,
											},
										},
										submitHandler : function () {
											$('#loader').show();
											// your function if, validate is success
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/questions/create",
												data : $('#createData').serialize(),
												dataType : "json",
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
														//window.location.reload(true)
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
					var id = $(this).attr('data-id');
					var q_type = $(this).attr('data-q-type');
					var q_exam_type = 'Lesson';
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/questions/edit",
						data:{id:id, q_type:q_type, q_exam_type:q_exam_type, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#onPgaeLoadingForm').html(data.content);
								row_two = $('#answerDistributeEdit .check-length-edit').length + 1;
								
								$("#updateData").validate({
									rules:{
										title:{
											required: true,
										},phase_level:{
											required: true,
										},module:{
											required: true,
										},answer_1:{
											required: true,
										},answer_2:{
											required: true,
										},answer_3:{
											required: true,
										},answer_4:{
											required: true,
										},
									},
									messages:{
										title:{
											required: null,
										},phase_level:{
											required: null,
										},module:{
											required: null,
										},answer_1:{
											required: null,
										},answer_2:{
											required: null,
										},answer_3:{
											required: null,
										},answer_4:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/questions/update",
											data : $('#updateData').serialize(),
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
													//window.location.reload(true)
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
					var id = $(this).attr('data-id');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/questions/create_question",
						data:{_jwar_t_kn_:sqtoken_hash, id:id},
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
										title:{
											required: true,
										},phase_level:{
											required: true,
										},module:{
											required: true,
										},answer_1:{
											required: true,
										},answer_2:{
											required: true,
										},answer_3:{
											required: true,
										},answer_4:{
											required: true,
										},
									},
									messages:{
										title:{
											required: null,
										},phase_level:{
											required: null,
										},module:{
											required: null,
										},answer_1:{
											required: null,
										},answer_2:{
											required: null,
										},answer_3:{
											required: null,
										},answer_4:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/questions/create",
											data : $('#createData').serialize(),
											dataType : "json",
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
													//window.location.reload(true)
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
			$("#createData").validate({
				rules:{
					title:{
						required: true,
					},phase_level:{
						required: true,
					},module:{
						required: true,
					},
				},
				messages:{
					title:{
						required: null,
					},phase_level:{
						required: null,
					},module:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/questions/create",
						data : $('#createData').serialize(),
						dataType : "json",
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
								
								//window.location.reload(true)
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
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('change', '#phaseLevel', function(){
					var phase_level = $(this).val()
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/questions/get_list_modules",
						data:{phase_level:phase_level, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('#dependentModule').html(data.content);
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
				
				$(document).on('change', '#selectedModule', function(){
					var module = $(this).val()
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/questions/get_lessons",
						data:{module:module, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('#dependentLesson').html(data.content);
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
				
				$(document).on('change', '#selectedQuestionType', function(){
					var qtype = $(this).val();
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/questions/get_answer_type",
						data:{qtype:qtype, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('#answerQuestionType').html(data.content);
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
				
				
				$(document).on('click', '.view-qstion', function(){
					var question_id = $(this).attr('data-question');
					var q_type = $(this).attr('data-q-type');
					var q_exam_type = 'Lesson';
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/questions/view",
						data:{question_id:question_id, q_type:q_type, q_exam_type:q_exam_type, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('#viewCntAnswer').html(data.content);
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
			});
		</script>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var row = $('#answerDistribute .check-length').length + 1;
				$(document).on('click', '.more-ans-add', function(){
					var content = '<div class="form-group">' +
										'<label class="col-md-8 control-label"><strong>Stamp-'+row+' :</strong></label>' +
										'<div class="col-md-4">' +
											'<textarea name="answer_'+row+'" class="form-control" rows="3"></textarea>' +
											'<input type="hidden" name="answer_row[]" value="'+row+'" />' +
											'<span data-answer="'+row+'" class="rmv-row-mrksinp fa fa-times" style="position:absolute;right:-10px;top:0;"></span>' +
										'</div>' +
									'</div>';
					
					var content_two = '<label style="display:block" class="right-asnwer-'+row+'">' +
											'<input type="checkbox" name="right_answer_'+row+'" value="'+row+'" /> &nbsp;&nbsp;<strong class="ans-margin">Stamp-'+row+'</strong>' +
										'</label>';			
								
					$('#answerDistribute').append(content);
					$('#rightAnswerDistribute').append(content_two);
					row++;
				});
				
				//For multiple justify
				var rowTwo = $('#answerDistribute .check-length').length + 1;
				$(document).on('click', '.more-ans-add', function(){
					var content = '<div class="form-group">' +
										'<label class="col-md-8 control-label"><strong>Stamp-'+rowTwo+' :</strong></label>' +
										'<div class="col-md-4">' +
											'<textarea name="answer_'+rowTwo+'" class="form-control" rows="3"></textarea>' +
											'<input type="hidden" name="answer_row[]" value="'+rowTwo+'" />' +
											'<span data-answer="'+rowTwo+'" class="rmv-row-mrksinp fa fa-times" style="position:absolute;right:-10px;top:0;"></span>' +
										'</div>' +
									'</div>';
					
					var content_two = '<label style="display:block" class="right-asnwer-'+rowTwo+'">' +
											'<strong class="ans-margin">Stamp-'+rowTwo+'</strong> &nbsp;&nbsp;<label style="margin-right:10px;color:#0A0;"><input type="radio" name="right_answer_'+rowTwo+'" value="1" /> TRUE</label><label style="color:#F00"><input type="radio" name="right_answer_'+rowTwo+'" value="0" /> FALSE</label>'+
										'</label>';			
								
					$('#answerDistribute').append(content);
					$('#rightAnswerDistributeMultipleJustify').append(content_two);
					rowTwo++;
				});
				
				$(document).on('click', '.rmv-row-mrksinp', function(){
					var get_right_answer = $(this).attr('data-answer');
					$(this).parent().parent().remove();
					$('.right-asnwer-'+get_right_answer).remove();
				});
				
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				var row = $('#answerDistribute .check-length').length + 1;
				$(document).on('click', '.more-ans-add-blanks', function(){
					var content = '<div class="form-group">' +
										'<label class="col-md-8 control-label"><strong>Stamp-'+row+' :</strong></label>' +
										'<div class="col-md-4">' +
											'<textarea name="answer_'+row+'" class="form-control" rows="3"></textarea>' +
											'<input type="hidden" name="answer_row[]" value="'+row+'" />' +
											'<span data-answer="'+row+'" class="rmv-row-mrksinp-blanks fa fa-times" style="position:absolute;right:-10px;top:0;"></span>' +
										'</div>' +
									'</div>';
					
					var content_two = '<label style="display:block" class="right-asnwer-'+row+'">' +
											'<input type="checkbox" name="right_answer_'+row+'" value="'+row+'" /> &nbsp;&nbsp;<strong class="ans-margin">Stamp-'+row+'</strong>' +
											'&nbsp;&nbsp;&nbsp;&nbsp;<select class="custom-sel-style" name="right_answer_gapid_'+row+'">'+
												'<option value="" selected="selected">Select Blank</option>'+
												'<option value="1">a</option>'+
												'<option value="2">b</option>'+
												'<option value="3">c</option>'+
												'<option value="4">d</option>'+
												'<option value="5">e</option>'+
												'<option value="6">f</option>'+
												'<option value="7">g</option>'+
												'<option value="8">h</option>'+
												'<option value="9">i</option>'+
												'<option value="10">j</option>'+
											'</select>'+
										'</label>';			
								
					$('#answerDistribute').append(content);
					$('#rightAnswerDistribute').append(content_two);
					row++;
					
					$(document).on('click', '.rmv-row-mrksinp-blanks', function(){
						var get_right_answer = $(this).attr('data-answer');
						$(this).parent().parent().remove();
						$('.right-asnwer-'+get_right_answer).remove();
					});
				});
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.more-ans-edit', function(){
					var content_edit = '<div class="form-group">' +
										'<label class="col-md-8 control-label"><strong>Stamp-'+row_two+' :</strong></label>' +
										'<div class="col-md-4">' +
											'<textarea name="answer_'+row_two+'" class="form-control" rows="3"></textarea>' +
											'<input type="hidden" name="answer_row[]" value="'+row_two+'" />' +
											'<span data-answer="'+row_two+'" class="rmv-row-mrksinp fa fa-times" style="position:absolute;right:-10px;top:0;"></span>' +
										'</div>' +
									'</div>';
					
					var content_edit_two = '<label style="display:block" class="right-asnwer-'+row_two+'">' +
											'<input type="checkbox" name="right_answer_'+row_two+'" value="'+row_two+'" /> &nbsp;&nbsp;<strong>Stamp-'+row_two+'</strong>' +
										'</label>';			
								
					$('#answerDistributeEdit').append(content_edit);
					$('#rightAnswerDistributeEdit').append(content_edit_two);
					row_two++;
				});
				
				//For multiple justify
				$(document).on('click', '.more-ans-edit', function(){
					var content = '<div class="form-group">' +
										'<label class="col-md-8 control-label"><strong>Stamp-'+row_two+' :</strong></label>' +
										'<div class="col-md-4">' +
											'<textarea name="answer_'+row_two+'" class="form-control" rows="3"></textarea>' +
											'<input type="hidden" name="answer_row[]" value="'+row_two+'" />' +
											'<span data-answer="'+row_two+'" class="rmv-row-mrksinp fa fa-times" style="position:absolute;right:-10px;top:0;"></span>' +
										'</div>' +
									'</div>';
					
					var content_two = '<label style="display:block" class="right-asnwer-'+row_two+'">' +
											'<strong class="ans-margin">Stamp-'+row_two+'</strong> &nbsp;&nbsp;<label style="margin-right:10px;color:#0A0;"><input type="radio" name="right_answer_'+row_two+'" value="1" /> TRUE</label><label style="color:#F00"><input type="radio" name="right_answer_'+row_two+'" value="0" /> FALSE</label>'+
										'</label>';			
								
					$('#answerDistributeEdit').append(content);
					$('#rightAnswerDistributeEditMultipleJustify').append(content_two);
					row_two++;
				});
			});
		</script>
		<script type="text/javascript">
			$('#limit').change(function() {
				this.form.submit();
			});
			$('#sorting').change(function() {
				this.form.submit();
			});
			$('#pLevel').change(function() {
				this.form.submit();
			});
			$('#questionType').change(function() {
				this.form.submit();
			});
			$('#sortType').change(function() {
				this.form.submit();
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>