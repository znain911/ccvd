<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/setup/exambutton/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">Title</th>
						<th class="text-center">Batch</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$get_items = $this->Exambutton_model->get_all_items();
						foreach($get_items as $item):
							if ($item['exam_type'] == 1) {
								$etyp = 'CCA-1';
							}elseif ($item['exam_type'] == 2) {
								$etyp = 'CCA-2';
							}elseif ($item['exam_type'] == 3) {
								$etyp = 'CCA-3';
							}elseif ($item['exam_type'] == 4) {
								$etyp = 'ECE';
							}
					?>
					<tr class="cnt-row items-row-<?php echo $item['btn_id']; ?>">
						<td class="text-center"><?php echo $etyp; ?></td>
						
						<td class="text-center">							
							<?php echo $item['batch']; ?>
						</td>
						
						<td class="admin-status text-center">
							<?php if($item['btn_status'] !== '1'): ?>
							<i class="fa fa-lock"></i>
							<?php else : ?>
							<i class="fa fa-check"></i>
							<?php endif; ?> 
						</td>
						<td class="text-center">
							<button data-id="<?php echo $item['btn_id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-id="<?php echo $item['btn_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->