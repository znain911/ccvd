<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Setup</a></li>
				<li><a href="javascript:;">Payment Config</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Payment Config</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div class="form-cntnt">
							<h2 class="frm-title-ms">Payment Configuration</h2>
							<?php 
								$get_paymentconfig = $this->Setup_model->get_paymentconfig();
							?>
							<?php 
								$attr = array('class' => 'form-horizontal', 'id' => 'configData');
								echo form_open('#', $attr);
							?>
								<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
								<div class="form-group">
									<div class="col-md-offset-6 col-md-6">
										<div id="alert"></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Admission Fee</label>
									<div class="col-md-4">
										<input type="text" name="course_fee" value="<?php echo $get_paymentconfig['pconfig_course_fee']; ?>" placeholder="Enter Course Fee" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">ECE Retake Fee</label>
									<div class="col-md-4">
										<input type="text" value="<?php echo $get_paymentconfig['pconfig_ece_retakefee']; ?>" name="ece_retake_fee" placeholder="Enter ECE Retake Fee" class="form-control">
									</div>
								</div>
								<div class="generate-buttons text-right">
									<button class="btn btn-purple m-b-5" type="submit">Update Configuration</button>
								</div>
							<?php echo form_close(); ?>
						</div>
					</div>
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
			$("#configData").validate({
				rules:{
					course_fee:{
						required: true,
					},
					phase_retake_fee:{
						required: true,
					},
					ece_retake_fee:{
						required: true,
					},
				},
				messages:{
					course_fee:{
						required: null,
					},
					phase_retake_fee:{
						required: null,
					},
					ece_retake_fee:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/setup/update_paymentconfig",
						data : $('#configData').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#alert').html(data.success);
								$('#loader').hide();
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
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>