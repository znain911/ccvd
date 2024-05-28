<?php 
	$check_endmodule_schedule = $this->Course_model->endmodule_available_schedule($phase_lavel);
	$check_exresult = $this->Course_model->check_endmodule_result($phase_lavel);
?>
<div class="row">
	<div class="col-lg-6">
		<div class="end-module-exam">
			<div class="starter-module-exam-start">
				<div class="endmodule-exm-title">Schedule</div>
				<?php 
					$now_date = strtotime(date("Y-m-d"));
					$boking_to_date = strtotime($check_endmodule_schedule['endmschedule_to_date']);
					$boking_from_date = strtotime($check_endmodule_schedule['endmschedule_from_date']);
					if($now_date >= $boking_from_date && $now_date <= $boking_to_date):
				?>
				<div class="schedule-available text-center">
					<div class="subschdle">
						<span>From</span> <?php echo date("d M Y", strtotime($check_endmodule_schedule['endmschedule_from_date'])); ?> <span>To</span> <?php echo date("d M Y", strtotime($check_endmodule_schedule['endmschedule_to_date'])); ?>
					</div>
				</div>
				<?php else: ?>
				<h2>The schedule is unavailable now.</h2>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="end-module-exam">
			<span class="arrow-sign-to-schedule"></span>
			<div class="starter-module-exam-start">
				<div class="endmodule-exm-title">End Of Module Exam</div>
				<h2>The End of module exam will be available after scheduled by Coordinator</h2>
				<?php 
					if($check_exresult == true): 
					$total_score = $check_exresult['mdlmark_number'];
					$total_passing_score = $check_exresult['mdlmark_passing_number'];
					if($check_exresult['cmreport_status'] == '0')
					{
						$result_shw = '<span class="result-shw-failed">Failed</span>';
					}else
					{
						$result_shw = '<span class="result-shw-pass">Passed</span>';
					}
				?>
				<div class="details-ofresult">
					<p><strong>Your Score : <?php echo $total_score; ?></strong></p>
					<p><strong>Passing Score : <?php echo $total_passing_score; ?></strong></p>
					<p><strong>Result : <?php echo $result_shw; ?></strong></p>
				</div>
				<?php else: ?>
					<?php if($now_date >= $boking_from_date && $now_date <= $boking_to_date): ?>
					<a href="<?php echo base_url('student/exam/index/End-Module/Phase-C/START'); ?>" class="start-exm-btn">Start Exam</a>
					<?php else: ?>
					<button class="start-exm-btn disbale-exm-btn" disabled>Start Exam</button>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>