<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Evaluation</a></li>
				<li><a href="javascript:;">Evaluations (Students)</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Evaluations (Students)</h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12 mostak-mdl-box">
					<div id="mdlBoxLoader"><img src="<?php echo base_url('backend/assets/tools/loader.gif'); ?>" alt="" /></div>
					<div id="moduleLessonDisplay">
						<!-- begin widget -->
						<div id="onPgaeLoadingForm"></div>
						<div class="widget p-0">
							<div class="table-responsive">
								<div class="filtar-bar">
									<div class="limit-box">
										<p>
											<span>Sort By : &nbsp;&nbsp;</span>
											<select id="sortby" onchange="searchFilter()">
												<option value="DESC" selected="selected">New Evaluations</option>
												<option value="ASC">Old Evaluations</option>
											</select>
										</p>
									</div>
									<div class="limit-box" style="margin-left: 10px;">
										<p>
											<?php 
												$months = array(
																	'01' => 'January',
																	'02' => 'February',
																	'03' => 'March',
																	'04' => 'April',
																	'05' => 'May',
																	'06' => 'June',
																	'07' => 'July',
																	'08' => 'August',
																	'09' => 'September',
																	'10' => 'October',
																	'11' => 'November',
																	'12' => 'December',
																);
											?>
											<select name="month" id="month" onchange="searchFilter()">
												<option value="" selected="selected">All</option>
												<?php 
													foreach($months as $key => $month):
												?>
														<option value="<?php echo $key; ?>"><?php echo $month; ?></option>
												<?php
													endforeach;
												?>
											</select>
										</p>
									</div>
									<div class="limit-box" style="margin-left: 10px;">
										<p>
											<?php 
												$starting_date = 2019;
												$current_year = date("Y");
											?>
											<select name="year" id="year" onchange="searchFilter()">
												<option value="" selected="selected">All</option>
												<?php 
													for($i=$starting_date; $i < $current_year + 2;$i++):
												?>
														<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
												<?php
													endfor;
												?>
											</select>
										</p>
									</div>
									<div class="search-box">
										<p><input type="text" id="keywords" placeholder="Search..." onkeyup="searchFilter()"/></p>
									</div>
								</div>
								<div id="postList">
									<table class="table table-td-valign-middle m-b-0">
										<thead>
											<tr>
												<th>SL.</th>
												<th>Student</th>
												<th>Title</th>
												<th>Evaluated By</th>
												<th class="text-center">Date</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody class="appnd-not-fnd-row">
											<?php
												$inc = 1;
												foreach($get_items as $item):
											?>
											<tr class="cnt-row items-row-<?php echo $item['evaluation_id']; ?>">
												<td class="text-left"><?php echo $inc; ?></td>
												<td class="text-left"><?php echo $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name']; ?> (<?php echo $item['student_entryid']; ?>)</td>
												<td class="text-left"><?php echo string_wrapper($item['evaluation_title'], 8); ?></td>
												<td class="text-left"><?php echo $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name']; ?> (<?php echo $item['teacher_entryid']; ?>)</td>
												<td class="text-center">
													<?php
														$time = strtotime($item['evaluation_create_date']);
														$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
														echo $myFormatForView;
													?>
												</td>
												<td>
													<button data-item="<?php echo $item['evaluation_id']; ?>" class="row-action-view-lesson btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
													<button data-item="<?php echo $item['evaluation_id']; ?>" class="remove-row-lesson btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-trash"></i> Delete</button>
												</td>
											</tr>
											<?php 
												$inc++;
												endforeach; 
											?>
										</tbody>
									</table>
									<div class="page-contr">
										<?php echo $this->ajax_pagination->create_links(); ?>
									</div>
								</div>
							</div>
						</div>
						<!-- end widget -->
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
						url : baseUrl + "coordinator/evaluation/view",
						data : {evaluation:lesson_id, _jwar_t_kn_:sqtoken_hash},
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
							url: baseUrl+'coordinator/evaluation/del_evaluation',
							data:{evaluation:lesson_id, _jwar_t_kn_:sqtoken_hash},
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
		<script type="text/javascript">
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var sortby = $('#sortby').val();
			var limit = $('#limit').val();
			var month = $('#month').val();
			var year = $('#year').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>evalapi/get_coordinator_evaluations_by_faculties/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&sortby='+sortby+'&limit='+limit+'&month='+month+'&year='+year+'&_jwar_t_kn_='+sqtoken_hash,
				dataType:'json',
				beforeSend: function () {
					
				},
				success: function (data) {
					if(data.status == 'ok')
					{
						$('#postList').html(data.content);
						sqtoken_hash = data._jwar_t_kn_;
					}else
					{
						return false;
					}
				}
			});
		}
	</script>
<?php require_once APPPATH.'modules/coordinator/templates/footer.php'; ?>