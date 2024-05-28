<?php 
	$lesson_info = $this->Course_model->get_lessonby_id($lesson_id);
?>
<div class="form-cntnt lesson-form-number-<?php echo $lesson_id; ?>">
	<h2 class="frm-title-ms">Edit Lesson (<?php echo $module_info['phase_name']; ?>, <?php echo $module_info['module_name']; ?>)</h2>
	<?php 
		$attr = array('class' => 'form-horizontal', 'id' => 'upPhaseAlession');
		$hidden = array('module_id' => $module_id, 'lesson_id' => $lesson_id);
		echo form_open('#', $attr, $hidden);
	?>
		<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
		<div class="form-group">
			<div class="col-md-offset-6 col-md-6">
				<div id="alert"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Section/Lesson Title</label>
			<div class="col-md-4">
				<input type="text" name="section_title" placeholder="Enter Section/Lesson title" class="form-control" value="<?php echo $lesson_info['lesson_title']; ?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-8 control-label">Lesson No</label>
			<div class="col-md-4">
				<input type="text" class="form-control" name="position" value="<?php echo $lesson_info['lesson_position']; ?>" />
			</div>
		</div>
		
		
		<?php if($lesson_info['lesson_attach_file']): ?>
		<div class="form-group">
			<label class="col-md-8 control-label"></label>
			<div class="col-md-4">
				<label class="write_cnt"><input type="radio" name="choose_opt" />&nbsp;&nbsp;Write Content</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label class="upload_cnt"><input type="radio" name="choose_opt" checked />&nbsp;&nbsp;Upload Content</label>
			</div>
		</div>
		
		<div class="form-group upload-content-area">
			<label class="col-md-8 control-label">Upload Content (pdf, doc)</label>
			<div class="col-md-4">
				<input type="file" name="uploaded_lesson" />
			</div>
		</div>
		
		<div class="form-group write-content-area" style="display:none;">
			<label class="col-md-12 control-label">Description</label>
			<div class="col-md-12">
				<textarea name="description" class="textarea form-control ckeditor" rows="15" data-height="350"><?php echo $lesson_info['lesson_content']; ?></textarea>
			</div>
		</div>
		<?php else: ?>
		<div class="form-group">
			<label class="col-md-8 control-label"></label>
			<div class="col-md-4">
				<label class="write_cnt"><input type="radio" name="choose_opt" checked />&nbsp;&nbsp;Write Content</label>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<label class="upload_cnt"><input type="radio" name="choose_opt" />&nbsp;&nbsp;Upload Content</label>
			</div>
		</div>
		
		<div class="form-group upload-content-area" style="display:none;">
			<label class="col-md-8 control-label">Upload Content (pdf, doc)</label>
			<div class="col-md-4">
				<input type="file" name="uploaded_lesson" />
			</div>
		</div>
		
		<div class="form-group write-content-area">
			<label class="col-md-12 control-label">Description</label>
			<div class="col-md-12">
				<textarea name="description" class="textarea form-control ckeditor" rows="15" data-height="350"><?php echo $lesson_info['lesson_content']; ?></textarea>
			</div>
		</div>
		<?php endif; ?>
		
		<div class="generate-buttons text-right">
			<button class="btn btn-purple m-b-5" type="submit" onclick="document.getElementById('upPhaseAlession').value=CKEDITOR.instances.description.getData();CKEDITOR.instances.description.destroy()">Update Lesson</button>
			<button class="btn btn-danger m-b-5 btn-remove-form" type="button">Cancel</button>
		</div>
	<?php echo form_close(); ?>
</div>
<div class="generate-buttons text-right display-crtbtn" style="display:none">
	<button class="btn btn-purple m-b-5 return-create-lesson" data-phase="<?php echo $phase_id; ?>" data-module="<?php  echo $module_info['module_id']; ?>" type="button">Create New Lesson</button>
	<button class="btn btn-purple m-b-5 back-to-modules" data-phase="<?php echo $phase_id; ?>" type="button">Back To Modules</button>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.upload_cnt', function(){
			$('.write-content-area').hide();
			$('.upload-content-area').show();
		});
		$(document).on('click', '.write_cnt', function(){
			$('.write-content-area').show();
			$('.upload-content-area').hide();
		});
	});
</script>