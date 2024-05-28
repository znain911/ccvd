<h1>STEP 2: PERSONAL INFORMATION (EDIT)</h1>
<?php  
	$attr = array('id' => 'regStepTwoStudent', 'class' => 'position-relative');
	echo form_open_multipart('', $attr);
	$personal_info = $this->Registration_model->get_personal_info($student_id);
?>
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
<div class="form-field-content">
	<input type="hidden" name="update" value="1" />
	<div class="row reg-flow-input-mrg">
		<label for="" class="col-lg-12">Your Full Name</label>
		<div class="col-lg-4 form-group">
			<input type="text" name="first_name" value="<?php echo $personal_info['spinfo_first_name']; ?>" class="form-control" placeholder="First name"/> 
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="middle_name" value="<?php echo $personal_info['spinfo_middle_name']; ?>" class="form-control" placeholder="Middle name"/>
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="last_name" value="<?php echo $personal_info['spinfo_last_name']; ?>" class="form-control" placeholder="Last name"/>
		</div>
	</div>
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-4 form-group">
			<label for="">Date Of Birth</label>
			<input type="text" id="datePicker" name="birthday" value="<?php echo $personal_info['spinfo_birth_date']; ?>" class="form-control" placeholder="Birth date"/> 
		</div>
		<div class="col-lg-4">
			<label for="">Gender</label>
			<div class="row gender-cl">
				<div class="col-lg-4 form-group">
					<div class="radio radio-primary">
						<label>
						  <input type="radio" name="gender" value="0" <?php echo ($personal_info['spinfo_gender'] == '0')? 'checked' : null; ?>> &nbsp; Male 
						</label>
					</div>
				</div>
				<div class="col-lg-4 form-group">
					<div class="radio radio-primary">
						<label>
						  <input type="radio" name="gender" value="1" <?php echo ($personal_info['spinfo_gender'] == '1')? 'checked' : null; ?>> &nbsp; Female 
						</label>
					</div>
				</div>
				<div class="col-lg-4 form-group">
					<div class="radio radio-primary">
						<label>
						  <input type="radio" name="gender" value="2" <?php echo ($personal_info['spinfo_gender'] == '2')? 'checked' : null; ?>> &nbsp; Other 
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
				<?php if($personal_info['spinfo_photo']): ?>
				  <div class="old-img"><img src="<?php echo attachment_url('students/'.$this->session->userdata('wizard_username').'/'.$personal_info['spinfo_photo']); ?>" style="height:50px;width:65px" alt="Recent Photo" /></div>
				<?php endif; ?>
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
			<label for="">Father's Name</label>
			<input type="text" name="father_name" value="<?php echo $personal_info['spinfo_father_name']; ?>" class="form-control"/> 
		</div>
		<div class="col-lg-4 form-group">
			<label for="">Mother's Name</label>
			<input type="text" name="mother_name" value="<?php echo $personal_info['spinfo_mother_name']; ?>" class="form-control"/> 
		</div>
		<div class="col-lg-4 form-group">
			<label for="">Spouse's Name</label>
			<input type="text" name="fms_name" value="<?php echo $personal_info['spinfo_fmorspouse_name']; ?>" class="form-control"/> 
		</div>
		<div class="col-lg-4 form-group">
			<label for="">National ID Card Number</label>
			<input type="text" name="national_id" value="<?php echo $personal_info['spinfo_national_id']; ?>" class="form-control"/> 
		</div>
	</div>
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-12">
			<h3 class="form-middle-block-title">CONTACT INFORMATION</h3>
		</div>
		<!--
		<div class="col-lg-4 form-group">
			<label for="">Please provide a valid email address.</label>
			<input type="text" name="contact_email" value="<?php echo $personal_info['spinfo_email']; ?>" class="form-control"/> 
		</div>
		-->
	</div>
	<div class="row reg-flow-input-mrg">
		<label for="" class="col-lg-12">Please provide us with your phone numbers:</label>
		<div class="col-lg-4 form-group">
			<input type="text" name="mobile" value="<?php echo $personal_info['spinfo_personal_phone']; ?>" class="form-control" placeholder="Mobile"/> 
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="office" value="<?php echo $personal_info['spinfo_office_phone']; ?>" class="form-control" placeholder="Office"/>
		</div>
		<div class="col-lg-4 form-group">
			<input type="text" name="home" value="<?php echo $personal_info['spinfo_home_phone']; ?>" class="form-control" placeholder="Home"/>
		</div>
	</div>
	<div class="row reg-flow-input-mrg address-textarea-reg">
		<div class="col-lg-4 form-group sel-dropdown-mrgn">
			<label for="">Current Division</label>
			<select name="current_division" id="current_division" class="spoecial-aff-mostak">
				<option value="">Select Current Division</option>
				<?php $divisionlist = $this->Registration_model->division_list(); 
				foreach ($divisionlist as $dvsnlist) {?>
					<option value="<?php echo $dvsnlist->id;?>"><?php echo $dvsnlist->name;?></option>
				<?php }?>
			</select>
		</div>
		<div class="col-lg-4 form-group sel-dropdown-mrgn">
			<label for="">Current District</label>
			<select name="current_district" id="current_district" class="spoecial-aff-mostak">
				<option value="">Select Current District</option>
			</select>
		</div>
		<div class="col-lg-4">
			<label for="">Current Address</label>
			<textarea name="current_address" class="form-control" rows="4"><?php echo $personal_info['spinfo_current_address']; ?></textarea>  
		</div>
		
	</div>
	<div class="row reg-flow-input-mrg address-textarea-reg">
		<div class="col-lg-4 form-group sel-dropdown-mrgn">
			<label for="">Permanent Division</label>
			<select name="permanent_division" id="permanent_division" class="spoecial-aff-mostak">
				<option value="">Select Permanent Division</option>
				<?php foreach ($divisionlist as $dvsnlist2) {?>
					<option value="<?php echo $dvsnlist2->id;?>"><?php echo $dvsnlist2->name;?></option>
				<?php }?>
			</select>
		</div>
		<div class="col-lg-4 form-group sel-dropdown-mrgn">
			<label for="">Permanent District</label>
			<select name="permanent_district" id="permanent_district" class="spoecial-aff-mostak">
				<option value="">Select Permanent District</option>
			</select>
		</div>
		<div class="col-lg-4">
			<label for="">Permanent Address</label>
			<textarea name="permanent_address" class="form-control" rows="4"><?php echo $personal_info['spinfo_permanent_address']; ?></textarea>
		</div>
	</div>
	<!-- <div class="row reg-flow-input-mrg address-textarea-reg">
		<div class="col-lg-4">
			<label for="">Current Address</label>
			<textarea name="current_address" class="form-control" rows="4"><?php echo $personal_info['spinfo_current_address']; ?></textarea> 
		</div>
		<div class="col-lg-4">
			<label for="">Permanent Address</label>
			<textarea name="permanent_address" class="form-control" rows="4"><?php echo $personal_info['spinfo_permanent_address']; ?></textarea>
		</div>
	</div> -->
</div>
<div class="form-submit-btn">
	<a style="float: left;cursor:pointer" class="wzrd-submitbtn wzrd-back" data-function="back_to_account" data-state="account">BACK TO STEP 1 <br /> <span>Account Information</span> <i class="fa fa-angle-left"></i></a>
	<button style="float: right;" type="submit" class="wzrd-submitbtn">CONTINUE TO STEP 3 <br /> <span>Academic Information</span> <i class="fa fa-angle-right"></i></button>
</div>
<div class="form-submit-btn">
	<a href="<?php echo site_url(); ?>" class="wzrd-submitbtn" style="background: #A00; float: right; width: auto ! important; padding: 20px; color: rgb(255, 255, 255);">CANCEL REGISTRATION</a>
</div>
<?php echo form_close(); ?>
<script src="<?php echo base_url('frontend/'); ?>assets/js/app.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
	 $('#current_division').change(function(){
	  var division_id = $('#current_division').val();
	  if(division_id != '')
	  {
	   $.ajax({
	    url:"<?php echo base_url(); ?>student/onboard/fetch_district",
	    method:"POST",
	    data:{division_id:division_id},
	    success:function(data)
	    {
	     $('#current_district').html(data);
	    }
	   });
	  }
	  else
	  {
	   $('#current_district').html('<option value="">Select District</option>');
	  }
	 });

	 $('#permanent_division').change(function(){
	  var division_id = $('#permanent_division').val();
	  if(division_id != '')
	  {
	   $.ajax({
	    url:"<?php echo base_url(); ?>student/onboard/fetch_district",
	    method:"POST",
	    data:{division_id:division_id},
	    success:function(data)
	    {
	     $('#permanent_district').html(data);
	    }
	   });
	  }
	  else
	  {
	   $('#permanent_district').html('<option value="">Select District</option>');
	  }
	 });
});
</script>