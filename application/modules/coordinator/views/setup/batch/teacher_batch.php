<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/setup/batch/teacher_create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">Teacher Name</th>
						<th class="text-center">Chapter</th>
						<th class="text-center">Added Date</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
					/*$get_items = $this->Batch_model->get_all_items();*/
						foreach($getteachers as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item->bt_id; ?>">
						<td class="text-center"><?php echo $item->tpinfo_first_name.' '.$item->tpinfo_middle_name.' '.$item->tpinfo_last_name; ?></td>
						<td class="text-center"><?php echo $item->phase_name; ?></td>
						
						<td class="text-center">
							<?php
								$time = strtotime($item->added_date);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td class="text-center">
							<?php if($item->bt_status === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Active</span>
							<?php else: ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Inactive</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<button data-id="<?php echo $item->bt_id; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-id="<?php echo $item->bt_id; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->