<?php 
	$row_info = $this->Phaseresults_model->get_info($id);
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
			<label class="col-md-8 control-label">Phase Level</label>
			<div class="col-md-4">
				<?php 
					$get_phases = $this->Phaseresults_model->get_phases();
				?>
				<select class="form-control" id="phaseLevel" disabled>
					<option value="">Select Phase Level</option>
					<?php foreach($get_phases as $phase): ?>
					<option value="<?php echo $phase['phase_id']; ?>" <?php echo ($row_info['cpreport_phase_id'] == $phase['phase_id'])? 'selected' : null; ?>><?php echo $phase['phase_name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Student (Name+ID)</label>
			<div class="col-md-4">
				<select class="form-control" disabled>
					<option value="">Select Student</option>
					<?php 
						$get_studentsid = $this->Phaseresults_model->get_students_info($row_info['cpreport_student_id']);
						if($get_studentsid['spinfo_middle_name'])
						{
							$full_name = $get_studentsid['spinfo_first_name'].' '.$get_studentsid['spinfo_middle_name'].' '.$get_studentsid['spinfo_last_name'];
						}else
						{
							$full_name = $get_studentsid['spinfo_first_name'].' '.$get_studentsid['spinfo_last_name'];
						}
					?>
					<option value="<?php echo $get_studentsid['student_id']; ?>" selected="selected"><?php echo $full_name.' ('.$get_studentsid['student_entryid'].')'; ?></option>
				</select>
				<input type="hidden" name="student_id" value="<?php echo $row_info['cpreport_student_id']; ?>" />
				<input type="hidden" name="phase_level" value="<?php echo $row_info['cpreport_phase_id']; ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-offset-8 col-md-4 text-center">
				<div class="frm-legend"><span class="legend-label">Marks Distribution</span></div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-3 text-center"><strong>Label</strong></div>
			<div class="col-md-2 text-center">
				<strong>Marks</strong>
			</div>
		</div>
		<div>
			<?php 
				$get_marks = $this->Phaseresults_model->get_marksby_progress($row_info['cpreport_id']);
				foreach($get_marks as $mark):
			?>
			<div class="form-group">
				<div class="col-md-offset-6 col-md-3"><input type="text" value="<?php echo $mark['pmark_label']; ?>" name="marks_label_<?php echo $mark['pmark_id']; ?>" class="form-control" /></div>
				<div class="col-md-2 text-center relate-add-sign">
					<input type="text" name="marks_<?php echo $mark['pmark_id']; ?>" value="<?php echo $mark['pmark_number']; ?>" class="form-control" />
					<input type="hidden" name="rownumber[]" value="<?php echo $mark['pmark_id']; ?>" />
				</div>
			</div>
			<?php
				endforeach; 
			?>
		</div>
		<!--
		<div id="marksDistribute">
			<?php 
				$get_marks = $this->Phaseresults_model->get_marksby_progress($row_info['cpreport_id']);
				$chk = 1;
				foreach($get_marks as $mark):
			?>
			<?php if($chk == 1): ?>
				<div class="form-group">
					<div class="col-md-offset-6 col-md-3"><input type="text" value="<?php echo $mark['pmark_label']; ?>" name="marks_label_<?php echo $mark['pmark_id']; ?>" class="form-control" /></div>
					<div class="col-md-2 text-center relate-add-sign">
						<input type="text" name="marks_<?php echo $mark['pmark_id']; ?>" value="<?php echo $mark['pmark_number']; ?>" class="form-control" />
						<span class="add-more-mrksinp fa fa-plus-square"></span>
						<input type="hidden" name="rownumber[]" value="<?php echo $mark['pmark_id']; ?>" />
					</div>
				</div>
			<?php else: ?>
				<div class="form-group">
					<div class="col-md-offset-6 col-md-3"><input type="text" value="<?php echo $mark['pmark_label']; ?>" name="marks_label_<?php echo $mark['pmark_id']; ?>" class="form-control" /></div>
					<div class="col-md-2 text-center relate-add-sign">
						<input type="text" name="marks_<?php echo $mark['pmark_id']; ?>" value="<?php echo $mark['pmark_number']; ?>" class="form-control" />
						<span class="rmv-row-mrksinp fa fa-times"></span>
						<input type="hidden" name="rownumber[]" value="<?php echo $mark['pmark_id']; ?>" />
					</div>
				</div>
			<?php endif; ?>
			
			<?php
				$chk++;
				endforeach; 
			?>
		</div>
		-->
		<div class="form-group">
			<label class="col-md-8 control-label">Exam Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="exam_status" value="1" <?php echo ($row_info['cpreport_exam_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Passed</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="exam_status" value="0" <?php echo ($row_info['cpreport_exam_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Failed</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="exam_status" value="2" <?php echo ($row_info['cpreport_exam_status'] === '2')? 'checked' : null; ?> />&nbsp;&nbsp;Absent</label>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Result Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['cpreport_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Published</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['cpreport_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Unpublished</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>