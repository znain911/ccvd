<h1>STEP 1: ACCOUNT (EDIT)</h1>
<?php  
	$attr = array('id' => 'regStepOneTeacher', 'class' => 'position-relative');
	echo form_open('', $attr);
	$account_info = $this->Registration_model->get_account_info($faculty_id); 
?>
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
<div class="form-field-content">
	<input type="hidden" name="update" value="1" />
	<fieldset>
		<div class="form-group row">
		  <div class="col-md-12">
			<div id="messaging"></div>
		  </div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Email</label>
		  <div class="col-md-4">
			<input type="text" name="email" class="form-control" value="<?php echo $account_info['teacher_email']; ?>" placeholder="Enter email"> </div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Password</label>
		  <div class="col-md-4 position-relative">
			<input type="password" name="password" value="<?php echo $this->session->userdata('wizard_p'); ?>" class="form-control" id="mainPass" placeholder="Enter password"> 
			<label class="pass-visibility-method"><input type="checkbox" onclick="displayMainPassword()"> Show password</label>
		  </div>
		</div>
		<div class="form-group row">
		  <label for="" class="col-md-2 control-label">Re-Password</label>
		  <div class="col-md-4 position-relative">
			<input type="password" name="re_password" value="<?php echo $this->session->userdata('wizard_p'); ?>" class="form-control" id="confirmPass" placeholder="Re-enter password"> 
			<label class="pass-visibility-method"><input type="checkbox" onclick="displayConfirmPassword()"> Show password</label>
		  </div>
		</div>
	</fieldset>
</div>
<div class="form-submit-btn">
	<a href="<?php echo site_url(); ?>" class="wzrd-submitbtn" style="background: #A00; float: left; width: auto ! important; padding: 20px; color: rgb(255, 255, 255);">CANCEL REGISTRATION</a>
	<button type="submit" style="float: right;" class="wzrd-submitbtn">CONTINUE TO STEP 2 <br /> <span>Personal Information</span> <i class="fa fa-angle-right"></i></button>
	<div style="clear:both;"></div>
</div>
<?php echo form_close(); ?>