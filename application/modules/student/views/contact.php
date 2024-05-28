<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="result-crtft-cgp-panel">
						<h4 class="rslt-cgp-title">CONTACT US</h4>
					</div>
					<div class="contact-address-area">
						<div class="row">
							<div class="col-lg-10">
								<div class="address-txt">
									<p>
										<!-- <span>Ibrahim Memorial Diabetes Centre</span> <br />
										<strong>Bangladesh Institute Of Health Sciences <span>(BIHS)</span></strong> -->
										<strong>Ibrahim Cardiac Hospital & Research Institute</strong>
									</p>
									<?php 
										$get_contactinfo = $this->Student_model->contact_infos();
									?>
									<div class="address-attrbt">
										<p><i class="fa fa-map-marker"></i> <?php echo $get_contactinfo['config_address']; ?></p>
										<p><i class="fa fa-phone"></i> <?php echo $get_contactinfo['config_phone']; ?></p>
										<p><i class="fa fa-envelope"></i> <?php echo $get_contactinfo['config_email']; ?></p>
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="contact-social-icons">
									<?php 
										$get_sociallink = $this->Common_model->get_footersociallink();
									?>

									<?php foreach ($get_sociallink as $slink){?>
									<a href="<?php echo $slink->link;?>" class="<?php echo $slink->title;?>" target="_blank"><i class="fa fa-<?php echo $slink->title;?>"></i></a>
									<?php }?>

									<!-- <a href="" class="facebook"><i class="fa fa-facebook"></i></a>
									<a href="" class="google"><i class="fa fa-google-plus"></i></a>
									<a href="" class="twitter"><i class="fa fa-twitter"></i></a>
									<a href="" class="linkedin"><i class="fa fa-linkedin"></i></a> -->
								</div>
							</div>
						</div>
					</div>
					
					<div class="contact-frm">
						<div class="loader disable-select" id="proccessLoader"><img src="<?php echo base_url('frontend/tools/loader.gif'); ?>" class="disable-select" alt="" /></div>
						<?php 
							$attr = array('id' => 'panelContact');
							echo form_open('', $attr);
						?>
						<div class="row">
							<div class="col-lg-12" id="alert"></div>
							<div class="col-lg-6">
								<div class="form-group">
									<input type="text" name="roll_number" class="form-control" placeholder="Roll Number" />
								</div>
								<div class="form-group">
									<input type="text" name="name" class="form-control" placeholder="Name" />
								</div>
								<div class="form-group">
									<input type="text" name="email" class="form-control" placeholder="Email Address" />
								</div>
								<div class="form-group">
									<input type="text" name="phone" class="form-control" placeholder="Phone" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<input type="text" name="subject" class="form-control" placeholder="Subject" />
								</div>
								<div class="form-group">
									<textarea name="message" class="form-control" placeholder="Message" id="" cols="30" rows="6"></textarea>
								</div>
							</div>
							<div class="col-lg-12 text-right">
								<button type="submit" class="btn btn-raised btn-success" style="width: 110px; box-shadow: 0px 0px 0px; background: rgb(0, 120, 215) none repeat scroll 0% 0%; color: rgb(255, 255, 255);">SUBMIT </button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#panelContact").validate({
				rules:{
					roll_number:{
						required: true,
					},
					name:{
						required: true,
					},
					email:{
						required: true,
					},
					phone:{
						required: true,
					},
					subject:{
						required: true,
					},
					message:{
						required: true,
					},
				},
				messages:{
					roll_number:{
						required: null,
					},
					name:{
						required: null,
					},
					email:{
						required: null,
					},
					phone:{
						required: null,
					},
					subject:{
						required: null,
					},
					message:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#proccessLoader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "student/save_contactinfo",
						data : $('#panelContact').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("panelContact").reset();
								$('#alert').html(data.content);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#proccessLoader').hide();
								return false;
							}else if(data.status == "error"){
								$('#alert').html(data.content);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#proccessLoader').hide();
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