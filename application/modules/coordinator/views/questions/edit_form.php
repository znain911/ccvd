<?php 
	$row_info = $this->Questions_model->get_info($id, $exam_type);
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
			<label class="col-md-8 control-label">Root</label>
			<div class="col-md-4">
				<textarea name="title" class="form-control" cols="30" rows="5" placeholder="Write the question here"><?php echo $row_info['question_title']; ?></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Phase Level</label>
			<div class="col-md-4">
				<?php 
					$get_phases = $this->Questions_model->get_phases();
				?>
				<select name="phase_level" class="form-control" id="phaseLevel">
					<option value="">Select Phase Level</option>
					<?php foreach($get_phases as $phase): ?>
					<option value="<?php echo $phase['phase_id']; ?>" <?php echo ($row_info['question_module_phase_id'] == $phase['phase_id'])? 'selected' : null; ?>><?php echo $phase['phase_name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div id="dependentModule">
			<div class="form-group">
				<label class="col-md-8 control-label">Module</label>
				<div class="col-md-4">
					<select name="phs_module" class="form-control" id="selectedModule">
						<option value="">Select Module</option>
						<?php 
							$get_modules = $this->Questions_model->get_phase_modules($row_info['question_module_phase_id']);
							foreach($get_modules as $module):
						?>
						<option value="<?php echo $module['module_id'] ?>" <?php echo ($row_info['question_module_id'] == $module['module_id'])? 'selected' : null; ?>><?php echo $module['module_name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		<div id="dependentLesson">
			<div class="form-group">
				<label class="col-md-8 control-label">Lesson</label>
				<div class="col-md-4">
					<select name="module_lesson" class="form-control">
						<option value="">Select Lesson</option>
						<?php 
							$get_lessons = $this->Questions_model->get_module_lessons($row_info['question_module_id']);
							foreach($get_lessons as $lesson):
						?>
						<option value="<?php echo $lesson['lesson_id']; ?>" <?php echo ($row_info['question_lesson_id'] == $lesson['lesson_id'])? 'selected' : null; ?>><?php echo $lesson['lesson_title']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Exam Type</label>
			<div class="col-md-4">
				<?php 
					$question_types = array(
										'MCQ' => 'MCQ',
										'BLANK' => 'Fill in the blanks',
										'JUSTIFY' => 'True Or False',
										'MULTIPLE_JUSTIFY' => 'Multiple Justify',
									);
				?>
				<select name="question_type" class="form-control" id="selectedQuestionType">
					<?php foreach($question_types as $key => $type): ?>
					<option value="<?php echo $key; ?>" <?php echo ($row_info['question_type'] == $key)? 'selected' : null; ?>><?php echo $type; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
		<div class="form-group">
			<div class="col-md-offset-8 col-md-4 text-center">
				<div class="frm-legend"><span class="legend-label">Answers</span></div>
			</div>
		</div>
		
		<div id="answerQuestionType">
			<?php if($row_info['question_type'] == 'MCQ'): ?>
				<?php require_once APPPATH.'modules/coordinator/views/questions/ansedit/mcq.php'; ?>
			<?php elseif($row_info['question_type'] == 'BLANK'): ?>
				<?php require_once APPPATH.'modules/coordinator/views/questions/ansedit/blanks.php'; ?>
			<?php elseif($row_info['question_type'] == 'JUSTIFY'): ?>
				<?php require_once APPPATH.'modules/coordinator/views/questions/ansedit/justify.php'; ?>
			<?php elseif($row_info['question_type'] == 'MULTIPLE_JUSTIFY'): ?>
				<?php require_once APPPATH.'modules/coordinator/views/questions/ansedit/multiple_justify.php'; ?>
			<?php else: ?>
				<?php require_once APPPATH.'modules/coordinator/views/questions/ansedit/mcq.php'; ?>
			<?php endif; ?>
		</div>
		
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" <?php echo ($row_info['question_status'] === '1')? 'checked' : null; ?> />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" <?php echo ($row_info['question_status'] === '0')? 'checked' : null; ?> />&nbsp;&nbsp;Inactive</label>
			</div>
		</div>
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit">Update</button>
			<button class="btn btn-danger m-b-5 retrive-create-again" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>