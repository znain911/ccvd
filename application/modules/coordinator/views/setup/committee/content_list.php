<table id="data-table" class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th>Name</th>
			<th class="text-center">position</th>
			<th>Photo</th>
			<th>Designation</th>
			<th>Create Date</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$get_items = $this->Organogram_model->get_all_items();
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['owner_id']; ?>">
			<td><?php echo $item['owner_name']; ?></td>
			<td class="text-center"><?php echo $item['owner_position']; ?></td>
			<td class="text-center">
				<?php 
					if($item['owner_photo']):
				?>
				<img src="<?php echo base_url('attachments/coordinators/'.$item['owner_photo']); ?>" height="40" width="50"/>
				<?php else: ?>
				<img src="<?php echo base_url('backend/assets/tools/default_avatar.png'); ?>" height="40" width="50"/>
				<?php endif; ?>
			</td>
			<td class="text-center"><?php echo $item['owner_designation']; ?></td>
			<td class="text-center">
				<?php
					$time = strtotime($item['owner_create_date']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td class="admin-status text-center">
				<?php if($item['owner_activate'] !== '1'): ?>
				<i class="fa fa-lock"></i>
				<?php else : ?>
				<i class="fa fa-check"></i>
				<?php endif; ?> 
			</td>
			<td class="text-center">
				<button data-id="<?php echo $item['owner_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
				<button data-id="<?php echo $item['owner_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>