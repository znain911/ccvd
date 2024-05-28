<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="discussion-container">
		<div class="container">
			<!-- begin row -->
			
			<div class="row">
				<div class="col-lg-12 text-right">
					<div class="navigate-to-discuss">
						<div class="btn-group btn-group-justified btn-group-raised">
							<a class="btn" href="">DISCUSSION WITH FACULTIES<div class="ripple-container"></div></a>
							<a class="btn" href="">DISCUSSION WITH COORDINATOR</a>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-3">
					<div class="conversation-sidebar">
						<div class="conv-search-user">
							<?php 
								$attr = array('class'=>'src-cnv-user-form');
								echo form_open('#', $attr)
							?>
							<input type="text" class="form-control" placeholder="Search user.." />
							<?php echo form_close(); ?>
						</div>
						<div class="sidebar-conv-users">
							<ul class="cnv-user-lists">
								<li class="cnv-user-lists-li">
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<span class="cnv-user-name">Mostak Ali</span>
								</li>
								<li class="cnv-user-lists-li active">
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<span class="cnv-user-name">Mostak Ali</span>
								</li>
								<li class="cnv-user-lists-li">
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<span class="cnv-user-name">Mostak Ali</span>
								</li>
								<li class="cnv-user-lists-li">
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<span class="cnv-user-name">Mostak Ali</span>
								</li>
								<li class="cnv-user-lists-li">
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<span class="cnv-user-name">Mostak Ali</span>
								</li>
								<li class="cnv-user-lists-li">
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<span class="cnv-user-name">Mostak Ali</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="conversation-container">
						<div class="conversation-panel">
							<div class="conversation-header">
								<h2 class="sectitle">STUDENTS TO FACULTIES DISCUSSION</h2>
							</div>
							
							<div class="conversation-lists-cntr" id="cnvParentContainer">
								<ul class="cnv-lists-step-ul" id="cnvPanel">
									<li class="cnv-lists-step-li sent-by-user">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-by-photo" />
											<span>For basic styling light padding and only horizontal dividers add</span>
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-user">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-by-photo" />
											<span>For basic styling light padding and only horizontal dividers add</span>
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-user">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-by-photo" />
											<span>For basic styling light padding and only horizontal dividers add</span>
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-user">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-by-photo" />
											<span>For basic styling light padding and only horizontal dividers add</span>
										</div>
									</li>
									<li class="cnv-lists-step-li sent-by-me">
										<div class="cnv-txt">
											<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-me-photo" />
											<span>We've opted to isolate our custom table styles.</span> 
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="send-message-input">
							<?php 
								$attr = array('class' => 'send-message-inp-form', 'id' => 'cnvSendForm');
								echo form_open('#', $attr);
							?>
							<input type="text" class="" name="cnv_text" placeholder="Type message & press enter" autocomplete="off" />
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#cnvParentContainer").scrollTop($("#cnvParentContainer").children().height());
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>