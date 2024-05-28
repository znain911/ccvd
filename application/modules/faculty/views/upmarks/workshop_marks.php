<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9 myac-container">
					<div class="result-table">
						<div id="ftwofScheduleLoader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
						<p class="result-tbl-head"><strong>Applied Students</strong></p>
						<table class="table" style="font-size:12px;">
							<thead>
								<tr style="color:#d00">
									<th class="text-left">SL.</th>
									<th class="text-left">Student ID</th>
									<th class="text-center">Name</th>
									<th class="text-center">Application ID</th>
									<th class="text-center">Phase Level</th>
									<th class="text-center">Exam Center</th>
									<th class="text-center">Score</th>
									<th class="text-center">Total Score</th>
									<th class="text-center">Activity</th>
									<th class="text-center">Upload Marks</th>
								</tr>
							</thead>
							<tbody id="appliedUsersContent">
								<?php 
									$applied_students = $this->Course_model->get_workshop_applied_students($schedule_id, $schedule_centershdl_id);
									$x = 1;
									foreach($applied_students as $student):
									$name = $student['spinfo_first_name'].' '.$student['spinfo_middle_name'].' '.$student['spinfo_last_name'];
									$phase_array = array('1' => 'PCA-1', '2' => 'PCA-2', '3' => 'PCA-3');
								?>
								<tr>
									<td><?php echo $x; ?></td>
									<td class="text-left"><?php echo $student['student_entryid']; ?></td>
									<td class="text-center"><?php echo $name; ?></td>
									<td class="text-center"><?php echo $student['booking_application_id']; ?></td>
									<td class="text-center"><?php echo $phase_array[$student['booking_phase_level']]; ?></td>
									<td class="text-center"><?php echo $student['center_location']; ?></td>
									<td class="text-center change-to-score-<?php echo $student['booking_id']; ?>"><?php echo ($student['scrboard_score'])? $student['scrboard_score'] : 'N/A'; ?></td>
									<td class="text-center change-to-totalscore-<?php echo $student['booking_id']; ?>"><?php echo ($student['scrboard_total_score'])? $student['scrboard_score'] : 'N/A'; ?></td>
									<td class="text-center change-to-attedance-<?php echo $student['booking_id']; ?>">
										<?php if($student['scrboard_student_attendence'] == '1'): ?>
										<strong style="color:#0a0">Present</strong>
										<?php elseif($student['scrboard_student_attendence'] == '2'): ?>
										<strong style="color:#F00">Absent</strong>
										<?php else: ?>
										N/A
										<?php endif; ?>
									</td>
									<td class="text-center change-to-completed-<?php echo $student['booking_id']; ?>">
										<?php if($student['scrboard_score']): ?>
										<span class="upspan-btn" data-completed="0" style="background:#0a0">Completed</span>
										<?php else: ?>
										<span data-completed="1" class="upspan-btn" data-mrks-type="WORKSHOP" data-booking="<?php echo $student['booking_id']; ?>" data-u="<?php echo $student['booking_user_id']; ?>">Upload Marks</span>
										<?php endif; ?>
									</td>
								</tr>
								<?php 
									$x++;
									endforeach; 
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>