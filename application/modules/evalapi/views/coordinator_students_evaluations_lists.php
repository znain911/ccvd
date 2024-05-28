<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th>SL.</th>
			<th>Student</th>
			<th>Title</th>
			<th>Evaluated By</th>
			<th class="text-center">Date</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody class="appnd-not-fnd-row">
		<?php
			$inc = 1;
			foreach($get_items as $item):
		?>
		<tr class="cnt-row items-row-<?php echo $item['evaluation_id']; ?>">
			<td class="text-left"><?php echo $inc; ?></td>
			<td class="text-left"><?php echo $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name']; ?> (<?php echo $item['student_entryid']; ?>)</td>
			<td class="text-left"><?php echo string_wrapper($item['evaluation_title'], 8); ?></td>
			<td class="text-left"><?php echo $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name']; ?> (<?php echo $item['teacher_entryid']; ?>)</td>
			<td class="text-center">
				<?php
					$time = strtotime($item['evaluation_create_date']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td>
				<button data-item="<?php echo $item['evaluation_id']; ?>" class="row-action-view-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
				<button data-item="<?php echo $item['evaluation_id']; ?>" class="remove-row-lesson btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-trash"></i> Delete</button>
			</td>
		</tr>
		<?php 
			$inc++;
			endforeach; 
		?>
	</tbody>
</table>
<div class="page-contr">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>