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
			<label class="col-md-8 control-label">Root</label>
			<div class="col-md-4">
				<textarea name="title" class="form-control" cols="30" rows="5" placeholder="Write the question here"></textarea>
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
					<option value="<?php echo $phase['phase_id']; ?>"><?php echo $phase['phase_name']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div id="dependentModule"></div>
		<div id="dependentLesson"></div>
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
					<option value="<?php echo $key; ?>"><?php echo $type; ?></option>
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
			<?php require_once APPPATH.'modules/coordinator/views/questions/mcq.php'; ?>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Status</label>
			<div class="col-md-4 control-label">
				<label><input type="radio" name="status" value="1" checked />&nbsp;&nbsp;Active</label>&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="status" value="0" />&nbsp;&nbsp;Inactive</label>
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