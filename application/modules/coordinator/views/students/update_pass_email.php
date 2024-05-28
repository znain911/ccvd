<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Students</a></li>
				<li><a href="javascript:;">Update Password and Gmail</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Enrolled Students : <span id="totalEnrolledStudents"><?php echo count($get_items) ?></span></h1>
			<!-- <a href="<?php echo base_url('coordinator/students/enrolled_csv');?>" class="btn btn-info pull-right"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</a> -->
			
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
								<table class="table table-td-valign-middle m-b-0" id="data-table">
									<thead>
										<tr>
											<th nowrap>SL</th>
											<th nowrap>#ID</th>
											<th class="text-center">Full Name</th>
											<th class="text-center">Present Phone</th>
											<th class="text-center">Gmail</th>
											<th class="text-center">Update Buttons</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sl=1;
										if(count($get_items) !== 0):
											foreach($get_items as $item):
											//$photo = base_url('attachments/students/'.$item['spinfo_photo']);
											/*$photo = base_url('attachments/students/'.$item['student_entryid'].'/'.$item['spinfo_photo']);*/
											if($item['spinfo_middle_name'])
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
											}else
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
											}
										?>
										<tr class="items-row-<?php echo $item['student_id']; ?>">
											<td><?php echo $sl;?></td>
											<td><?php echo $item['student_entryid']; ?></td>
											
											<td class="text-center"><?php echo $full_name; ?></td>											
											<td class="text-center"><?php echo $item['spinfo_personal_phone']; ?></td>
											<td class="text-center"><?php echo $item['student_email']; ?></td>
			
											<td class="text-center item-row-exam-<?php echo $item['student_id']; ?>">
												<button data-student="<?php echo $item['student_id']; ?>" type="button" class="reset-pass btn btn-primary btn-sm">Reset Password</button>	
												<button data-target="#email-form" data-toggle="modal" data-student="<?php echo $item['student_id']; ?>" type="button" class="reset-gmail btn btn-secondary btn-sm">Change Email</button>
												<button data-target="#mobile-form" data-toggle="modal" data-student="<?php echo $item['student_id']; ?>" type="button" class="reset-phone btn btn-info btn-sm">Change Phone</button>
												<input type="hidden" value = "<?php echo $item['spinfo_personal_phone']; ?>">
											</td>
											<td class="text-center">
												<button data-student="<?php echo $item['student_id']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View Student</button>
											
												<!--<button data-student="<?php echo $item['student_id']; ?>" onclick="return confirm('Are you sure?', true);" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Reject</button>-->
											</td>
										</tr>
										<?php $sl++; endforeach; ?>
										<?php else: ?>
										<tr>
											<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
										</tr>
										<?php endif; ?>
									</tbody>
								</table>
								<div class="page-contr">
									
								</div>
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
		
		<div class="modal fade" id="email-form">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Change Email</h4>
					</div>
					
						<div class="modal-body">
							<div class="tabbable-panel">
								<div class="tab-content" id="batchdata">
									<label for="">Enter New email:</label>
									<input type="email" id="new-email" >
								</div>
							</div>
						</div>
						<div class="modal-footer">
						  <button type="submit" class="btn btn-primary email-id"  >Submit</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="mobile-form">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Change Phone Number</h4>
					</div>
					
						<div class="modal-body">
							<div class="tabbable-panel">
								<div class="tab-content" id="batchdata">
									<label for="">Enter 11 digit phone number:</label>
									<input type="number" id="new-phone" >
									<input type="hidden" id="present-phone">
								</div>
							</div>
						</div>
						<div class="modal-footer">
						  <button type="submit" class="btn btn-primary phone-id"  >Submit</button>
						  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						</div>
					
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
		
		
			$(document).ready(function(){
				$('.pass_email_page').addClass('active');
				
				$(document).on('click', '.row-action-view', function(){
					$('#onPgaeLoadingForm').html('');
					var student_id = $(this).attr('data-student');
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/view',
						data:{student_id:student_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
								sqtoken_hash = data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content).slideDown();
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
				
				
				$(document).on('click', '.reset-pass', function(){
					
					var student_id = $(this).attr('data-student');
					//alert(student_id);
					if (confirm('Are you sure you want to reset password?')) {
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/students/reset_pass',
							data:{student_id:student_id},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
								 //$('#onPgaeLoadingForm').html(data.content).slideDown();
									alert('Password Reset to 123456');
									return false;
								}else
								{
									alert(data.status)
									return false;
								}
							}
						});
					}
				});
				
				
				$(document).on('click', '.reset-gmail', function(){
					var student_id = $(this).attr('data-student');
					//alert(student_id);
					$('.email-id').val(student_id);
				});
				
				$(document).on('click', '.reset-phone', function(){
					var student_id = $(this).attr('data-student');
					var present = $(this).next().val();
					//alert(student_id);
					$('.phone-id').val(student_id);
					$('#present-phone').val(present);
				});
				
				$(document).on('click', '.phone-id', function(){
					var lenth = $("#new-phone").val().length;
					var phone = $("#new-phone").val();
					var present = $('#present-phone').val();
					var newPhone = '88' + phone;
					var student_id = $(this).val();
					if(lenth !== 11){
						alert('Phone number should be 11 digit');
						$("#new-phone").val(null);
					}else{
						if(present == newPhone){
							alert(newPhone + ' already exist. Please enter a 11 digit new number');
						}else{
							$.ajax({
								type: 'POST',
								url: baseUrl+'coordinator/students/reset_phone',
								data:{student_id:student_id, phone:newPhone},
								dataType: 'json',
								success: function(data)
								{
									if(data.status == 'ok')
									{
									 
										alert('Phone Reset to ' + data.content);
										$('#mobile-form').modal('toggle');
										
										window.location.reload();
										return false;
									}else
									{
										alert(data.status)
										return false;
									}
								}
							});
						}
					}
					
				  });
				
				$(document).on('click', '.email-id', function(){
					var student_id = $(this).val();
					var newEmail = $('#new-email').val();
					//alert(student_id);
					
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/students/reset_email',
						data:{student_id:student_id, newEmail:newEmail},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
							 
								alert('Email Reset to ' + data.content);
								$('#email-form').modal('toggle');
								return false;
							}else
							{
								alert(data.status)
								return false;
							}
						}
					});
					
				});
				
		
			});
			
		
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>