<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Support / Contacts</a></li>
				<li><a href="javascript:;">View Contact Messages</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">View Contact Messages</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<div id="onPgaeLoadingForm"></div>
						<?php require_once APPPATH.'modules/coordinator/views/contacts/contents.php'; ?>
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
				
				var not_data = '<tr>'+
									'<td colspan="6"><span class="not-data-found">No Data Found!</span></td>'+
								'</tr>';
				
				//View lesson
				$(document).on('click', '.row-action-view-lesson', function(){
					$('#onPgaeLoadingForm').html('');
					var lesson_id = $(this).attr('data-item');
					$.ajax({
						type : "POST",
						url : baseUrl + "coordinator/contacts/view",
						data : {contact:lesson_id, _jwar_t_kn_:sqtoken_hash},
						dataType : "json",
						beforeSend: function(){
							$('#mdlBoxLoader').show();
						},
						success : function (data) {
							if(data.status == "ok")
							{
								$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
								sqtoken_hash=data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content);
								$('#mdlBoxLoader').hide();
								return false;
							}else
							{
								//have end check.
							}
							return false;
						}
					});
				});
				
				//remove lesson
				$(document).on('click', '.remove-row-lesson', function(){
					if(confirm('Are you sure?', true))
					{
						var lesson_id = $(this).attr('data-item');
						$('.items-row-'+lesson_id).remove();
						
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
							url: baseUrl+'coordinator/contacts/del_contact',
							data:{contact:lesson_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							beforeSend: function(){
								$('#mdlBoxLoader').show();
							},
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
									$('#mdlBoxLoader').hide();
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
				
			});
		</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>