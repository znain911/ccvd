<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<br />
					<div class="result-table">
						<p style="padding:10px;margin:0;text-align:center"><strong>List Of Evaluations</strong></p>
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
							<table class="table rslt-tbl-row" style="font-size: 12px">
								<thead>
									<tr>
										<th class="text-center">SL.</th>
										<th class="text-center">Faculty</th>
										<th class="text-center">Title</th>
										<th class="text-center">Submit Date</th>
										<th class="text-center">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$sl = 1;
										foreach($get_items as $evaluation):
										$faculty_name = $evaluation['tpinfo_first_name'].' '.$evaluation['tpinfo_middle_name'].' '.$evaluation['tpinfo_last_name'];
									?>
									<tr>
										<td><?php echo $sl; ?></td>
										<td><?php echo $faculty_name; ?></td>
										<td><?php echo $evaluation['evaluation_title']; ?></td>
										<td class="text-center"><?php echo date("d F, Y", strtotime($evaluation['evaluation_create_date'])); ?></td>
										<td class="text-center"><span data-evl-id="<?php echo $evaluation['evaluation_id']; ?>" class="view-rating" style="cursor:pointer;display: inline-block;background: #0a0;color: #FFF;padding: 0 8px;font-size: 11px;border-radius: 5%;" data-target="#viewStudentRatings" data-toggle="modal"><i class="fa fa-eye"></i> View</span></td>
									</tr>
									<?php 
										$sl++;
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
			</div>
		</div>
	</div>
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
				url: '<?php echo base_url(); ?>evalapi/get_evaluations_by_students/'+page_num,
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
	<script type="text/javascript">
		$(document).ready(function(){
			$(document).on('click', '.view-rating', function(){
				var evl_id = $(this).attr('data-evl-id');
				$.ajax({
					type: 'POST',
					url: baseUrl + 'evalapi/view_student_evaluation',
					data:{evl_id:evl_id},
					dataType:'json',
					success: function (data) {
						if(data.status == 'ok')
						{
							$('#viewStudentRatingsContent').html(data.content);
							sqtoken_hash = data._jwar_t_kn_;
						}else
						{
							return false;
						}
					}
				});
			});
		});
	</script>
<?php require_once APPPATH.'modules/common/footer.php'; ?>