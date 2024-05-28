<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Setup</a></li>
				<li><a href="javascript:;">Students Evaluations Settings</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Students Evaluations Settings</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div class="form-cntnt">
							<h2 class="frm-title-ms">Students Evaluations Settings</h2>
							<?php 
								$attr = array('class' => 'form-horizontal', 'id' => 'configData');
								echo form_open('#', $attr);
							?>
								<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
								<div class="form-group">
									<div class="col-md-offset-6 col-md-6">
										<div id="alert"></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-12 text-center evaluation-title-lbl">
										<div class="frm-legend"><span class="legend-label">Rating Distribution</span></div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-2 text-center"><strong>EVALUATION TYPE</strong></div>
									<div class="col-md-1 text-center">
										<strong>Rating Type</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating Type</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating Type</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating Type</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating Type</strong>
									</div>
									<div class="col-md-1 text-center">
										<strong>Rating</strong>
									</div>
								</div>
								<div id="marksDistribute">
									<?php 
										$get_labels = $this->Setup_model->get_all_labels();
										$ev_count = 1;
										if(count($get_labels) !== 0):
										foreach($get_labels as $label):
									?>
									<div>
										<div class="form-group count-row">
											<div class="col-md-2"><input type="text" name="marks_label_<?php echo $ev_count; ?>" value="<?php echo $label['eval_label']; ?>" class="form-control" /></div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_type_one']; ?>" type="text" name="marks_rating_type_1_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_one']; ?>" type="text" name="marks_rating_1_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_type_two']; ?>" type="text" name="marks_rating_type_2_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_two']; ?>" type="text" name="marks_rating_2_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_type_three']; ?>" type="text" name="marks_rating_type_3_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_three']; ?>" type="text" name="marks_rating_3_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_type_four']; ?>" type="text" name="marks_rating_type_4_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_four']; ?>" type="text" name="marks_rating_4_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input value="<?php echo $label['eval_rating_type_five']; ?>" type="text" name="marks_rating_type_5_<?php echo $ev_count; ?>" class="form-control" />
											</div>
											<div class="col-md-1 text-center relate-add-sign">
												<input value="<?php echo $label['eval_rating_five']; ?>" type="text" name="marks_rating_5_<?php echo $ev_count; ?>" class="form-control" />
												<?php if($ev_count == 1): ?>
												<span class="add-more-mrksinp fa fa-plus-square"></span>
												<?php else: ?>
												<span class="rmv-row-mrksinp fa fa-times"></span>
												<?php endif; ?>
												<input type="hidden" name="rownumber[]" value="<?php echo $ev_count; ?>" />
											</div>
										</div>
									</div>
									<?php 
										$ev_count++;
										endforeach; 
									?>
									<?php else: ?>
									<div>
										<div class="form-group count-row">
											<div class="col-md-2"><input type="text" name="marks_label_1" class="form-control" /></div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_type_1_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_1_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_type_2_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_2_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_type_3_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_3_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_type_4_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_4_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center">
												<input type="text" name="marks_rating_type_5_1" class="form-control" />
											</div>
											<div class="col-md-1 text-center relate-add-sign">
												<input type="text" name="marks_rating_5_1" class="form-control" />
												<span data-count="2" class="add-more-mrksinp fa fa-plus-square"></span>
												<input type="hidden" name="rownumber[]" value="1" />
											</div>
										</div>
									</div>
									<?php endif; ?>
								</div>
								<div class="generate-buttons text-right">
									<button class="btn btn-purple m-b-5" type="submit">Update Configuration</button>
								</div>
							<?php echo form_close(); ?>
						</div>
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
			$("#configData").validate({
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/setup/update_evaluations",
						data : $('#configData').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#alert').html(data.success);
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
				var row = document.querySelectorAll('.count-row').length + 1;
				$(document).on('click', '.add-more-mrksinp', function(){
					var content = '<div>'+
										'<div class="form-group count-row">'+
											'<div class="col-md-2"><input type="text" name="marks_label_'+row+'" class="form-control" /></div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_type_1_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_1_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_type_2_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_2_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_type_3_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_3_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_type_4_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_4_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center">'+
												'<input type="text" name="marks_rating_type_5_'+row+'" class="form-control" />'+
											'</div>'+
											'<div class="col-md-1 text-center relate-add-sign">'+
												'<input type="text" name="marks_rating_5_'+row+'" class="form-control" />'+
												'<span class="rmv-row-mrksinp fa fa-times"></span>'+
												'<input type="hidden" name="rownumber[]" value="'+row+'" />'+
											'</div>'+
										'</div>'+
									'</div>';
					$('#marksDistribute').append(content);
					row++;
				});
				
				$(document).on('click', '.rmv-row-mrksinp', function(){
					$(this).parent().parent().parent().remove();
				});
				
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>