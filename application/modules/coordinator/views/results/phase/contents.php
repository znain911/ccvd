<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/results/phase/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">ID</th>
						<th class="text-center">Student Name</th>
						<th class="text-center">Phase Level</th>
						<th class="text-center">Total Marks</th>
						<th class="text-center">Exam Status</th>
						<th class="text-center">Create Date</th>
						<th class="text-center">Result Status</th>
						<th class="text-center">Created By</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Phaseresults_model->get_all_items();
						foreach($get_items as $item):
						$total_marks = $this->Phaseresults_model->count_total_marks($item['cpreport_id']);
					?>
					<tr class="cnt-row items-row-<?php echo $item['cpreport_id']; ?>">
						<td class="text-center"><?php echo $item['student_entryid']; ?></td>
						<td class="text-center">
							<?php 
								if($item['spinfo_middle_name']):
									$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
								else:
									$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
								endif;
								echo $full_name; 
							?>
						</td>
						<td><?php echo $item['phase_name']; ?></td>
						<td><?php echo $total_marks; ?></td>
						<td>
							<?php if($item['cpreport_exam_status'] === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Passed</span>
							<?php elseif($item['cpreport_exam_status'] === '0'): ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Failed</span>
							<?php elseif($item['cpreport_exam_status'] === '2'): ?>
							<span class="btn btn-warning btn-xs btn-rounded p-l-10 p-r-10">Absent</span>
							<?php endif; ?>
						</td>
						<td>
							<?php
								$time = strtotime($item['cpreport_create_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td>
							<?php if($item['cpreport_status'] === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Published</span>
							<?php else: ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Unpublished</span>
							<?php endif; ?>
						</td>
						<td><?php echo $item['owner_name']; ?></td>
						<td class="text-center">
							<button data-id="<?php echo $item['cpreport_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->