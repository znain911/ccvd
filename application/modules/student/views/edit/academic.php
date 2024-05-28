<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div class="edit-info-cntr">
					<div class="result-table">
						<p class="result-tbl-head"><strong>Academic Information</strong></p>
						<?php  
							$attr = array('id' => 'updateStudentAcademicInfo', 'class' => 'position-relative');
							echo form_open_multipart('', $attr);
						?>
						<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
						<div class="form-field-content">
							<table class="table" style="width:100%">
								<thead>
									<tr>
										<th>Degree</th>
										<th>Year</th>
										<th>Institue/University</th>
										<th>Marks/CGPA</th>
										<th>Certificate</th>
										<th>Delete</th>
									</tr>
								</thead>
								<?php 
									$get_academicinfo = $this->Student_model->get_academicinformation();
									if(count($get_academicinfo) !== 0):
									foreach($get_academicinfo as $academic):
								?>
								<tr>
									<td><?php echo $academic['sacinfo_degree']; ?></td>
									<td><?php echo $academic['sacinfo_year']; ?></td>
									<td><?php echo $academic['sacinfo_institute']; ?></td>
									<td><?php echo $academic['sacinfo_cgpa']; ?></td>
									<td><a href="<?php echo base_url('attachments/students/'.$academic['student_entryid'].'/'.$academic['sacinfo_certificate']); ?>" target="_blank">View Certificate</a></td>
									<td><strong class="remove-ace" data-id="<?php echo $academic['sacinfo_id']; ?>" style="color:#A00;cursor:pointer">Delete</strong></td>
								</tr>
								<?php 
									endforeach;
									else:
								?>
								<td class="text-center" colspan="6">No Data Found!</td>
								<?php endif; ?>
							</table>
							<br /><br />
							<p class="result-tbl-head"><strong>Add New Information</strong></p>
							<br />
							<div id="alert"></div>
							<div class="reg-flow-input-mrg">
								<div class="col-lg-15"><label for="">Degree</label></div>
								<div class="col-lg-15"><label for="">Year</label></div>
								<div class="col-lg-15"><label for="">Institue/University</label></div>
								<div class="col-lg-15"><label for="">Marks/CGPA</label></div>
								<div class="col-lg-15"><label for="">Certificate</label></div>
							</div>
							<div class="multiple-result-entry">
								<div id="academicresultFlow">
									<div class="reg-flow-input-mrg">
										<div class="col-lg-15"><div class="form-group"><input type="text" name="degree" class="form-control" placeholder="Degree" /></div></div>
										<div class="col-lg-15"><div class="form-group"><input type="text" name="year" class="form-control" placeholder="Year" /></div></div>
										<div class="col-lg-15"><div class="form-group"><input type="text" name="institute" class="form-control" placeholder="Institue/University" /></div></div>
										<div class="col-lg-15"><div class="form-group"><input type="text" name="cgpa" class="form-control" placeholder="Marks/CGPA" /></div></div>
										<div class="col-lg-15">
											<div class="form-group">
												<input type="file" name="certificate">
												<div class="input-group">
												  <input type="text" readonly="" class="form-control" placeholder="Upload...">
												  <span class="input-group-btn input-group-sm">
													<button type="button" class="btn btn-fab btn-fab-mini">
													  <i class="material-icons">attach_file</i>
													</button>
												  </span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-submit-btn">
							<a style="float: left;background:#f0f0f0;" href="<?php echo base_url('student/profile'); ?>" class="btn btn-danger">CANCEL</a>
							<button style="float: right;background:#f0f0f0;" type="submit" class="btn btn-danger">ADD NEW INFORMATION</button>
						</div>
						<?php echo form_close(); ?>
						<script src="<?php echo base_url('frontend/'); ?>assets/js/app.min.js"></script>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.remove-ace', function(){
				if(confirm('Are you sure?', true))
				{
					var data_id = $(this).attr('data-id');
					$('#proccessLoader').show();
					$.ajax({
						type : "POST",
						url : baseUrl + "student/delete_academic_info",
						data : {id:data_id},
						dataType : "json",
						success : function (data) {
							if(data.status == 'ok')
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);	
								$('html, body').animate({
									scrollTop: $("body").offset().top
								 }, 1000);
								 window.setTimeout(function(){
									window.location.reload();
								}, 2000);
								$('#proccessLoader').hide();
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
			})
			
			//start step 2
			$("#updateStudentAcademicInfo").validate({
				rules:{
					degree:{
						required: true,
					},year:{
						required: true,
					},institute:{
						required: true,
					},cgpa:{
						required: true,
					},
				},
				submitHandler : function () {
					$('#proccessLoader').show();
					var personalFormData = new FormData(document.getElementById('updateStudentAcademicInfo'));    
					$.ajax({
						type : "POST",
						url : baseUrl + "student/update_academic_info",
						data : personalFormData,
						dataType : "json",
						cache: false,
						contentType: false,
						processData: false,
						success : function (data) {
							if(data.status == 'ok')
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								$('#alert').html(data.success);	
								$('html, body').animate({
									scrollTop: $("body").offset().top
								 }, 1000);
								 window.setTimeout(function(){
									window.location.reload();
								}, 2000);
								$('#proccessLoader').hide();
								return false;
							}else
							{
								return false;
							}
						}
					});
				}
			}); //End step 2
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>