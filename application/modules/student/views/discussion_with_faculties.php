<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="discussion-container">
		<div class="container">
			<!-- begin row -->
			
			<div class="row">
				<div class="col-lg-12 text-right">
					<div class="navigate-to-discuss">
						<div class="btn-group btn-group-justified btn-group-raised">
							<a class="btn <?php echo active_chat_link('with', 'Faculties'); ?>" href="<?php echo base_url('student/discussion?with=Faculties'); ?>">DISCUSSION WITH FACULTIES<div class="ripple-container"></div></a>
							<a class="btn <?php echo active_chat_link('with', 'Coordinators', true); ?>" href="<?php echo base_url('student/discussion?with=Coordinators'); ?>">DISCUSSION WITH COORDINATOR</a>
						</div>
					</div>
				</div>
			</div>
			
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
									$get_coordinators = $this->Discussion_model->get_coordinators();
									foreach($get_coordinators as $coordinator):
								?>
								<li class="cnv-user-lists-li" data-item-id="<?php echo $coordinator['owner_id']; ?>">
									<?php if($coordinator['owner_photo']): ?>
									<img src="<?php echo base_url('attachments/coordinators/'.$coordinator['owner_photo']); ?>" alt="Photo" class="cnv-usr-photo" />
									<?php else: ?>
									<img src="<?php echo base_url('backend/assets/img/user_3.jpg'); ?>" alt="Photo" class="cnv-usr-photo" />
									<?php endif; ?>
									<span class="cnv-user-name"><?php echo $coordinator['owner_name']; ?></span>
								</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<?php 
						$attr = array('class' => 'send-message-inp-form', 'id' => 'cnvSendForm');
						echo form_open('#', $attr);
					?>
					<div class="conversation-container">
						<div class="conversation-panel">
							<div class="conversation-header">
								<h2 class="sectitle">FACULTIES TO COORDINATOR DISCUSSION</h2>
							</div>
							
							<div class="conversation-lists-cntr" id="cnvParentContainer">
								<div id="loader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
								<div id="cnvPanel"></div>
							</div>
						</div>
						<div class="send-message-input">
							<input type="text" class="" id="typedText" name="cnv_text" placeholder="Type message & press enter" autocomplete="off" disabled />
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
				<!-- end col-4 -->
			</div>
			<!-- end row -->
			
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.cnv-user-lists-li', function(){
				$('.cnv-user-lists-li').removeClass('active');
				$(this).addClass('active');
				var cd = $(this).attr('data-item-id');
				$.ajax({
					type: 'POST',
					url: baseUrl+'faculty/get_conversationby_coordinator',
					data:{cd:cd, _jwar_t_kn_:sqtoken_hash},
					dataType: 'json',
					beforeSend: function(){
						$('#loader').show();
					},
					success: function(data){
						if(data.status == 'ok')
						{
							$('#typedText').removeAttr('disabled');
							$('#loader').hide();
							$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
							sqtoken_hash = data._jwar_t_kn_;
							
							check_message();
							setInterval(check_message, 1000);
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
	<script type="text/javascript">
		$(document).ready(function(){
			$("#cnvSendForm").validate({
				rules:{
					cnv_text:{
						required: true,
					},
				},
				messages:{
					cnv_text:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "faculty/sendtocoordinator",
						data : $('#cnvSendForm').serialize(),
						dataType : "json",
						success : function (data) {
							if(data.status == "ok")
							{
								$('#loader').hide();
								document.getElementById("cnvSendForm").reset();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								check_message();
								setInterval(check_message, 1000);
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
	<script type="text/javascript">
		function check_message(){
			$.ajax({
				type: 'POST',
				url: baseUrl+'faculty/conversation_between_candf',
				data:{_jwar_t_kn_:sqtoken_hash},
				dataType: 'json',
				success: function(data){
					if(data.status == 'ok')
					{
						$('#cnvPanel').html(data.content);
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						sqtoken_hash = data._jwar_t_kn_;
						$("#cnvParentContainer").scrollTop($("#cnvPanel").height());
						return false;
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>