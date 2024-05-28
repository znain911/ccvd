<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="result-crtft-cgp-panel">
						<h4 class="rslt-cgp-title">Exam Result</h4>
						<div class="row">
							<div class="col-lg-9">
								<div class="name-cgp-date">
									<div class="name-crse-title">
										<strong><?php echo $this->session->userdata('full_name'); ?></strong>
										<span>(Certificate Course on Cardiovascular Disease)</span>
									</div>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="download-crtft-button">
									<strong>Download <br /> Certificate</strong>
								</div>
							</div>
						</div>
					</div>
					<div class="result-table">
						<p><strong>ALL Results</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
									<th class="text-center">Examination</th>
									<th class="text-center">Your Score</th>
									<th class="text-center">Passing Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Result</th>
									<th class="text-center">Retake</th>
									<th class="text-center">Published Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$get_items = $this->Result_model->get_module_results();
									foreach($get_items as $item):
									$phase_array = array('1' => 'CCA - 1', '2' => 'CCA - 2', '3' => 'CCA - 3','4' => 'ECE');
									$retake_times = $this->Result_model->count_retaketimes_pca($item['phase_id']);
								?>
								<tr>
									<td class="text-center"><?php echo $phase_array[$item['phase_id']]; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_number']; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_passing_number']; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_total_marks']; ?></td>
									<td class="text-center">
										<?php if($item['cmreport_status'] === '1'): ?>
										<strong style="color:#0a0">Passed</strong>
										<?php else: ?>
										<strong style="color:#F00">Failed</strong>
										<?php endif; ?>
									</td>
									<td class="text-center"><?php echo ($retake_times !== 0)? $retake_times : 'N/A'; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['cmreport_create_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					
					<br />
					
					<div class="result-table">
						<p><strong>SDT & WORKSHOP Result</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
									<th class="text-center">Examination</th>
									<th class="text-center">Your Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Published Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$get_sdt_items = $this->Result_model->get_sdt_scores();
									foreach($get_sdt_items as $item):
								?>
								<tr>
									<td class="text-center"><?php echo $item['endmschedule_title']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_score']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_total_score']; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['scrboard_published_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
								
								<?php
									$get_workshop_items = $this->Result_model->get_workshop_scores();
									foreach($get_workshop_items as $item):
								?>
								<tr>
									<td class="text-center"><?php echo $item['endmschedule_title']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_score']; ?></td>
									<td class="text-center"><?php echo $item['scrboard_total_score']; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['scrboard_published_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					
					<br />
					
					
					<div class="result-table">
						<p><strong>ECE Result</strong></p>
						<table class="table rslt-tbl-row" style="font-size: 12px">
							<thead>
								<tr>
								<th class="text-center">Examination</th>
									<th class="text-center">Your Score</th>
									<th class="text-center">Passing Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Result</th>
									<th class="text-center">Retake</th>
									<th class="text-center">Published Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
										$ece_result = $this->Result_model->get_ece_results();
										foreach($ece_result as $item):
									  $ece_retake_times = $this->Result_model->count_retaketimes_ece();
									
								?>
								<tr>
									<td class="text-center">ECE</td>
									<td class="text-center"><?php echo $item['mdlmark_number']; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_passing_number']; ?></td>
									<td class="text-center"><?php echo $item['mdlmark_total_marks']; ?></td>
									<td class="text-center">
										<?php if($item['cmreport_status'] === '1'): ?>
										<strong style="color:#0a0">Passed</strong>
										<?php else: ?>
										<strong style="color:#F00">Failed</strong>
										<?php endif; ?>
									</td>
									<td class="text-center"><?php echo ($retake_times !== 0)? $retake_times : 'N/A'; ?></td>
									<td class="text-center">
										<?php
											$time = strtotime($item['cmreport_create_date']);
											$myFormatForView = date("d F, Y", $time);
											echo $myFormatForView;
										?>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody
						</table>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>