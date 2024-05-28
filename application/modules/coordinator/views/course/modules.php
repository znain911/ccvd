<table class="table table-td-valign-middle m-b-0" id="data-table">
	<thead>
		<tr>
			<th class="text-center">Phase Level</th>
			<th class="text-center">Module</th>
			<th class="text-center">Title</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
		$get_items = $this->Course_model->get_phase_modules($phase_id);
		if(count($get_items) !== 0):
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['module_id']; ?>">
			<td class="text-center"><?php echo $item['phase_name']; ?></td>
			<td class="text-center"><?php echo $item['module_name']; ?></td>
			<td class="text-center"><?php echo $item['module_title']; ?></td>
			<td class="text-center">
				<button data-phase="<?php echo $item['module_phase_id']; ?>" data-module="<?php echo $item['module_id']; ?>" class="row-action-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View Lessons</button>
				<button data-module="<?php echo $item['module_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
				<button data-phase="<?php echo $item['module_phase_id']; ?>" data-module="<?php echo $item['module_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
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