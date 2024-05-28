<!-- begin widget -->
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">SL.</th>
						<th class="text-center">Name</th>
						<th class="text-center">Phone</th>
						<th class="text-center">Email</th>
						<th class="text-center">Subject</th>
						<th class="text-center">Contact Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Contacts_model->get_all_contacts();
						$inc = 1;
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['contact_id']; ?>">
						<td class="text-center"><?php echo $inc; ?></td>
						<td class="text-center"><?php echo $item['contact_name']; ?></td>
						<td class="text-center"><?php echo $item['contact_phone']; ?></td>
						<td class="text-center"><?php echo $item['contact_email']; ?></td>
						<td class="text-center"><?php echo string_wrapper($item['contact_subject'], 7); ?></td>
						<td class="text-center">
							<?php
								$time = strtotime($item['contact_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td>
							<button data-item="<?php echo $item['contact_id']; ?>" class="row-action-view-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
							<button data-item="<?php echo $item['contact_id']; ?>" class="remove-row-lesson btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-trash"></i> Delete</button>
						</td>
					</tr>
					<?php 
						$inc++;
						endforeach; 
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->