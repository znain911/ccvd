<h1>STEP 2: PERSONAL INFORMATION</h1>
<?php  
	$attr = array('id' => 'regStepTwoTeacher', 'class' => 'position-relative');
	echo form_open_multipart('', $attr);
?>
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
<div class="form-field-content">
	<input type="hidden" name="update" value="0" />
	<div id="messaging"></div>
	<div class="row reg-flow-input-mrg">
		<label for="" class="col-lg-12">Your Full Name</label>
		<div class="col-lg-4 form-group">
			<input type="text" name="first_name" class="form-control" placeholder="First name"/> 
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="middle_name" class="form-control" placeholder="Middle name"/>
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="last_name" class="form-control" placeholder="Last name"/>
		</div>
	</div>
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-4 form-group">
			<label for="">Birthday</label>
			<input type="text" id="datePicker" name="birthday" class="form-control" placeholder="yyyy-mm-dd"/> 
		</div>
		<div class="col-lg-4">
			<label for="">Gender</label>
			<div class="row gender-cl">
				<div class="col-lg-4 form-group">
					<div class="radio radio-primary">
						<label>
						  <input type="radio" name="gender" value="0" checked=""> Male 
						</label>
					</div>
				</div>
				<div class="col-lg-4 form-group">
					<div class="radio radio-primary">
						<label>
						  <input type="radio" name="gender" value="1"> Female 
						</label>
					</div>
				</div>
				<div class="col-lg-4 form-group">
					<div class="radio radio-primary">
						<label>
						  <input type="radio" name="gender" value="2"> Other 
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4 form-group sel-dropdown-mrgn">
			<label for="">Nationality</label>
			<select class="spoecial-aff-mostak" name="nationality">
				<?php 
					$get_countries = $this->Registration_model->get_all_countries();
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
			<input type="text" name="fms_name" class="form-control"/> 
		</div>
		<div class="col-lg-4 form-group">
			<label for="">National ID Card Number</label>
			<input type="text" name="national_id" class="form-control"/> 
		</div>
	</div>
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-12">
			<h3 class="form-middle-block-title">CONTACT INFORMATION</h3>
		</div>
		<!--
		<div class="col-lg-4 form-group">
			<label for="">Please provide a valid email address.</label>
			<input type="text" name="contact_email" class="form-control"/> 
		</div>
		-->
	</div>
	<div class="row reg-flow-input-mrg">
		<label for="" class="col-lg-12">Please provide us with your phone numbers:</label>
		<div class="col-lg-4 form-group">
			<input type="text" name="mobile" class="form-control" placeholder="Mobile"/> 
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="office" class="form-control" placeholder="Office"/>
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="home" class="form-control" placeholder="Home"/>
		</div>
	</div>
	<div class="row reg-flow-input-mrg address-textarea-reg">
		<div class="col-lg-4">
			<label for="">Current Address</label>
			<textarea name="current_address" class="form-control" rows="4"></textarea> 
		</div>
		<div class="col-lg-4">
			<label for="">Permanent Address</label>
			<textarea name="permanent_address" class="form-control" rows="4"></textarea>
		</div>
	</div>
</div>
<div class="form-submit-btn">
	<a style="float: left;cursor:pointer" class="wzrd-submitbtn wzrd-back-faculty" data-function="back_to_account" data-state="account">BACK TO STEP 1 <br /> <span>Account Information</span> <i class="fa fa-angle-left"></i></a>
	<button style="float: right;" type="submit" class="wzrd-submitbtn">CONTINUE TO STEP 3 <br /> <span>Academic Information</span> <i class="fa fa-angle-right"></i></button>
</div>
<div class="form-submit-btn">
	<a href="<?php echo site_url(); ?>" class="wzrd-submitbtn" style="background: #A00; float: right; width: auto ! important; padding: 20px; color: rgb(255, 255, 255);">CANCEL REGISTRATION</a>
</div>
<?php echo form_close(); ?>
<script src="<?php echo base_url('frontend/'); ?>assets/js/app.min.js"></script>