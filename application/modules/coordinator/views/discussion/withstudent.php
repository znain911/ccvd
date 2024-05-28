<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			
			<!-- begin row -->
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
								<?php 
									$get_faculties = $this->Discussion_model->get_faculties();
									foreach($get_faculties as $faculty):
									if($faculty['tpinfo_middle_name'])
									{
										$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_middle_name'].' '.$faculty['tpinfo_last_name'];
									}else
									{
										$full_name = $faculty['tpinfo_first_name'].' '.$faculty['tpinfo_last_name'];
									}
								?>
								<li class="cnv-user-lists-li" data-item-id="<?php echo $faculty['teacher_id']; ?>">
									<?php if($faculty['tpinfo_photo']): ?>
									<img src="<?php echo base_url('attachments/faculties/'.$faculty['teacher_username'].'/'.$faculty['tpinfo_photo']); ?>" alt="Photo" class="cnv-usr-photo" />
									<?php else: ?>
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<?php endif; ?>
									<span class="cnv-user-name"><?php echo $full_name; ?></span>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="conversation-container">
						<div class="conversation-panel">
							<div class="conversation-header">
								<h2 class="sectitle">COORDINATOR TO STUDENTS DISCUSSION</h2>
							</div>
							
							<div class="conversation-lists-cntr" id="cnvParentContainer">
								<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
								<ul class="cnv-lists-step-ul" id="cnvPanel">
									
								</ul>
							</div>
						</div>
						<div class="send-message-input">
							<?php 
								$attr = array('class' => 'send-message-inp-form', 'id' => 'cnvSendForm');
								echo form_open('#', $attr);
							?>
							<input type="text" class="form-control" name="cnv_text" placeholder="Type message & press enter" autocomplete="off" />
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
			$(document).ready(function(){
				$("#cnvParentContainer").scrollTop($("#cnvParentContainer").children().height());
			});
		</script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.cnv-user-lists-li', function(){
					$('.cnv-user-lists-li').removeClass('active');
					$(this).addClass('active');
					var faculty = $(this).attr('data-item-id');
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/discussion/get_conversationby_faculty',
						data:{faculty:faculty, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#loader').show();
						},
						success: function(data){
							if(data.status == 'ok')
							{
								$('#cnvPanel').html(data.content);
								$('#loader').hide();
								sqtoken_hash = data._jwar_t_kn_;
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>