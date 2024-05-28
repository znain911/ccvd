<!-- begin widget -->
<div id="onPgaeLoadingForm">
	<?php require_once APPPATH.'modules/coordinator/views/questions/create_form.php'; ?>
</div>
<div class="widget p-0">
	<div class="table-responsive">
		<form id="submitOnchange" accept-charset="utf-8" method="get" action="">
			<div class="row-filter-bar">
				<div class="col-lg-7">
					<div class="left-filt">
						<div class="sort-limit">
							<?php 
								$value_array = array(10,20,30,40,50,60,70,80,90,100);
							?>
							<select name="limit" id="limit" class="form-control">
								<option value="10" selected="selected">10</option>
								<?php 
									foreach($value_array as $array):
								?>
										<option value="<?php echo $array; ?>" <?php echo (isset($_GET['limit']) && $_GET['limit'] == $array)? 'selected' : null; ?>><?php echo $array; ?></option>
								<?php
									endforeach;
								?>
							</select>
						</div>
						<div class="sorting">
							<select name="sorting" id="sorting" class="form-control">
								<option value="">Sort By</option>
								<option value="title" <?php echo (isset($_GET['sorting']) && $_GET['sorting'] == 'title')?  'selected' : null; ?>>Title</option>
								<option value="module" <?php echo (isset($_GET['sorting']) && $_GET['sorting'] == 'module')?  'selected' : null; ?>>Module</option>
								<option value="phase" <?php echo (isset($_GET['sorting']) && $_GET['sorting'] == 'phase')?  'selected' : null; ?>>Phase</option>
							</select>
						</div>
						<?php
							$pca_level = array(
											'All' => 'All',
											'1' => 'Phase A',
											'2' => 'Phase B',
											'3' => 'Phase C',
										);
						?>
						<div class="sorting">
							<select name="phaseLevel" id="pLevel" class="form-control">
								<?php foreach($pca_level as $lavel => $value): ?>
								<option value="<?php echo $lavel; ?>" <?php echo (isset($_GET['phaseLevel']) && $_GET['phaseLevel'] == $lavel)? 'selected' : null; ?>><?php echo $value; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php 
							$q_types = array(
												'All' => 'All',
												'MCQ' => 'MCQ',
												'BLANK' => 'Fill in the blanks',
												'JUSTIFY' => 'True Or False',
												'MULTIPLE_JUSTIFY' => 'Multiple Justify',
											);
						?>
						<div class="sorting">
							<select name="questionType" id="questionType" class="form-control">
								<?php foreach($q_types as $type => $value): ?>
								<option value="<?php echo $type; ?>" <?php echo (isset($_GET['questionType']) && $_GET['questionType'] == $type)? 'selected' : null; ?>><?php echo $value; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="sorting">
							<select name="sortType" id="sortType" class="form-control">
								<option value="DESC" selected="selected" <?php echo(isset($_GET['sortType']) && $_GET['sortType'] == 'DESC')? 'selected':null; ?>>Descending</option>
								<option value="ASC" <?php echo(isset($_GET['sortType']) && $_GET['sortType'] == 'ASC')? 'selected':null; ?>>Ascending</option>
							</select>
						</div>
						<div style="display:block;clear:both;"></div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="filter-bar">
						<input type="text" class="form-control" value="<?php echo (isset($_GET['src']))? $_GET['src'] : null; ?>" style="width: 192px; float: left;" name="src" placeholder="Search..." />
						<input type="submit" style="border: 0px none; padding: 7px 10px;" value="submit" />
					</div>
				</div>
				<div style="display:block;clear:both;"></div>
			</div>
		</form>
		<div id="getContents">
			<table class="table table-td-valign-middle m-b-0">
				<thead>
					<tr>
						<th class="text-center" style="width:30%">Title</th>
						<th class="text-center">Q.Type</th>
						<th class="text-center">Chapter Level</th>
						<th class="text-center">Module</th>
						<th class="text-center">Lesson</th>
						<th class="text-center">Create Date</th>
						<th class="text-center">Created By</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
						
						$url_param = '';
						if(isset($_GET['src'])){
							$src = html_escape($_GET['src']);
							$url_param .= '&src='.$src;
						}else
						{
							$src = null;
						}
						if(isset($_GET['sortType']))
						{
							$sortType = $_GET['sortType'];
							$url_param .= '&sortType='.$sortType;
						}else
						{
							$sortType = null;
						}
						if(isset($_GET['sorting']))
						{
							$sorting = $_GET['sorting'];
							$url_param .= '&sorting='.$sorting;
						}else
						{
							$sorting = null;
						}
						if(isset($_GET['phaseLevel']))
						{
							$phaseLevel = $_GET['phaseLevel'];
							$url_param .= '&phaseLevel='.$phaseLevel;
						}else
						{
							$phaseLevel = null;
						}
						if(isset($_GET['questionType']))
						{
							$questionType = $_GET['questionType'];
							$url_param .= '&questionType='.$questionType;
						}else
						{
							$questionType = null;
						}
					
						/*-----Pagination---------*/
						$config['page_query_string'] = TRUE;
						$config["base_url"] = base_url('coordinator/questions/module'.'?prm=true'.$url_param);
						$config["total_rows"] = $this->Questions_model->count_questions($src, $phaseLevel, $questionType);
						if(isset($_GET['limit']) && is_numeric($_GET['limit']))
						{
							$config["per_page"] = intval($_GET['limit']);
						}else
						{
							$config["per_page"] = 10;
						}
						if(isset($_GET['per_page']) && is_numeric($_GET['per_page'])){
							$page = $_GET['per_page'];
						}else{
							$page = 0;
						}
						
						$this->pagination->initialize($config);
						$get_items = $this->Questions_model->get_modules_questions($src, $sorting, $sortType, $phaseLevel, $questionType, intval($page), $config["per_page"]);
						$pagination_links = $this->pagination->create_links();
						/*-----./Pagination---------*/
					?>
				
					<?php
					if(count($get_items) !== 0):
					foreach($get_items as $item):
					?>
					<tr class="cnt-row items-row-<?php echo $item['question_id']; ?>">
						<td class="text-center"><?php echo $item['question_title']; ?></td>
						<td class="text-center"><?php echo $q_types[$item['question_type']]; ?></td>
						<td class="text-center"><?php echo $item['phase_name']; ?></td>
						<td class="text-center"><?php echo $item['module_name']; ?></td>
						<td class="text-center"><?php echo $item['lesson_position']; ?></td>
						<td class="text-center">
							<?php
								$time = strtotime($item['question_create_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						<td class="text-center"><?php echo $item['owner_name']; ?></td>
						<td class="text-center">
							<a style="display:inline" href="#modal-without-animation-question" data-question="<?php echo $item['question_id']; ?>" data-q-type="<?php echo $item['question_type']; ?>" class="view-qstion btn btn-block btn-success btn-xs p-l-10 p-r-10" data-toggle="modal"><i class="fa fa-eye"></i> View</a>
							<button data-id="<?php echo $item['question_id']; ?>" data-q-type="<?php echo $item['question_type']; ?>" class="row-action-edit btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-pencil"></i> Edit</button>
							<button data-id="<?php echo $item['question_id']; ?>" data-q-type="<?php echo $item['question_type']; ?>" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Delete</button>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
					<td colspan="6" class="text-center">No Data Found!</td>
					<?php endif; ?>
				</tbody>
			</table>
			<div class="pagination-links pull-right">
				<?php echo $pagination_links; ?>
			</div>
		</div>
	</div>
</div>
<!-- end widget -->