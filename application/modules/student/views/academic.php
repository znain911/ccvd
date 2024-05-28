<h1>STEP 3: PROFESSIONAL & ACADEMIC INFORMATION</h1>
<?php  
	$attr = array('id' => 'regStepThreeStudent', 'class' => 'position-relative');
	echo form_open_multipart('', $attr);
?>
<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
<div class="form-field-content">
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-12">
			<h3 class="form-middle-block-title">PROFESSIONAL INFORMATION</h3>
		</div>
		<div class="col-lg-12">
			<div id="messaging"></div>
		</div>
		<div class="col-lg-4">
			<div class="form-group">
				<label for="">Designation</label>
				<input type="text" name="designation" class="form-control" placeholder="Your title"/>
			</div>
			
			<div class="form-group">
			<label for="">Organization <br /> <span>(comma separate for more than one)</span></label>
			<input type="text" name="organization" class="form-control" placeholder="Your Organization"/>
			</div>
			
			<div class="address-textarea-reg">
				<label for="">Address of organization</label>
				<textarea name="organization_address" class="form-control" rows="4"></textarea>
			</div>
		</div>
		<div class="col-lg-8">
			<h2 class="specialization-lists-title">Specialization</h2>
			<div class="specialization-titles">
				<?php 
					$get_all_specializations = $this->Registration_model->get_all_specializations();
				?>
				<div class="specialization-part-object">
					<?php
						$count = 1;
						foreach($get_all_specializations as $specialization):
					?>
					<div class="checkbox"><label><input type="checkbox" name="specialization[]" value="<?php echo $specialization['specialize_id']; ?>"/> <?php echo $specialization['specialize_name']; ?> </label></div>
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
		<div class="col-lg-12">
			<h3 class="form-middle-block-title">ACADEMIC INFORMATION</h3>
		</div>
		<div class="col-lg-4 form-group">
			<label for="">Permanent BMDC Number</label>
			<input type="text" name="bmanddc_number" class="form-control" placeholder="Enter number here"/>
		</div>
	</div>
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-15"><label for="">Degree</label></div>
		<div class="col-lg-15"><label for="">Year</label></div>
		<div class="col-lg-15"><label for="">Institue/University</label></div>
		<div class="col-lg-15"><label for="">Marks/CGPA</label></div>
		<div class="col-lg-15"><label for="">Certificate</label></div>
	</div>
	<div class="multiple-result-entry">
		<div id="academicresultFlow">
			<div class="row reg-flow-input-mrg">
				<div class="col-lg-15"><div class="form-group"><input type="text" name="degree_1" class="form-control" placeholder="SSC" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="year_1" class="form-control" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="institute_1" class="form-control" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="cgpa_1" class="form-control" /></div></div>
				<div class="col-lg-15">
					<div class="form-group">
						<input type="file" name="certificate_1">
						<div class="input-group">
						  <input type="text" readonly="" class="form-control" placeholder="Upload...">
						  <span class="input-group-btn input-group-sm">
							<button type="button" class="btn btn-fab btn-fab-mini">
							  <i class="material-icons">attach_file</i>
							</button>
						  </span>
						</div>
					</div>
				</div>
				<input type="hidden" name="rownumber[]" value="1" />
			</div>
			<div class="row reg-flow-input-mrg">
				<div class="col-lg-15"><div class="form-group"><input type="text" name="degree_2" class="form-control" placeholder="HSC" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="year_2" class="form-control" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="institute_2" class="form-control" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="cgpa_2" class="form-control" /></div></div>
				<div class="col-lg-15">
					<div class="form-group">
						<input type="file" name="certificate_2">
						<div class="input-group">
						  <input type="text" readonly="" class="form-control" placeholder="Upload...">
						  <span class="input-group-btn input-group-sm">
							<button type="button" class="btn btn-fab btn-fab-mini">
							  <i class="material-icons">attach_file</i>
							</button>
						  </span>
						</div>
					</div>
				</div>
				<input type="hidden" name="rownumber[]" value="2" />
			</div>
			<div class="row reg-flow-input-mrg">
				<div class="col-lg-15"><div class="form-group"><input type="text" name="degree_3" class="form-control" placeholder="MBBS" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="year_3" class="form-control" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="institute_3" class="form-control" /></div></div>
				<div class="col-lg-15"><div class="form-group"><input type="text" name="cgpa_3" class="form-control" /></div></div>
				<div class="col-lg-15">
					<div class="form-group">
						<input type="file" name="certificate_3">
						<div class="input-group">
						  <input type="text" readonly="" class="form-control" placeholder="Upload...">
						  <span class="input-group-btn input-group-sm">
							<button type="button" class="btn btn-fab btn-fab-mini">
							  <i class="material-icons">attach_file</i>
							</button>
						  </span>
						</div>
					</div>
				</div>
				<input type="hidden" name="rownumber[]" value="3" />
			</div>
		</div>
		<span class="add-more-field-btttn" onclick="add_more_field()"><i class="ion-plus-circled"></i> Add Another</span>
	</div>
	<br />
	<div class="row reg-flow-input-mrg">
		<label for="" class="col-lg-12">DLP Category</label>
		<div class="col-lg-12">
			<?php 
				$dlp_categories = $this->Registration_model->get_dlp_categories();
			?>
			<div class="checkbox dlp-cats">
				<?php foreach($dlp_categories as $category): ?>
				<label><input type="checkbox" value="<?php echo $category['category_id']; ?>" name="dlp_category[]"> <?php echo $category['category_name']; ?> </label>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<div class="row reg-flow-input-mrg">
		<div class="col-lg-12">
			<h3 class="form-middle-block-title">SELECTION CRITERIA</h3>
		</div>
		<div class="col-lg-12">
			<div class="row">
				<div class="sel-criteria block">
					<label for="" class="col-lg-12">Types of practice?</label>
					<div class="radio radio-primary dlp-cats">
						<label><input type="radio" name="practice_type" value="GP" /> GP </label>
						<label><input type="radio" name="practice_type" value="SP" /> SP </label>
					</div>
				</div>
			</div>
		</div>
		
		<!-- <div class="col-lg-12">
			<div class="row">
				<div class="sel-criteria block">
					<label for="" class="col-lg-12">Years since passing MBBS?</label>
					<div class="radio radio-primary dlp-cats">
						<label><input type="radio" name="years_since" value="0-1 Year" /> 0-1 Year </label>
						<label><input type="radio" name="years_since" value="0-5 Years" /> 0-5 Years </label>
						<label><input type="radio" name="years_since" value="5-10 Years" /> 5-10 Years </label>
						<label><input type="radio" name="years_since" value="More than 10 Year" /> More than 10 Year </label>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-lg-12">
			<div class="row">
				<div class="sel-criteria block">
					<label for="" class="col-lg-12">Years of experience?</label>
					<div class="radio radio-primary dlp-cats">
						<label><input type="radio" name="years_experience" value="0-1 Year"> 0-1 Year </label>
						<label><input type="radio" name="years_experience" value="0-5 Years"> 0-5 Years </label>
						<label><input type="radio" name="years_experience" value="5-10 Years"> 5-10 Years </label>
						<label><input type="radio" name="years_experience" value="More than 10 Year"> More than 10 Year </label>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</div>
<div class="form-submit-btn">
	<a style="float: left;cursor:pointer" class="wzrd-submitbtn wzrd-back" data-function="back_to_personal" data-state="personal">BACK TO STEP 2 <br /> <span>Personal Information</span> <i class="fa fa-angle-left"></i></a>
	<button style="float: right;" type="submit" class="wzrd-submitbtn submit-application">SUBMIT APPLICATION <i class="fa fa-angle-right"></i></button>
</div>
<div class="form-submit-btn">
	<a href="<?php echo site_url(); ?>" class="wzrd-submitbtn" style="background: #A00; float: right; width: auto ! important; padding: 20px; color: rgb(255, 255, 255);">CANCEL REGISTRATION</a>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
	//var find_rentry_field = document.querySelector('.tt_rentry_field');
	//var total_rentry_field = find_rentry_field.length;
	$(document).ready(function(){
		var row = 4;
		$(document).on('click', '.add-more-field-btttn', function(){
			var content = '<div class="row reg-flow-input-mrg new-more-resentry">' +
							'<div class="col-lg-15"><div class="form-group"><input type="text" name="degree_'+row+'" class="form-control" placeholder="Enter degree" /></div></div>' +
							'<div class="col-lg-15"><div class="form-group"><input type="text" name="year_'+row+'" class="form-control" /></div></div>' +
							'<div class="col-lg-15"><div class="form-group"><input type="text" name="institute_'+row+'" class="form-control" /></div></div>' +
							'<div class="col-lg-15"><div class="form-group"><input type="text" name="cgpa_'+row+'" class="form-control" /></div></div>' +
							'<div class="col-lg-15">' +
								'<div class="form-group is-fileinput">' +
									'<input type="file" name="certificate_'+row+'">' +
									'<div class="input-group">' +
									  '<input type="text" readonly="" class="form-control" placeholder="Upload...">' +
									  '<span class="input-group-btn input-group-sm">' +
										'<button type="button" class="btn btn-fab btn-fab-mini">' +
										  '<i class="material-icons">attach_file</i>' +
										'</button>' +
									 '</span>' +
									'</div>' +
								'</div>' +
							'</div>' +
							'<span class="rmv-row ion-close-circled"></span>' +
							'<input type="hidden" name="rownumber[]" value="'+row+'" />' +
						'</div>';
			$('#academicresultFlow').append(content);
			row++;
		});
		$(document).on('click', '.rmv-row', function(){
			$(this).parent().remove();
		});
	});
</script>
<script src="<?php echo base_url('frontend/'); ?>assets/js/app.min.js"></script>