<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th class="text-center">Bank</th>
			<th class="text-center">Bank Name</th>
			<th class="text-center">Branch Name</th>
			<th class="text-center">Account Name</th>
			<th class="text-center">Account Number</th>
			<th class="text-center">Create Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
		$get_items = $this->Banks_model->get_all_items();
		if(count($get_items) !== 0):
			foreach($get_items as $item):
			$photo = attachment_url('banks/'.$item['bank_photo_icon']);
		?>
		<tr class="cnt-row items-row-<?php echo $item['bank_id']; ?>">
			<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
			<td class="text-center"><?php echo $item['bank_name']; ?></td>
			<td class="text-center"><?php echo $item['bank_branch_name']; ?></td>
			<td class="text-center"><?php echo $item['bank_account_name']; ?></td>
			<td class="text-center"><?php echo $item['bank_account_number']; ?></td>
			<td class="text-center">
				<?php
					$time = strtotime($item['bank_create_date']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td class="text-center">
				<?php if($item['bank_status'] === '1'): ?>
				<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Published</span>
				<?php else: ?>
				<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Unpublished</span>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<button data-id="<?php echo $item['bank_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
				<button data-id="<?php echo $item['bank_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="8"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>