<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/setup/notice/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<div id="getContents">
			<table id="data-table" class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center">Title</th>
						<th class="text-center">File</th>
						<th class="text-center">Create Date</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$get_items = $this->Notice_model->get_all_items();
						foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['id']; ?>">
						<td><?php echo $item['title']; ?></td>
						
						<td class="text-center">
							<?php 
								if($item['filename']):
							?>
							<!-- <img src="<?php echo attachment_url('notice/'.$item['filename']); ?>" height="40" width="50"/> -->
							<a href="<?php echo attachment_url('notice/'.$item['filename']); ?>" target="_blank">Click here</a>
							<?php else: ?>
							<!-- <img src="<?php echo base_url('backend/assets/tools/default_avatar.png'); ?>" height="40" width="50"/> -->
							attachment unavailable
							<?php endif; ?>

						</td>
						
						<td class="text-center">
							<?php
								$time = strtotime($item['create_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td class="admin-status text-center">
							<?php if($item['status'] !== '1'): ?>
							<i class="fa fa-lock"></i>
							<?php else : ?>
							<i class="fa fa-check"></i>
							<?php endif; ?> 
						</td>
						<td class="text-center">
							<button data-id="<?php echo $item['id']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-id="<?php echo $item['id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- end widget -->