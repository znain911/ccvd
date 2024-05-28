<h2 class="frm-title-ms">Lessons (<?php echo $module_info['phase_name']; ?>, <?php echo $module_info['module_name']; ?>)</h2>
<table class="table table-td-valign-middle m-b-0" id="data-table">
	<thead>
		<tr>
			<th class="text-center">Module Title</th>
			<th class="text-center">Section Title</th>
			<th class="text-center">Lesson No</th>
			<th class="text-center">Create Date</th>
			<th class="text-center">Created By</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
		$get_items = $this->Course_model->get_lessonsby_module($module_id);
		if(count($get_items) !== 0):
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['lesson_id']; ?>">
			<td class="text-center"><?php echo $item['module_title']; ?></td>
			<td class="text-center"><?php echo $item['lesson_title']; ?></td>
			<td class="text-center"><?php echo $item['lesson_position']; ?></td>
			<td class="text-center">
				<?php
					$time = strtotime($item['lesson_create_date']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td><?php echo $item['owner_name']; ?></td>
			<td class="text-center putmrg-to-btn">
				<?php if($item['lesson_attach_file']): ?>
				<a target="_blank" href="<?php echo attachment_url('lessons/'.$item['lesson_attach_file']); ?>" class="btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</a>
				<?php else: ?>
				<!-- <button data-phase="<?php echo $item['module_phase_id']; ?>" data-module="<?php echo $item['module_id']; ?>" data-lesson="<?php echo $item['lesson_id']; ?>" class="row-action-view-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button> -->
				<a target="_blank" href="<?php echo base_url('coordinator/course/createpdf/').$item['lesson_id']; ?>" class="btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</a>
				<?php endif; ?>
				<button data-module="<?php echo $item['module_id']; ?>" data-phase="<?php echo $item['module_phase_id']; ?>" data-lesson="<?php echo $item['lesson_id']; ?>" class="row-action-edit-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
				<button data-phase="<?php echo $item['module_phase_id']; ?>" data-module="<?php echo $item['module_id']; ?>" data-lesson="<?php echo $item['lesson_id']; ?>" class="remove-row-lesson btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-trash"></i> Delete</button>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>