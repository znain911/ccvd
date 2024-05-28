<?php 
	if(count($items) !== 0):
	foreach($items as $item): 
	$active_user = $this->session->userdata('active_student');
	$check_has_ready = $this->Course_model->check_lesson_has_read($item['lesson_module_id'], $item['lesson_id'], $active_user);
	if($check_has_ready == true){
		$has_read = 'completed';
	}else
	{
		$has_read = '';
	}
?>
<div class="col-lg-4">
	<div class="module-number-stp-lesson mdl-lssn-srl-<?php echo $item['lesson_id']; ?> <?php echo $has_read; ?>" data-found="<?php echo $item['lesson_id']; ?>" data-found-mdl="<?php echo $item['lesson_module_id']; ?>"><?php echo $item['lesson_title']; ?></div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<div class="pagination-container"><?php echo $this->ajax_pagination->create_links(); ?></div>