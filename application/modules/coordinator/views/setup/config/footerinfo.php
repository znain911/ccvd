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
				<li><a href="javascript:;">Footer Informations</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Footer Informations</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div class="form-cntnt">
							<h2 class="frm-title-ms">Footer Informations</h2>
							<?php 
								$get_contactinfo = $this->Setup_model->get_footerinfo();
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
									<label class="col-md-8 control-label">Title</label>
									<div class="col-md-4">
										<input type="text" name="title" value="<?php echo $get_contactinfo['title']; ?>" placeholder="Enter title" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-8 control-label">Information</label>
									<div class="col-md-4">
										<textarea name="address" class="form-control" cols="30" rows="5"><?php echo $get_contactinfo['config_address']; ?></textarea>
									</div>
								</div>
								
								<div class="generate-buttons text-right">
									<button class="btn btn-purple m-b-5" type="submit">Update Information</button>
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
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/setup/update_footerinfo",
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