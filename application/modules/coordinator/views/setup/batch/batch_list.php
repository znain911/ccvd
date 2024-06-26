<table id="data-table" class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th class="text-center">Batch Name</th>
			<th class="text-center">Create Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Batch_model->get_all_items();
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['batch_id']; ?>">
						<td class="text-center"><?php echo $item['batch_name']; ?></td>
						<td class="text-center">
							<?php
								$time = strtotime($item['added_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td class="text-center">
							<?php if($item['status'] === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Published</span>
							<?php else: ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Unpublished</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<a href="<?php echo base_url('coordinator/setup/batch_teacher/').$item['batch_id'];?>" class="btn btn-info btn-xs">Assign Teachers</a>
							<button data-id="<?php echo $item['batch_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-id="<?php echo $item['batch_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
</table>