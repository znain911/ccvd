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
				<li><a href="javascript:;">Exam & Marks Distribution</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Exam & Marks Distribution</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div class="form-cntnt">
							<h2 class="frm-title-ms">Exam & Marks Distribution</h2>
							<?php 
								$get_marksconfig = $this->Setup_model->get_marksconfig();
							?>
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
									<div class="col-md-offset-8 col-md-4 text-center">
										<div class="frm-legend"><span class="legend-label">CCA-1 Configuration</span></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Exam Time (in minutes)</label>
									<div class="col-md-4">
										<input type="text" name="exam_time" value="<?php echo $get_marksconfig['mrkconfig_exam_time']; ?>" placeholder="e.g. 30" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Exam Total Questions</label>
									<div class="col-md-4">
										<input type="text" name="exam_question_total" value="<?php echo $get_marksconfig['mrkconfig_exam_totalquestion']; ?>" placeholder="e.g. 50" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Question Mark /Per Question</label>
									<div class="col-md-4">
										<input type="text" name="question_mark" value="<?php echo $get_marksconfig['mrkconfig_question_mark']; ?>" placeholder="Enter Question Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Total Marks</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_exmtotal_mark']; ?>" name="exmtotal_mark" placeholder="Enter Total Marks" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Pass Mark</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_exmpass_mark']; ?>" name="exmpass_mark" placeholder="Enter Total Pass Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Question Type</label>
									<div class="col-md-4">
										<?php 
											$qs_array = array('MCQ' => 'MCQ', 'BLANK' => 'FILL IN THE BLANKS', 'JUSTIFY' => 'TRUE OR FALSE', 'MULTIPLE_JUSTIFY' => 'Multiple Justify');
											$pca_one_q_type = json_decode($get_marksconfig['mrkconfig_question_type'], true);
										?>
										<?php foreach($qs_array as $key => $value): ?>
										<label><input type="checkbox" name="question_type[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $pca_one_q_type))? 'checked' : null; ?> />&nbsp; <?php echo $value; ?> &nbsp;&nbsp;</label>
										<?php endforeach; ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 Exam Active</label>
									<div class="col-md-4">
										<label><input type="checkbox" name="mrkconfig_exam_active" value="1" <?php if($get_marksconfig['mrkconfig_exam_active'] == 1){ echo 'checked'; }  ?>  />&nbsp; Active &nbsp;&nbsp;</label>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-8 control-label">CCA-1 exam start time (After)</label>
									<div class="col-md-4">
										<?php 
											$days_array = array(
															'1 days' => '1 day',
															'2 days' => '2 days',
															'3 days' => '3 days',
															'4 days' => '4 days',
															'5 days' => '5 days',
															'6 days' => '6 days',
															'7 days' => '7 days',
															'8 days' => '8 days',
															'9 days' => '9 days',
															'10 days' => '10 days',
															'11 days' => '11 days',
															'12 days' => '12 days',
															'13 days' => '13 days',
															'14 days' => '14 days',
															'15 days' => '15 days',
															'16 days' => '16 days',
															'17 days' => '17 days',
															'18 days' => '18 days',
															'19 days' => '19 days',
															'20 days' => '20 days',
															'21 days' => '21 days',
															'22 days' => '22 days',
															'23 days' => '23 days',
															'24 days' => '24 days',
															'25 days' => '25 days',
															'26 days' => '26 days',
															'27 days' => '27 days',
															'28 days' => '28 days',
															'29 days' => '29 days',
															'30 days' => '30 days',
														);
										?>
										<select name="exam_date" class="form-control">
											<?php foreach($days_array as $key => $value): ?>
											<option value="<?php echo $key; ?>" <?php echo ($get_marksconfig['mrkconfig_exam_date'] == $key)? 'selected' : null; ?>><?php echo $value; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-8 col-md-4 text-center">
										<div class="frm-legend"><span class="legend-label">CCA-2 Configuration</span></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 Exam Time (in minutes)</label>
									<div class="col-md-4">
										<input type="text" name="pcatwo_exam_time" value="<?php echo $get_marksconfig['mrkconfig_pcatwo_exam_time']; ?>" placeholder="e.g. 30" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 Exam Total Questions</label>
									<div class="col-md-4">
										<input type="text" name="pcatwo_exam_question_total" value="<?php echo $get_marksconfig['mrkconfig_pcatwo_exam_totalquestion']; ?>" placeholder="e.g. 50" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 Question Mark /Per Question</label>
									<div class="col-md-4">
										<input type="text" name="pcatwo_question_mark" value="<?php echo $get_marksconfig['mrkconfig_pcatwo_question_mark']; ?>" placeholder="Enter Question Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 Total Marks</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_pcatwo_exmtotal_mark']; ?>" name="pcatwo_exmtotal_mark" placeholder="Enter Total Pass Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 Pass Mark</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_pcatwo_exmpass_mark']; ?>" name="pcatwo_exmpass_mark" placeholder="Enter Pass Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 Question Type</label>
									<div class="col-md-4">
										<?php 
											$qs_array = array('MCQ' => 'MCQ', 'BLANK' => 'FILL IN THE BLANKS', 'JUSTIFY' => 'TRUE OR FALSE', 'MULTIPLE_JUSTIFY' => 'Multiple Justify');
											$pca_two_q_type = json_decode($get_marksconfig['mrkconfig_pcatwo_question_type'], true);
										?>
										<?php foreach($qs_array as $key => $value): ?>
										<label><input type="checkbox" name="pcatwo_question_type[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $pca_two_q_type))? 'checked' : null; ?> />&nbsp; <?php echo $value; ?> &nbsp;&nbsp;</label>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-2 exam start time (After)</label>
									<div class="col-md-4">
										<?php 
											$days_array = array(
															'1 days' => '1 day',
															'2 days' => '2 days',
															'3 days' => '3 days',
															'4 days' => '4 days',
															'5 days' => '5 days',
															'6 days' => '6 days',
															'7 days' => '7 days',
															'8 days' => '8 days',
															'9 days' => '9 days',
															'10 days' => '10 days',
															'11 days' => '11 days',
															'12 days' => '12 days',
															'13 days' => '13 days',
															'14 days' => '14 days',
															'15 days' => '15 days',
															'16 days' => '16 days',
															'17 days' => '17 days',
															'18 days' => '18 days',
															'19 days' => '19 days',
															'20 days' => '20 days',
															'21 days' => '21 days',
															'22 days' => '22 days',
															'23 days' => '23 days',
															'24 days' => '24 days',
															'25 days' => '25 days',
															'26 days' => '26 days',
															'27 days' => '27 days',
															'28 days' => '28 days',
															'29 days' => '29 days',
															'30 days' => '30 days',
														);
										?>
										<select name="pcatwo_exam_date" class="form-control">
											<?php foreach($days_array as $key => $value): ?>
											<option value="<?php echo $key; ?>" <?php echo ($get_marksconfig['mrkconfig_pcatwo_exam_date'] == $key)? 'selected' : null; ?>><?php echo $value; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-8 col-md-4 text-center">
										<div class="frm-legend"><span class="legend-label">CCA-3 Configuration</span></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 Exam Time (in minutes)</label>
									<div class="col-md-4">
										<input type="text" name="pcathree_exam_time" value="<?php echo $get_marksconfig['mrkconfig_pcathree_exam_time']; ?>" placeholder="e.g. 30" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 Exam Total Questions</label>
									<div class="col-md-4">
										<input type="text" name="pcathree_exam_question_total" value="<?php echo $get_marksconfig['mrkconfig_pcathree_exam_totalquestion']; ?>" placeholder="e.g. 50" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 Question Mark /Per Question</label>
									<div class="col-md-4">
										<input type="text" name="pcathree_question_mark" value="<?php echo $get_marksconfig['mrkconfig_pcathree_question_mark']; ?>" placeholder="Enter Question Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 Total Mark</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_pcathree_exmtotal_mark']; ?>" name="pcathree_exmtotal_mark" placeholder="Enter Total Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 Pass Mark</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_pcathree_exmpass_mark']; ?>" name="pcathree_exmpass_mark" placeholder="Enter Pass Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 Question Type</label>
									<div class="col-md-4">
										<?php 
											$qs_array = array('MCQ' => 'MCQ', 'BLANK' => 'FILL IN THE BLANKS', 'JUSTIFY' => 'TRUE OR FALSE', 'MULTIPLE_JUSTIFY' => 'Multiple Justify');
											$pca_three_q_type = json_decode($get_marksconfig['mrkconfig_pcathree_question_type'], true);
										?>
										<?php foreach($qs_array as $key => $value): ?>
										<label><input type="checkbox" name="pcathree_question_type[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $pca_three_q_type))? 'checked' : null; ?> />&nbsp; <?php echo $value; ?> &nbsp;&nbsp;</label>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">CCA-3 exam start time (After)</label>
									<div class="col-md-4">
										<?php 
											$days_array = array(
															'1 days' => '1 day',
															'2 days' => '2 days',
															'3 days' => '3 days',
															'4 days' => '4 days',
															'5 days' => '5 days',
															'6 days' => '6 days',
															'7 days' => '7 days',
															'8 days' => '8 days',
															'9 days' => '9 days',
															'10 days' => '10 days',
															'11 days' => '11 days',
															'12 days' => '12 days',
															'13 days' => '13 days',
															'14 days' => '14 days',
															'15 days' => '15 days',
															'16 days' => '16 days',
															'17 days' => '17 days',
															'18 days' => '18 days',
															'19 days' => '19 days',
															'20 days' => '20 days',
															'21 days' => '21 days',
															'22 days' => '22 days',
															'23 days' => '23 days',
															'24 days' => '24 days',
															'25 days' => '25 days',
															'26 days' => '26 days',
															'27 days' => '27 days',
															'28 days' => '28 days',
															'29 days' => '29 days',
															'30 days' => '30 days',
														);
										?>
										<select name="pcathree_exam_date" class="form-control">
											<?php foreach($days_array as $key => $value): ?>
											<option value="<?php echo $key; ?>" <?php echo ($get_marksconfig['mrkconfig_pcathree_exam_date'] == $key)? 'selected' : null; ?>><?php echo $value; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<!-------------practice based exam------------------->
								<div class="form-group">
									<div class="col-md-offset-8 col-md-4 text-center">
										<div class="frm-legend"><span class="legend-label">Practice Based Configuration</span></div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-8 control-label">Practice Exam Time (in minutes)</label>
									<div class="col-md-4">
										<input type="text" name="practice_exam_time" value="<?php echo $get_marksconfig['mrkconfig_practice_exam_time']; ?>" placeholder="e.g. 30" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Practice Exam Total Questions</label>
									<div class="col-md-4">
										<input type="text" name="practice_exam_question_total" value="<?php echo $get_marksconfig['mrkconfig_practice_exam_totalquestion']; ?>" placeholder="e.g. 50" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Practice Question Mark /Per Question</label>
									<div class="col-md-4">
										<input type="text" name="practice_question_mark" value="<?php echo $get_marksconfig['mrkconfig_practice_question_mark']; ?>" placeholder="Enter Question Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Practice Total Mark</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_practice_exmtotal_mark']; ?>" name="practice_exmtotal_mark" placeholder="Enter Total Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Practice Pass Mark</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_marksconfig['mrkconfig_practice_exmpass_mark']; ?>" name="practice_exmpass_mark" placeholder="Enter Pass Mark" class="form-control">
									</div>
								</div>
							
								<div class="form-group">
									<label class="col-md-8 control-label">Practice Based Question Type</label>
									<div class="col-md-4">
										<?php 
											$qs_array = array('MCQ' => 'MCQ', 'BLANK' => 'FILL IN THE BLANKS', 'JUSTIFY' => 'TRUE OR FALSE', 'MULTIPLE_JUSTIFY' => 'Multiple Justify');
											$practice_based_q_type = json_decode($get_marksconfig['mrkconfig_practice_question_type'], true);
										?>
										<?php foreach($qs_array as $key => $value): ?>
			
										<label><input type="checkbox" name="practice_question_type[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $practice_based_q_type))? 'checked' : null; ?> />&nbsp; <?php echo $value; ?> &nbsp;&nbsp;</label>
										<?php endforeach; ?>
									</div>
								
								</div>
								<!------------- End practice based exam------------------->
								<div class="form-group">
									<div class="col-md-offset-8 col-md-4 text-center">
										<div class="frm-legend"><span class="legend-label">ECE Exam Configuration</span></div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-8 control-label">ECE Exam Time (in minutes)</label>
									<div class="col-md-4">
										<input type="text" name="ece_exam_time" value="<?php echo $get_marksconfig['mrkconfig_ece_exam_time']; ?>" placeholder="e.g. 30" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">ECE Exam Total Questions</label>
									<div class="col-md-4">
										<input type="text" name="ece_exam_question_total" value="<?php echo $get_marksconfig['mrkconfig_ece_exam_totalquestion']; ?>" placeholder="e.g. 50" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">ECE Question Mark /Per Question</label>
									<div class="col-md-4">
										<input type="text" name="ece_question_mark"  value="<?php echo $get_marksconfig['mrkconfig_ece_question_mark']; ?>" placeholder="Enter Question Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">ECE Total Marks</label>
									<div class="col-md-4">
										<input type="text"  name="ece_exmtotal_mark"  value="<?php echo $get_marksconfig['mrkconfig_ece_exmtotal_mark']; ?>"placeholder="Enter Total Marks" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">ECE Pass Mark</label>
									<div class="col-md-4">
										<input type="text"  name="ece_exmpass_mark"value="<?php echo $get_marksconfig['mrkconfig_ece_exmpass_mark']; ?>"  placeholder="Enter Total Pass Mark" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">ECE Question Type</label>
									<div class="col-md-4">
										<?php 
											$qs_array = array('MCQ' => 'MCQ', 'BLANK' => 'FILL IN THE BLANKS', 'JUSTIFY' => 'TRUE OR FALSE', 'MULTIPLE_JUSTIFY' => 'Multiple Justify');
					
											 $ece_q_type = json_decode($get_marksconfig['mrkconfig_ece_question_type'], true);
										?>
										<?php foreach($qs_array as $key => $value): ?>
										<label><input type="checkbox" name="ece_question_type[]" value="<?php echo $key; ?>"  <?php echo (in_array($key, $ece_q_type))? 'checked' : null; ?> />&nbsp; <?php echo $value; ?> &nbsp;&nbsp;</label>
										<?php endforeach; ?>
									</div>
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
				rules:{
					question_mark:{
						required: true,
						number:true,
					},
					exmpass_mark:{
						required: true,
						number:true,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/setup/update_marksconfig",
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
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>