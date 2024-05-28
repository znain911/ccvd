<div class="form-cntnt" style="display:none">
	<h2 class="frm-title-ms">Create New</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'createData');
		echo form_open('#', $attr);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Student (Name+ID)</label>
			<div class="col-md-4">
				<select name="student_id" class="form-control" id="notCertifiedStudent">
					<option value="">Select Student</option>
					<?php 
						$get_studentsid = $this->Certificates_model->get_students_ids('Completed', 0);
						foreach($get_studentsid as $sid):
						if($sid['spinfo_middle_name'])
						{
							$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_middle_name'].' '.$sid['spinfo_last_name'];
						}else
						{
							$full_name = $sid['spinfo_first_name'].' '.$sid['spinfo_last_name'];
						}
					?>
					<option value="<?php echo $sid['student_id']; ?>"><?php echo $full_name.' ('.$sid['student_entryid'].')'; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Examination Held On</label>
			<div class="col-md-4">
				<input type="text" name="exam_held" class="form-control daterange-singledate" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Upload Certificate</label>
			<div class="col-md-4">
				<input type="file" name="certificate" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" />&nbsp;&nbsp;Published</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" checked />&nbsp;&nbsp;Unpublished</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Create</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 display-create-frm" type="button">Create New</button>
</div>