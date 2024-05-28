<?php require_once APPPATH.'modules/coordinator/templates/header.php'; ?>
		<!-- end #header -->
		
		<!-- begin #sidebar -->
		<?php require_once APPPATH.'modules/coordinator/templates/sidebar.php'; ?>
		
		<!-- begin #content -->
		<div id="content" class="content">
			<!-- begin breadcrumb -->
			<ol class="breadcrumb pull-right">
				<li><a href="javascript:;">Home</a></li>
				<li><a href="javascript:;">Manage Faculties</a></li>
				<li><a href="javascript:;">Pending Faculties</a></li>
			</ol>
			<!-- end breadcrumb -->
			<!-- begin page-header -->
			<h1 class="page-header">Pending Faculties : <span id="totalPendingFaculties"><?php echo count($get_items) ?></span></h1>
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- end col-4 -->
				<!-- begin col-4 -->
				<div class="col-md-12">
					<!-- begin widget -->
					<div id="onPgaeLoadingForm"></div>
					<div class="widget p-0">
						<div class="table-responsive">
							<div class="filtar-bar">
								<div class="limit-box">
									<p>
										<span>Sort By : &nbsp;&nbsp;</span>
										<select id="sortby" onchange="searchFilter()">
											<option value="DESC" selected="selected">New Faculties</option>
											<option value="ASC">Old Faculties</option>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<span>Show : &nbsp;&nbsp;</span>
										<?php 
											$value_array = array(10,20,30,40,50,60,70,80,90,100);
										?>
										<select name="limit" id="limit" onchange="searchFilter()">
											<option value="10" selected="selected">10</option>
											<?php 
												foreach($value_array as $array):
											?>
													<option value="<?php echo $array; ?>" <?php echo (isset($_GET['limit']) && $_GET['limit'] == $array)? 'selected' : null; ?>><?php echo $array; ?></option>
											<?php
												endforeach;
											?>
										</select>
									</p>
								</div>
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<span>From : &nbsp;&nbsp;</span>
										<input type="text" name="from" id="fromDate" onload="clearThis(this.value)" class="custominp daterange-singledate-from" placeholder="From" />
									</p>
								</div>
								<div class="limit-box">
									<p>
										<span>To : &nbsp;&nbsp;</span>
										<input type="text" name="to" id="toDate" onload="clearThis(this.value)" class="custominp daterange-singledate-to" placeholder="To" />
										<input type="submit" value="Search By Date" onclick="searchFilter()" style="height: 32px;" />
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
											<option value="" selected="selected">Month</option>
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
											<option value="" selected="selected">Year</option>
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
								<div class="limit-box" style="margin-left: 10px;">
									<p>
										<select name="country" id="country" onchange="searchFilter()">
											<option value="" selected="selected">Country</option>
											<option value="18">Bangladesh</option>
											<option value="101">India</option>
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
											<th nowrap>#ID</th>
											<th class="text-center">Photo</th>
											<th class="text-center">Full Name</th>
											<th class="text-center">Register Date</th>
											<th class="text-center">Status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if(count($get_items) !== 0):
											foreach($get_items as $item):
											$photo = base_url('attachments/faculties/'.$item['teacher_entryid'].'/'.$item['tpinfo_photo']);
											if($item['tpinfo_middle_name'])
											{
												$full_name = $item['tpinfo_first_name'].' '.$item['tpinfo_middle_name'].' '.$item['tpinfo_last_name'];
											}else
											{
												$full_name = $item['tpinfo_first_name'].' '.$item['tpinfo_last_name'];
											}
										?>
										<tr class="items-row-<?php echo $item['teacher_id']; ?>">
											<td><?php echo $item['teacher_entryid']; ?></td>
											<?php if($item['tpinfo_photo']): ?>
											<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
											<?php else: ?>
											<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
											<?php endif; ?>
											<td class="text-center"><?php echo $full_name; ?></td>
											<td class="text-center"><?php echo date("d M, Y", strtotime($item['teacher_regdate'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['teacher_regdate'])); ?></td>
											<td class="text-center item-row-status-<?php echo $item['teacher_id']; ?>">
												<?php if($item['teacher_status'] === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>
												<?php else: ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button data-student="<?php echo $item['teacher_id']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
												<span class="row-action-status-holder-<?php echo $item['teacher_id']; ?>">
													<?php if($item['teacher_status'] === '0'): ?>
													<button data-status="1" data-student="<?php echo $item['teacher_id']; ?>" class="row-action-status btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Approve</button>
													<?php else: ?>
													<button data-status="0" data-student="<?php echo $item['teacher_id']; ?>" class="row-action-status btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button>
													<?php endif; ?>
												</span>
												<button data-student="<?php echo $item['teacher_id']; ?>" onclick="return confirm('Are you sure?', true);" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
											</td>
										</tr>
										<?php endforeach; ?>
										<?php else: ?>
										<tr>
											<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
										</tr>
										<?php endif; ?>
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
				$(document).on('click', '.row-action-view', function(){
					$('#onPgaeLoadingForm').html('');
					var teacher_id = $(this).attr('data-student');
					$.ajax({
						type: 'POST',
						url: baseUrl+'coordinator/faculties/view',
						data:{teacher_id:teacher_id, _jwar_t_kn_:sqtoken_hash},
						dataType: 'json',
						success: function(data)
						{
							if(data.status == 'ok')
							{
								sqtoken_hash = data._jwar_t_kn_;
								$('#onPgaeLoadingForm').html(data.content).slideDown();
								return false;
							}else
							{
								return false;
							}
						}
					});
				})
				
				$(document).on('click', '.row-action-status', function(){
					var teacher_id = $(this).attr('data-student');
					var status_approve = '<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>';
					var status_decline = '<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Declined</span>';
					var staus = $(this).attr('data-status');
					var staus_action_approve = '<button data-status="1" data-student="'+teacher_id+'" class="row-action-status btn btn-default btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-cog"></i> Approve</button>';
					var staus_action_declined = '<button data-status="0" data-student="'+teacher_id+'" class="row-action-status btn btn-danger btn-xs btn-rounded p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button>';
					if(staus == '1')
					{
						$('.item-row-status-'+teacher_id).html(status_approve);
						$('.row-action-status-holder-'+teacher_id).html(staus_action_declined);
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/faculties/approve',
							data:{teacher_id:teacher_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else if(staus == '0')
					{
						$('.item-row-status-'+teacher_id).html(status_decline);
						$('.row-action-status-holder-'+teacher_id).html(staus_action_approve);
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/faculties/declined',
							data:{teacher_id:teacher_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
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
				
				$(document).on('click', '.remove-row', function(){
					var teacher_id = $(this).attr('data-student');
					if(confirm('Are you sure?', true))
					{
						$('.items-row-'+teacher_id).remove();
						$.ajax({
							type: 'POST',
							url: baseUrl+'coordinator/faculties/delete',
							data:{teacher_id:teacher_id, _jwar_t_kn_:sqtoken_hash},
							dataType: 'json',
							success: function(data)
							{
								if(data.status == 'ok')
								{
									sqtoken_hash = data._jwar_t_kn_;
									return false;
								}else
								{
									return false;
								}
							}
						});
					}else{
						return false;
					}
				});
			});
			
			function searchFilter(page_num) {
				page_num = page_num?page_num:0;
				var keywords = $('#keywords').val();
				var sortby = $('#sortby').val();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>facultyfilter/get_pending_faculty/'+page_num,
					data:'page='+page_num+'&keywords='+keywords+'&sortby='+sortby+'&_jwar_t_kn_='+sqtoken_hash,
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