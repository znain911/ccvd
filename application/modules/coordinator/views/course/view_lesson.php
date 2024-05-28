<?php 
	$lesson_info = $this->Course_model->get_lessonby_id($lesson_id);
?>
<div class="form-cntnt lesson-form-number-<?php echo $lesson_id; ?>">
	<h2 class="frm-title-ms"><strong><?php  echo $module_info['module_name']; ?> : </strong><?php echo $module_info['module_title']; ?></h2>
	<div class="lesson-information-content">
		<h4><strong>Lesson : </strong><?php echo $lesson_info['lesson_title']; ?></h4>
		<div class="less-content">
			<?php echo $lesson_info['lesson_content']; ?>
		</div>
	</div>
</div>
<div class="generate-buttons text-right display-crtbtn">
	<button class="btn btn-purple m-b-5 return-create-lesson" data-phase="<?php echo $phase_id; ?>" data-module="<?php  echo $module_info['module_id']; ?>" type="button">Create New Lesson</button>
	<button class="btn btn-purple m-b-5 back-to-modules" data-phase="<?php echo $phase_id; ?>" type="button">Back To Modules</button>
</div>