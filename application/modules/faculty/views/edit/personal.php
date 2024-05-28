<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div class="edit-info-cntr">
					<div class="result-table">
						<p class="result-tbl-head"><strong>Personal Information</strong></p>
						<?php  
							$attr = array('id' => 'updateTeacherPersonalinfo', 'class' => 'position-relative');
							echo form_open_multipart('', $attr);
							$personal_info = $this->Teacher_model->get_personal_info();
						?>
						<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
						<div class="form-field-content">
							<div id="alert"></div>
							<div class="row reg-flow-input-mrg">
								<label for="" class="col-lg-12">Your Full Name</label>
								<div class="col-lg-4 form-group">
									<input type="text" name="first_name" value="<?php echo $personal_info['tpinfo_first_name']; ?>" class="form-control" placeholder="First name"/> 
								</div>
								<div class="col-lg-4 form-group">
									<input type="text" name="middle_name" value="<?php echo $personal_info['tpinfo_middle_name']; ?>" class="form-control" placeholder="Middle name"/>
								</div>
								<div class="col-lg-4 form-group">
									<input type="text" name="last_name" value="<?php echo $personal_info['tpinfo_last_name']; ?>" class="form-control" placeholder="Last name"/>
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<div class="col-lg-4 form-group">
									<label for="">Date Of Birth</label>
									<input type="text" id="datePicker" name="birthday" value="<?php echo $personal_info['tpinfo_birth_date']; ?>" class="form-control" placeholder="Birth date"/> 
								</div>
								<div class="col-lg-4">
									<label for="">Gender</label>
									<div class="row gender-cl">
										<div class="col-lg-4 form-group">
											<div class="radio radio-primary">
												<label>
												  <input type="radio" name="gender" value="0" <?php echo ($personal_info['tpinfo_gender'] == '0')? 'checked' : null; ?>> &nbsp; Male 
												</label>
											</div>
										</div>
										<div class="col-lg-4 form-group">
											<div class="radio radio-primary">
												<label>
												  <input type="radio" name="gender" value="1" <?php echo ($personal_info['tpinfo_gender'] == '1')? 'checked' : null; ?>> &nbsp; Female 
												</label>
											</div>
										</div>
										<div class="col-lg-4 form-group">
											<div class="radio radio-primary">
												<label>
												  <input type="radio" name="gender" value="2" <?php echo ($personal_info['tpinfo_gender'] == '2')? 'checked' : null; ?>> &nbsp; Other 
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-4 form-group sel-dropdown-mrgn">
									<label for="">Nationality</label>
									<select class="spoecial-aff-mostak" name="nationality">
										<?php 
											$get_countries = $this->Teacher_model->get_all_countries();
											foreach($get_countries as $country){
										?>
										<option value="<?php echo $country['country_id']; ?>" <?php echo ($country['country_id'] == 18)? 'selected' : null; ?>><?php echo $country['country_name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<div class="col-lg-4">
									<label for="">Upload a recent photo</label>
									<div class="form-group">
										<?php if($personal_info['tpinfo_photo']): ?>
										  <div class="old-img"><img src="<?php echo attachment_url('faculties/'.$personal_info['teacher_entryid'].'/'.$personal_info['tpinfo_photo']); ?>" style="height:50px;width:65px" alt="Recent Photo" /></div>
										<?php endif; ?>
										<input type="file" name="recent_photo">
										<div class="input-group">
										  <input type="text" readonly="" class="form-control" placeholder="Upload Photo">
										  <span class="input-group-btn input-group-sm">
											<button type="button" class="btn btn-fab btn-fab-mini">
											  <i class="material-icons">attach_file</i>
											</button>
										  </span>
										</div>
									</div>
								</div>
								<div class="col-lg-4 form-group">
									<label for="">Father's/Mother's/Spouse's Name</label>
									<input type="text" name="fms_name" value="<?php echo $personal_info['tpinfo_fmorspouse_name']; ?>" class="form-control"/> 
								</div>
								<div class="col-lg-4 form-group">
									<label for="">National ID Card Number</label>
									<input type="text" name="national_id" value="<?php echo $personal_info['tpinfo_national_id']; ?>" class="form-control"/> 
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<div class="col-lg-12">
									<p class="result-tbl-head"><strong>Contact Information</strong></p>
								</div>
								<div class="col-lg-4 form-group">
									<label for="">Please provide a valid email address.</label>
									<input type="text" name="contact_email" value="<?php echo $personal_info['tpinfo_email']; ?>" class="form-control"/> 
								</div>
							</div>
							<div class="row reg-flow-input-mrg">
								<label for="" class="col-lg-12">Please provide us with your phone numbers:</label>
								<div class="col-lg-4 form-group">
									<input type="text" name="mobile" value="<?php echo $personal_info['tpinfo_personal_phone']; ?>" class="form-control" placeholder="Mobile"/> 
								</div>
								<div class="col-lg-4 form-group">
									<input type="text" name="office" value="<?php echo $personal_info['tpinfo_office_phone']; ?>" class="form-control" placeholder="Office"/>
								</div>
								<div class="col-lg-4 form-group">
									<input type="text" name="home" value="<?php echo $personal_info['tpinfo_home_phone']; ?>" class="form-control" placeholder="Home"/>
								</div>
							</div>
							<div class="row reg-flow-input-mrg address-textarea-reg">
								<div class="col-lg-4">
									<label for="">Current Address</label>
									<textarea name="current_address" class="form-control" rows="4"><?php echo $personal_info['tpinfo_current_address']; ?></textarea> 
								</div>
								<div class="col-lg-4">
									<label for="">Permanent Address</label>
									<textarea name="permanent_address" class="form-control" rows="4"><?php echo $personal_info['tpinfo_permanent_address']; ?></textarea>
								</div>
							</div>
						</div>
						<div class="form-submit-btn">
							<a style="float: left;background:#f0f0f0;" href="<?php echo base_url('faculty/profile'); ?>" class="btn btn-danger">CANCEL</a>
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
			$("#updateTeacherPersonalinfo").validate({
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
					var personalFormData = new FormData(document.getElementById('updateTeacherPersonalinfo'));    
					$.ajax({
						type : "POST",
						url : baseUrl + "faculty/update_personal_info",
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