<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div class="edit-info-cntr">
					<div class="result-table">
						<p class="result-tbl-head"><strong>Professional Information</strong></p>
						<?php  
							$attr = array('id' => 'updateStudentProfessionalinfo', 'class' => 'position-relative');
							echo form_open_multipart('', $attr);
							$professional_info = $this->Student_model->get_professional_info();
						?>
						<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
						<div class="form-field-content">
							<div id="alert"></div>
							<div class="row reg-flow-input-mrg">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="">Designation</label>
										<input type="text" name="designation" value="<?php echo $professional_info['spsinfo_designation']; ?>" class="form-control" placeholder="Your title"/>
									</div>
									
									<div class="form-group">
									<label for="">Organization <br /> <span>(comma separate for more than one)</span></label>
									<input type="text" name="organization" value="<?php echo $professional_info['spsinfo_organization']; ?>" class="form-control" placeholder="Your title"/>
									</div>
									
									<div class="address-textarea-reg">
										<label for="">Address of organization</label>
										<textarea name="organization_address" class="form-control" rows="4"><?php echo $professional_info['spsinfo_organization_address']; ?></textarea>
									</div>
								</div>
								<div class="col-lg-8">
									<h2 class="specialization-lists-title">Specialization</h2>
									<div class="specialization-titles">
										<?php 
											$get_all_specializations = $this->Student_model->get_all_specializations();
											$get_student_spclz = $this->Student_model->get_specializations();
											$specialize_array = array();
											foreach($get_student_spclz as $spclz):
												$specialize_array[] = $spclz['ss_specilzation_id'];
											endforeach;
										?>
										<div class="specialization-part-object">
											<?php
												$count = 1;
												foreach($get_all_specializations as $specialization):
											?>
											<div class="checkbox"><label><input type="checkbox" name="specialization[]" value="<?php echo $specialization['specialize_id']; ?>" <?php echo (in_array($specialization['specialize_id'], $specialize_array))? 'checked' : null; ?> /> <?php echo $specialization['specialize_name']; ?> </label></div>
											<?php if($count == 12): ?>
											</div>
											<div class="specialization-part-object">
											<?php endif; ?>
											<?php 
												$count++;
												endforeach; 
											?>
											<div class="checkbox"><label class="sel-chk"><input class="other-chk" type="checkbox" name="specialization[]" value="Other"/> Other </label></div>
											<div id="otherField"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<div class="col-lg-4 form-group">
									<label for="">BM&DC Number</label>
									<input type="text" name="bmanddc_number" class="form-control" value="<?php echo $professional_info['spsinfo_bmanddc_number']; ?>" placeholder="Enter number here"/>
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<label for="" class="col-lg-12">DLP Category</label>
								<div class="col-lg-12">
									<?php 
										$dlp_categories = $this->Student_model->get_all_dlp_categories();
										$student_dlp_cats = $this->Student_model->get_dlp_categories();
										$dlp_catsarray = array();
										foreach($student_dlp_cats as $cats):
											$dlp_catsarray[] = $cats['sdc_category_id'];
										endforeach;
									?>
									<div class="checkbox dlp-cats">
										<?php foreach($dlp_categories as $category): ?>
										<label><input type="checkbox" value="<?php echo $category['category_id']; ?>" name="dlp_category[]" <?php echo (in_array($category['category_id'], $dlp_catsarray))? 'checked' : null; ?> /> <?php echo $category['category_name']; ?> </label>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<div class="col-lg-12">
									<br />
									<p class="result-tbl-head"><strong>Selection Criteria</strong></p>
									<br />
								</div>
								<div class="col-lg-12">
									<div class="row">
										<div class="sel-criteria block">
											<label for="" class="col-lg-12">Types of practice?</label>
											<div class="radio radio-primary dlp-cats">
												<label><input type="radio" name="practice_type" value="GP" <?php echo ($professional_info['spsinfo_typeof_practice'] == 'GP')? 'checked' : null; ?> /> GP </label>
												<label><input type="radio" name="practice_type" value="SP" <?php echo ($professional_info['spsinfo_typeof_practice'] == 'SP')? 'checked' : null; ?> /> SP </label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-12">
									<div class="row">
										<div class="sel-criteria block">
											<label for="" class="col-lg-12">Years since passing MBBS?</label>
											<div class="radio radio-primary dlp-cats">
												<label><input type="radio" name="years_since" value="0-1 Year" <?php echo ($professional_info['spsinfo_sinceyear_mbbs'] == '0-1 Year')? 'checked' : null; ?> /> 0-1 Year </label>
												<label><input type="radio" name="years_since" value="0-5 Years" <?php echo ($professional_info['spsinfo_sinceyear_mbbs'] == '0-5 Years')? 'checked' : null; ?> /> 0-5 Years </label>
												<label><input type="radio" name="years_since" value="5-10 Years" <?php echo ($professional_info['spsinfo_sinceyear_mbbs'] == '5-10 Years')? 'checked' : null; ?> /> 5-10 Years </label>
												<label><input type="radio" name="years_since" value="More than 10 Year" <?php echo ($professional_info['spsinfo_sinceyear_mbbs'] == 'More than 10 Year')? 'checked' : null; ?> /> More than 10 Year </label>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg-12">
									<div class="row">
										<div class="sel-criteria block">
											<label for="" class="col-lg-12">Years of experience?</label>
											<div class="radio radio-primary dlp-cats">
												<label><input type="radio" name="years_experience" value="0-1 Year" <?php echo ($professional_info['spsinfo_experience'] == '0-1 Year')? 'checked' : null; ?> /> 0-1 Year </label>
												<label><input type="radio" name="years_experience" value="0-5 Years" <?php echo ($professional_info['spsinfo_experience'] == '0-5 Years')? 'checked' : null; ?> /> 0-5 Years </label>
												<label><input type="radio" name="years_experience" value="5-10 Years" <?php echo ($professional_info['spsinfo_experience'] == '5-10 Years')? 'checked' : null; ?> /> 5-10 Years </label>
												<label><input type="radio" name="years_experience" value="More than 10 Year" <?php echo ($professional_info['spsinfo_experience'] == 'More than 10 Year')? 'checked' : null; ?> /> More than 10 Year </label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-submit-btn">
							<a style="float: left;background:#f0f0f0;" href="<?php echo base_url('student/profile'); ?>" class="btn btn-danger">CANCEL</a>
							<button style="float: right;background:#f0f0f0;" type="submit" class="btn btn-danger">UPDATE INFORMATION</button>
						</div>
						<?php echo form_close(); ?>
						
						<script src="<?php echo base_url('frontend/'); ?>assets/js/app.min.js"></script>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			//start step 2
			$("#updateStudentProfessionalinfo").validate({
				rules:{
					designation:{
						required: true,
					},
				},
				submitHandler : function () {
					$('#proccessLoader').show();
					var personalFormData = new FormData(document.getElementById('updateStudentProfessionalinfo'));    
					$.ajax({
						type : "POST",
						url : baseUrl + "student/update_professional_info",
						data : personalFormData,
						dataType : "json",
						cache: false,
						contentType: false,
						processData: false,
						success : function (data) {
							if(data.status == 'ok')
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								$('#alert').html(data.success);	
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
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>