<?php 
	$row_info = $this->Certificates_model->get_info($id);
?>
<div class="form-cntnt form-number-<?php echo $id; ?>">
	<h2 class="frm-title-ms">Edit</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'updateData');
		$hidden = array('id' => $id);
		echo form_open('#', $attr, $hidden);
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
				<?php 
					if($row_info['spinfo_middle_name'])
					{
						$full_name = $row_info['spinfo_first_name'].' '.$row_info['spinfo_middle_name'].' '.$row_info['spinfo_last_name'].' ('.$row_info['student_entryid'].')';;
					}else
					{
						$full_name = $row_info['spinfo_first_name'].' '.$row_info['spinfo_last_name'].' ('.$row_info['student_entryid'].')';;
					}
				?>
				<input type="text" class="form-control" value="<?php echo $full_name; ?>" disabled />
				<input type="hidden" name="student_id" value="<?php echo $row_info['certificate_student_id']; ?>" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Examination Held On</label>
			<div class="col-md-4">
				<input type="text" name="exam_held" value="<?php echo $row_info['certificate_exam_helddate']; ?>" class="form-control daterange-singledate" />
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
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['certificate_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Published</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['certificate_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Unpublished</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>