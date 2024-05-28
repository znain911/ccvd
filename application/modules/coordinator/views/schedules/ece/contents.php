<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/schedules/ece/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">Schedule Title</th>
						<th class="text-center">Schedule</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
					$get_items = $this->Eceschedule_model->get_schedules();
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['endmschedule_id']; ?>">
						<td class="text-center"><?php echo $item['endmschedule_title']; ?></td>
						<td class="text-center">
							<?php 
								$dtfrom = date("d M, Y", strtotime($item['endmschedule_from_date']));
								echo $dtfrom;
							?>&nbsp;&nbsp;<strong>To</strong>&nbsp;&nbsp;
							<?php 
								echo date("d M, Y", strtotime($item['endmschedule_to_date']));
							?>
						</td>
						<td class="text-center">
							<?php if($item['endmschedule_status'] === '1'): ?>
								<button class="btn btn-success btn-rounded btn-xs p-l-10 p-r-10">Active</button>
							<?php else: ?>
								<button class="btn btn-danger btn-rounded btn-xs p-l-10 p-r-10">Inactive</button>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<button data-schedule="<?php echo $item['endmschedule_id']; ?>" class="row-action-center btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> Center Schedule</button>
							<button data-schedule="<?php echo $item['endmschedule_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-schedule="<?php echo $item['endmschedule_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->