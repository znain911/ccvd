<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/certificates/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">Student (Name+ID)</th>
						<th class="text-center">Examination Held On</th>
						<th class="text-center">Create Date</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Certificates_model->get_all_items();
						foreach($get_items as $item):
						if($item['spinfo_middle_name'])
						{
							$nameid = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'].' ('.$item['student_entryid'].')';
						}else
						{
							$nameid = $item['spinfo_first_name'].' '.$item['spinfo_last_name'].' ('.$item['student_entryid'].')';
						}
					?>
					<tr class="cnt-row items-row-<?php echo $item['certificate_id']; ?>">
						<td class="text-center"><?php echo $nameid; ?></td>
						<td class="text-center">
							<?php
								$time = strtotime($item['certificate_exam_helddate']);
								$myFormatForView = date("M d, Y", $time);
								echo $myFormatForView;
							?>
						</td>
						<td class="text-center">
							<?php
								$time = strtotime($item['certificate_create_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td class="text-center">
							<?php if($item['certificate_status'] === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Published</span>
							<?php else: ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Unpublished</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<a target="_blank" href="<?php echo attachment_url('certificates/'.$item['student_entryid'].'/'.$item['certificate_attach_file']); ?>" class="btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View Certificate</a>
							<button data-id="<?php echo $item['certificate_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-id="<?php echo $item['certificate_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->