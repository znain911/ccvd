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
				<li><a href="javascript:;">Coordinators</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Coordinators</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<?php require_once APPPATH.'modules/coordinator/views/setup/coordinators/contents.php'; ?>
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
		<div class="modal" id="modal-without-animation">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
						<h4 class="modal-title">Change Password</h4>
					</div>
					<div class="modal-body">
						<?php 
							$attr = array('id' => 'upPassrf');
							echo form_open('#', $attr);
						?>
							<div id="UpPloader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
							<input type="hidden" id="adminCheck" name="admin" />
							<div class="form-group">
								<label for="Password">Password</label>
								<input type="password" class="form-control" name="password" id="Password" placeholder="6 - 15 Characters">
							</div>
							<div class="form-group">
								<label for="RePassword">Re-Password</label>
								<input type="password" class="form-control" name="repass" placeholder="6 - 15 Characters">
							</div>
							<button type="submit" class="btn btn-primary waves-effect waves-light w-md">Update Password</button>
						</form>
					</div>
					<div class="modal-footer">
						<a href="javascript:;" class="btn btn-default width-100" data-dismiss="modal">Close</a>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$(document).ready(function(){
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				$(document).on('click', '.remove-row', function(){
					if(confirm('Are you sure?', true))
					{
						var id = $(this).attr('data-id');
						$('.items-row-'+id).remove();
						if(document.querySelector('.cnt-row'))
						{
							var total_row = document.querySelector('.cnt-row').length + 1;
						}else
						{
							var total_row = 1;
						}
						
						if(total_row == 1)
						{
							$('.appnd-not-fnd-row').html(not_data);
						}
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/setup/coordinators_delete',
							data:{id:id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function()
							{
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									if(document.querySelector('.form-number-'+id))
									{
										$('.form-number-'+id).remove();
										$('#onPgaeLoadingForm').html(data.content);
									}
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
									
									$("#createData").validate({
										rules:{
											title:{
												required: true,
											},
										},
										messages:{
											title:{
												required: null,
											},
										},
										submitHandler : function () {
											$('#loader').show();
											var getFrmData = new FormData(document.getElementById('createData'));
											// your function if, validate is success
											$.ajax({
												type : "POST",
												url : baseUrl + "coordinator/setup/coordinators_create",
												data : getFrmData,
												dataType : "json",
												cache: false,
												contentType: false,
												processData: false,
												success : function (data) {
													if(data.status == "ok")
													{
														document.getElementById("createData").reset();
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
														$('#alert').html(data.success);
														$('#loader').hide();
														$('#getContents').html(data.content);
														$('#data-table').DataTable();
														return false;
													}else if(data.status == "error"){
														$('#alert').html(data.error);
														$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
														sqtoken_hash=data._jwar_t_kn_;
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
				});
				
				$(document).on('click', '.btn-remove-form', function(){
					$(this).parent().parent().parent().hide();
					$('.display-crtbtn').show();
				});
				
				$(document).on('click', '.display-create-frm', function(){
					$(this).parent().hide();
					$('.form-cntnt').show();
				});
				
				$(document).on('click', '.row-action-edit', function(){
					$('#onPgaeLoadingForm').html('');
					var id = $(this).attr('data-id');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/setup/coordinators_edit",
						data:{id:id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#onPgaeLoadingForm').html(data.content);
								
								$("#updateData").validate({
									rules:{
										title:{
											required: true,
										},
									},
									messages:{
										title:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										var getFrmData = new FormData(document.getElementById('updateData'));
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/setup/coordinators_update",
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
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
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
								$('#mdlBoxLoader').hide();
								sqtoken_hash = data._jwar_t_kn_;
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								$('#data-table').DataTable();
								return false;
							}else
							{
								return false;
							}
						}
					});
				});
				
				$(document).on('click', '.retrive-create-again', function(){
					var id = $(this).attr('data-id');
					$.ajax({
						type: "POST",
						url: baseUrl + "coordinator/setup/coordinators_create_item",
						data:{_jwar_t_kn_:sqtoken_hash, id:id},
						dataType: 'json',
						beforeSend: function()
						{
							$('#mdlBoxLoader').show();
						},
						success: function(data)
						{
							if(data.status == 'ok')
							{
								$('#onPgaeLoadingForm').html(data.content);
								sqtoken_hash = data._jwar_t_kn_;
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								
								$("#createData").validate({
									rules:{
										title:{
											required: true,
										},
									},
									messages:{
										title:{
											required: null,
										},
									},
									submitHandler : function () {
										$('#loader').show();
										var getFrmData = new FormData(document.getElementById('createData'));
										// your function if, validate is success
										$.ajax({
											type : "POST",
											url : baseUrl + "coordinator/setup/coordinators_create",
											data : getFrmData,
											dataType : "json",
											cache: false,
											contentType: false,
											processData: false,
											success : function (data) {
												if(data.status == "ok")
												{
													document.getElementById("createData").reset();
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
													$('#alert').html(data.success);
													$('#loader').hide();
													$('#getContents').html(data.content);
													$('#data-table').DataTable();
													return false;
												}else if(data.status == "error"){
													$('#alert').html(data.error);
													$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
													sqtoken_hash=data._jwar_t_kn_;
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
								$('#mdlBoxLoader').hide();
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
			$("#createData").validate({
				rules:{
					title:{
						required: true,
					},
				},
				messages:{
					title:{
						required: null,
					},
				},
				submitHandler : function () {
					$('#loader').show();
					var getFrmData = new FormData(document.getElementById('createData'));
					// your function if, validate is success
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/setup/coordinators_create",
						data : getFrmData,
						dataType : "json",
						cache: false,
						contentType: false,
						processData: false,
						success : function (data) {
							if(data.status == "ok")
							{
								document.getElementById("createData").reset();
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#alert').html(data.success);
								$('#loader').hide();
								$('#getContents').html(data.content);
								$('#data-table').DataTable();
								return false;
							}else if(data.status == "error"){
								$('#alert').html(data.error);
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
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
		<script type="text/javascript">
			$(document).ready(function(){
				$(document).on('click', '.row-action-change-password', function(){
					var get_admin = $(this).attr('data-id');
					$('#adminCheck').val(get_admin);
				})
				
				$("#upPassrf").validate({
					rules:{
						password:{
							required: true,
							minlength: 5,
						},
						repass:{
							required: true,
							minlength: 5,
							equalTo: "#Password",
						},
					},
					submitHandler : function () {
						$('#UpPloader').show();
						var getFrmData = new FormData(document.getElementById('upPassrf'));
						// your function if, validate is success
						$.ajax({
							type : "POST",
							url : baseUrl + "coordinator/setup/coordinators_change_password",
							data : getFrmData,
							dataType : "json",
							cache: false,
							contentType: false,
							processData: false,
							success : function (data) {
								if(data.status == "ok")
								{
									document.getElementById("upPassrf").reset();
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									sqtoken_hash=data._jwar_t_kn_;
									$('#UpPloader').hide();
									$('#getContents').html(data.content);
									$('#data-table').DataTable();
									$('#modal-without-animation').modal('hide');
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
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>