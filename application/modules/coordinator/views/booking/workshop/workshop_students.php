<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		<?php $get_applicants = $this->Booking_model->get_workshop_applicants('Student'); ?>
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Applicants Booking</a></li>
				<li><a href="javascript:;">Workshop Applicants (Students)</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Workshop Applicants (Students) : <span id="totalSdtBooking"><?php echo count($get_applicants) ?></span></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12">
					<!-- begin widget -->
					<div id="onPgaeLoadingForm"></div>
					<div class="widget p-0">
						<div class="table-responsive">
							<div id="postList">
								<table id="data-table" class="table table-td-valign-middle m-b-0">
									<thead>
										<tr>
											<th class="text-center">SL/No.</th>
											<th class="text-center">Students (Name+ID)</th>
											<th class="text-center">Phase Level</th>
											<th class="text-center">Center Schedule</th>
											<th class="text-center">Center Location</th>
											<th class="text-center">Booking Date</th>
											<th class="text-center">booking Status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody class="appnd-not-fnd-row">
										<?php 
											$sl = 1;
											foreach($get_applicants as $applicant):
											$student_infos = $this->Booking_model->get_student_infos($applicant['booking_user_id']);
											$conter_location = $this->Booking_model->get_center_location($applicant['centerschdl_center_id']);
										?>
										<tr class="cnt-row items-row-<?php echo $applicant['booking_id']; ?>">
											<td><?php echo $sl; ?></td>
											<td class="text-center"><?php echo $student_infos['spinfo_first_name'].' '.$student_infos['spinfo_middle_name'].' '.$student_infos['spinfo_last_name'].' ('.$student_infos['student_entryid'].')'; ?></td>
											<td class="text-center"><?php echo $applicant['phase_name']; ?></td>
											<td class="text-center"><?php echo date("d M Y", strtotime($applicant['centerschdl_to_date'])).' '.$applicant['centerschdl_to_time'];  ?></td>
											<td class="text-center"><?php echo $conter_location['center_location']; ?></td>
											<td class="text-center"><?php echo date("d M Y", strtotime($applicant['booking_date'])).' '.date("g:i A", strtotime($applicant['booking_date'])); ?></td>
											<td class="text-center">
												<?php 
													$now_date = strtotime(date("Y-m-d"));
													$to_date = strtotime(date("Y-m-d", strtotime($applicant['centerschdl_to_date'])));
													if($now_date > $to_date): 
												?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Expired</span>
												<?php else: ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Active</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button data-id="<?php echo $applicant['booking_id']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
											</td>
										</tr>
										<?php 
											$sl++;
											endforeach; 
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- end widget -->
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
            <!-- begin #footer -->
            <?php require_once APPPATH.'modules/coordinator/templates/copyright.php'; ?>
            <!-- end #footer -->
		</div>
		<!-- end #content -->
		
		<script type="text/javascript">
			$(document).ready(function(){
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				$(document).on('click', '.remove-row', function(){
					if(confirm('Are you sure?', true))
					{
						var id = $(this).attr('data-id');
						$('.items-row-'+id).remove();
						if(document.querySelector('.cnt-row'))
						{
							var total_row = document.querySelector('.cnt-row').length + 1;
						}else
						{
							var total_row = 1;
						}
						
						if(total_row == 1)
						{
							$('.appnd-not-fnd-row').html(not_data);
						}
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/booking/workshop_delete',
							data:{id:id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else
					{
						return false;
					}
				});
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>