<div class="container-result-area-endmodule">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="result-ar-box">
					<h2>ECE Examination - <?php echo date("Y"); ?></h2>
					<?php if($total_score >= $total_passing_score): ?>
					<p>Congratulations! You have passed in ECE examination.</p>
					<?php endif; ?>
					<div class="details-ofright">
						<p><strong>Total Questions : <?php echo $total_questions; ?></strong></p>
						<p><strong>Total Right Answer : <?php echo $total_right_answers; ?></strong></p>
						<p><strong>Total Wrong Answer : <?php echo $total_wrong_answers; ?></strong></p>
					</div>
					<div class="details-ofresult">
						<p><strong>Your Score : <?php echo $total_score; ?></strong></p>
						<p><strong>Passing Score : <?php echo $total_passing_score; ?></strong></p>
						<p><strong>Result : <?php echo $result_shw; ?></strong></p>
					</div>
				</div>
				
				<div class="result-ar-box-back">
					<a href="<?php echo base_url('student/dashboard'); ?>">Back To Dashboard</a>
				</div>
			</div>
		</div>
	</div>
</div>