<table id="data-table" class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th class="text-center" style="width:30%">Title</th>
			<th class="text-center">Chapter Level</th>
			<th class="text-center">Module</th>
			<th class="text-center">Lesson</th>
			<th class="text-center">Create Date</th>
			<th class="text-center">Created By</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
		$get_items = $this->Questions_model->get_modules_questions();
		if(count($get_items) !== 0):
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['question_id']; ?>">
			<td class="text-center"><?php echo $item['question_title']; ?></td>
			<td class="text-center"><?php echo $item['phase_name']; ?></td>
			<td class="text-center"><?php echo $item['module_name']; ?></td>
			<td class="text-center">
				<?php
					$time = strtotime($item['question_create_date']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td class="text-center"><?php echo $item['owner_name']; ?></td>
			<td class="text-center">
				<a style="display:inline" href="#modal-without-animation-question" data-question="<?php echo $item['question_id']; ?>" class="view-qstion btn btn-block btn-success btn-xs p-l-10 p-r-10" data-toggle="modal"><i class="fa fa-eye"></i> View</a>
				<button data-id="<?php echo $item['question_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
				<button data-id="<?php echo $item['question_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
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