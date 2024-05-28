<?php require_once APPPATH.'modules/common/header.php'; ?>
	<?php 
		$item = $this->Student_model->get_student_info();
	?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="result-table myac-container">
						<p class="result-tbl-head"><strong>Change Password</strong></p>
						<div class="student-details-board">
							<?php 
								$attr = array('id' => 'updateStudentPassword');
								echo form_open('', $attr);
							?>
							<div id="alert"></div>
							<table style="width:100%">
								<tr>
									<td class="text-right" style="width:50%"><strong>New Password : </strong></td>
									<td style="width:30%"><input type="password" class="form-control" name="password" id="newPassword" /></td>
								</tr>
								<tr>
									<td class="text-right" style="width:50%"><strong>Confirm Password : </strong></td>
									<td style="width:30%"><input type="password" class="form-control" name="password_confirm" /></td>
								</tr>
								<tr>
									<td class="text-right" style="width:50%"></td>
									<td style="width:30%"><button type="submit" style="background:#f0f0f0" class="btn btn-danger">Change Password</button></td>
								</tr>
							</table>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			//start step 2
			$("#updateStudentPassword").validate({
				rules:{
					password:{
						required: true,
					},
					password_confirm:{
						required: true,
						equalTo: "#newPassword",
					}
				},
				submitHandler : function () {
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "student/update_password",
						data : $('#updateStudentPassword').serialize(),
						dataType : "json",
						cache: false,
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("updateStudentPassword").reset();
								$('#alert').html(data.success);
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				}
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>