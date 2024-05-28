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
				<li><a href="javascript:;">Options Panel</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Options Panel</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div class="form-cntnt">
							<h2 class="frm-title-ms">Landing Page Banners</h2>
							<?php 
								$get_banner = $this->Setup_model->get_option_banners();
							?>
							<?php 
								$attr = array('class' => 'form-horizontal', 'id' => 'configData');
								echo form_open('#', $attr);
							?>
								<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
								<div class="row">
									<div class="col-lg-7 text-right">
										<img src="<?php echo base_url('backend/assets/tools/landing-banner-section.png'); ?>" style="height: 388px;" alt="Sample" />
									</div>
									<div class="col-lg-5">
										<div class="form-group">
											<div class="col-md-offset-6 col-md-6">
												<div id="alert"></div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 text-center control-label">Banner Section-1</label>
											<div style="margin-bottom:40px;"></div>
											<div class="col-md-6 text-right">
												<img src="<?php echo attachment_url($get_banner['option_one']); ?>" style="height: 88px;" alt="Sample" />
											</div>
											<div class="col-md-6">
												<input type="file" name="banner_section_one">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 text-center control-label">Banner Section-2</label>
											<div style="margin-bottom:40px;"></div>
											<div class="col-md-6 text-right">
												<img src="<?php echo attachment_url($get_banner['option_two']); ?>" style="height: 88px;" alt="Sample" />
											</div>
											<div class="col-md-6">
												<input type="file" name="banner_section_two">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 text-center control-label">Banner Section-3</label>
											<div style="margin-bottom:40px;"></div>
											<div class="col-md-6 text-right">
												<img src="<?php echo attachment_url($get_banner['option_three']); ?>" style="height: 88px;" alt="Sample" />
											</div>
											<div class="col-md-6">
												<input type="file" name="banner_section_three">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 text-center control-label">Banner Section-4</label>
											<div style="margin-bottom:40px;"></div>
											<div class="col-md-6 text-right">
												<img src="<?php echo attachment_url($get_banner['option_four']); ?>" style="height: 88px;" alt="Sample" />
											</div>
											<div class="col-md-6">
												<input type="file" name="banner_section_four">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 text-center control-label">Banner Section-5</label>
											<div style="margin-bottom:40px;"></div>
											<div class="col-md-6 text-right">
												<img src="<?php echo attachment_url($get_banner['option_five']); ?>" style="height: 88px;" alt="Sample" />
											</div>
											<div class="col-md-6">
												<input type="file" name="banner_section_five">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 text-center control-label">Banner Section-6</label>
											<div style="margin-bottom:40px;"></div>
											<div class="col-md-6 text-right">
												<img src="<?php echo attachment_url($get_banner['option_six']); ?>" style="height: 88px;" alt="Sample" />
											</div>
											<div class="col-md-6">
												<input type="file" name="banner_section_six">
											</div>
										</div>
										<div class="generate-buttons text-right">
											<button class="btn btn-purple m-b-5" type="submit">Save</button>
										</div>
									</div>
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
					var getFrmData = new FormData(document.getElementById('configData'));
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/setup/update_options",
						data : getFrmData,
						dataType : "json",
						cache: false,
						contentType: false,
						processData: false,
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#alert').html(data.success);
								$('#loader').hide();
								window.location.reload();
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