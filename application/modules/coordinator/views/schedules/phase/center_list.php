<h2 class="frm-title-ms">Center Schedules</h2>
<table id="data-table" class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th class="text-center">Center Name</th>
			<th class="text-center">Date</th>
			<th class="text-center">Time</th>
			<th class="text-center">Miximum Sit</th>
			<th class="text-center">Booking Close Date/Time</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
		$get_items = $this->Phaseschedule_model->get_center_schedules($schedule_id);
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['centerschdl_id']; ?>">
			<td class="text-center"><?php echo $item['center_location']; ?></td>
			<td class="text-center"><?php echo date("d M, Y", strtotime($item['centerschdl_to_date'])); ?></td>
			<td class="text-center"><?php echo date("g:i A", strtotime($item['centerschdl_to_time'])); ?></td>
			<td class="text-center"><?php echo $item['centerschdl_maximum_sit']; ?></td>
			<td class="text-center">
				<?php
					$time = strtotime($item['centerschdl_last_bookingtime']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td class="text-center putmrg-to-btn">
				<button data-schedule="<?php echo $item['centerschdl_id']; ?>" class="row-action-edit-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
				<button data-parent-schedule="<?php echo $schedule_id; ?>" data-schedule="<?php echo $item['centerschdl_id']; ?>" class="remove-row-lesson btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-trash"></i> Delete</button>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>