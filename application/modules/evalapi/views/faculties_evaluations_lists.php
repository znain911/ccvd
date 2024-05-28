<table class="table rslt-tbl-row" style="font-size: 12px">
	<thead>
		<tr>
			<th class="text-center">SL.</th>
			<th class="text-center">Student</th>
			<th class="text-center">Title</th>
			<th class="text-center">Submit Date</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$sl = 1;
			foreach($get_items as $evaluation):
			$student_name = $evaluation['spinfo_first_name'].' '.$evaluation['spinfo_middle_name'].' '.$evaluation['spinfo_last_name'];
		?>
		<tr>
			<td><?php echo $sl; ?></td>
			<td><?php echo $student_name; ?></td>
			<td><?php echo $evaluation['evaluation_title']; ?></td>
			<td class="text-center"><?php echo date("d F, Y", strtotime($evaluation['evaluation_create_date'])); ?></td>
			<td class="text-center"><span data-evl-id="<?php echo $evaluation['evaluation_id']; ?>" style="cursor:pointer;display: inline-block;background: #0a0;color: #FFF;padding: 0 8px;font-size: 11px;border-radius: 5%;" data-target="#viewFacultyRatings" data-toggle="modal"><i class="fa fa-eye"></i> View</span></td>
		</tr>
		<?php 
			$sl++;
			endforeach; 
		?>
	</tbody>
</table>
<div class="page-contr">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>