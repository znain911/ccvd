<div class="container-result-area-endmodule">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="result-ar-box">
					<h2>Practice Examination Result</h2>
					<?php if($total_score >= $total_passing_score): ?>
					<p>Congratulations! You have passed in your practice examination.</p>
					<?php endif; ?>
					<div class="details-ofright">
						<p><strong>Total Questions : <?php echo $total_questions; ?></strong></p>
						<p><strong>Total Right Answer : <?php echo $total_right_answers; ?></strong></p>
						<p><strong>Total Wrong Answer : <?php echo $total_wrong_answers; ?></strong></p>
					</div>
					<?php 
						$wrong_answers = $this->Exam_model->get_wrong_answer($this->session->userdata('practice_exam_id'));
						if(count($wrong_answers) !== 0):
						$w_sl = 1;
						foreach($wrong_answers as $answer):
						if($answer['question_type'] == 'JUSTIFY')
						{
							
							$right_answer = $answer['question_justify_answer'];
							
						}elseif($answer['question_type'] == 'MCQ'){
							
							$right_ans_ids = $this->Exam_model->get_right_answersids($answer['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Exam_model->get_answer_titleby_id($answer_id);
								$r_answer .= $get_answer_title['answer_title'].', ';
							}
							$right_answer = $r_answer;
						}elseif($answer['question_type'] == 'BLANK'){
							$right_ans_ids = $this->Exam_model->get_right_answersids($answer['question_id']);
							$right_answer_string = str_replace('[', '', $right_ans_ids['question_right_answerid']);
							$right_answer_string = str_replace(']', '', $right_answer_string);
							$right_answer_string = explode(',', $right_answer_string);
							$answer_array = $right_answer_string;
							$r_answer = '';
							foreach($answer_array as $answer_id)
							{
								$get_answer_title = $this->Exam_model->get_answer_titleby_id($answer_id);
								$r_answer .= $get_answer_title['answer_title'].', ';
							}
							$right_answer = $r_answer;
						}
					?>
					<div class="details-ofright">
						<div class="single-question">
							<strong class="question-li"><span style="color:#f00"><?php echo $w_sl; ?>.</span> <?php echo $answer['question_title']; ?></strong> <br />
							<p class="text-left" style="padding-left: 15px;font-size: 13px;"><strong style="color:#F00">Right Answer : </strong> <?php echo $right_answer; ?></p>
						</div>
					</div>
					<?php 
						$w_sl++;
						endforeach; 
					?>
					<?php endif; ?>
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