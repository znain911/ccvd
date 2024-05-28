<?php $gte_questions = $this->Exam_model->get_practice_question($phase_level, $module_id, $lesson_id, $question_type, $limit);?>
<input type="hidden" name="module" value="<?php echo $module_id; ?>" />
<input type="hidden" name="lesson" value="<?php echo $lesson_id; ?>" />
<input type="hidden" name="active_phase" value="<?php echo $phase_level; ?>" />
<div id="loader"><img src="<?php echo base_url('frontend/exam/tools/loader.gif'); ?>" /></div>
<div class="container-question-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<section class="jd-slider example">
					<div class="slide-inner">
						<ul class="slide-area">
							<li>
								<?php 
									$sl_number = 0;
									$ttl_elmnt = count($gte_questions);
									foreach($gte_questions as $key => $question): 
									
									if(!in_array($question['question_type'], $question_type))
									{
										continue;
									}
									
									if($question['question_right_answerid'])
									{
										$right_answer_string = json_decode($question['question_right_answerid'], true);
										$answer_count = count($right_answer_string);
										
										if($answer_count > 1)
										{
											$has_multiple_answer = 1;
										}else
										{
											$has_multiple_answer = 0;
										}
									}
									
									$q_no = $sl_number+1;
								?>
								<div class="question">
									<p class="question-n"><strong>Question <?php echo $q_no; ?>: </strong> <?php echo $question['question_title']; ?></p>
									<input type="hidden" name="question_row[]" value="<?php echo $q_no; ?>" />
									<input type="hidden" name="question_row_value_<?php echo $q_no; ?>" value="<?php echo $question['question_id']; ?>" />
									<?php if($question['question_type'] == 'MCQ'){ ?>
										<input type="hidden" name="has_multiple_answer_row_<?php echo $q_no; ?>" value="<?php echo $has_multiple_answer; ?>" />
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />
										<div class="anser-lists">
											<ul>
												<li>
													<?php
														$mcq_answers = $this->Exam_model->get_question_answers($question['question_id']);
														$alpha = 'a';
														if($has_multiple_answer == 1)
														{
															echo '<span class="sel-list-lbl">You have to select more than 1 answer.</span>';
														}
														foreach($mcq_answers as $ans):
														if($ans['answer_title'] == '')
														{
															continue;
														}
														if($has_multiple_answer == 1):
													?>
													<label class="ansr-q"><input type="checkbox" name="q_answer_row_<?php echo $q_no; ?>_row[]" value="<?php echo $ans['answer_id']; ?>" /> <?php echo $ans['answer_title']; ?></label> <br />
													<?php else: ?>
													<label class="ansr-q"><input type="radio" name="q_answer_row_<?php echo $q_no; ?>" value="<?php echo $ans['answer_id']; ?>" /> <?php echo $ans['answer_title']; ?></label> <br />
													<?php
														endif;
														$alpha++;
														endforeach; 
													?>
												</li>
											</ul>
										</div>
									<?php }elseif($question['question_type'] == 'BLANK'){ ?>
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />	
										<div class="anser-lists">
											<p class="blank_ans_field">
												<?php 
													$alpha = 'a';
													foreach($right_answer_string as $ans_id):
												?>
												(<?php echo $alpha; ?>)<input type="text" name="blank_ans_field_<?php echo $q_no; ?>_row[]" value="" /> &nbsp;&nbsp;&nbsp;
												<?php
													$alpha++;
													endforeach;
												?>
											</p>
											<span class="sel-list-lbl">Select the right answer from the list below & fill up the blank.</span>
											<ul>
												<li class="blank-answer-li">
													<?php
														$blank_answers = $this->Exam_model->get_question_answers($question['question_id']);
														$psn = 0;
														foreach($blank_answers as $ans):
														if($ans['answer_title'] == '')
														{
															continue;
														}
													?>
													<span><i class="fa fa-circle"></i> <?php echo $ans['answer_title']; ?></span> <br />
													<input type="hidden" name="q_blank_<?php echo $q_no; ?>_ans[]" value="<?php echo $ans['answer_title']; ?>" />
													<?php 
														$psn++;
														endforeach; 
													?>
												</li>
											</ul>
										</div>
											
									<?php }elseif($question['question_type'] == 'JUSTIFY'){ ?>
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />
										<div class="anser-lists">
											<ul>
												<li>
													<label class="ansr-q"><input type="radio" name="q_answer_row_<?php echo $q_no; ?>" value="1" /> True</label> <br />
													<label class="ansr-q"><input type="radio" name="q_answer_row_<?php echo $q_no; ?>" value="0" /> False</label>
												</li>
											</ul>
										</div>
									<?php }elseif($question['question_type'] == 'MULTIPLE_JUSTIFY'){ ?>
										<input type="hidden" name="q_type_row_<?php echo $q_no; ?>" value="<?php echo $question['question_type']; ?>" />
										<div class="anser-lists">
											<ul>
												<li style="line-height:25px">
													<?php
														$mcq_answers = $this->Exam_model->get_question_answers($question['question_id']);
														$right_answers = json_decode($question['question_right_answerid'], true);
														$alpha = 'a';
														$ans_sl = 1;
														foreach($mcq_answers as $ans):
															if($ans['answer_title'] == '')
															{
																continue;
															}
													?>
													<?php echo '<strong>('.$alpha.') '.$ans['answer_title'].'</strong>'; ?> <br />
													<input type="hidden" name="q_answer_row_<?php echo $q_no; ?>_row[]" value="<?php echo $ans['answer_id']; ?>" />
													<label style="margin-right:10px;color:#0A0;">
														 <input type="radio" name="q_answer_<?php echo $q_no; ?>_<?php echo $ans['answer_id']; ?>" value="1" /> TRUE
													</label> 
													<label style="color:#F00">
														 <input type="radio" name="q_answer_<?php echo $q_no; ?>_<?php echo $ans['answer_id']; ?>" value="0" /> FALSE
													</label> 
													<br />
													
													<?php
														$alpha++;
														$ans_sl++;
														endforeach; 
													?>
												</li>
											</ul>
										</div>
									<?php } ?>
								</div>
								<?php
									$sl_number++;
									if($sl_number % 1 == 0){
										echo '</li><li class="last-li-q">';
									}
									endforeach; 
								?>
							</li>
						</ul>
						<a class="prv-nav">Previous</a>
						<a class="prv-nxt" onclick="remove_emptyli();">Next</a>
					</div>
				</section>
			</div>
		</div>
	</div>
</div>

<div class="sbmt-panl-bar">
	<div class="btsmbt-pnl">
		<span class="btn-cncl">Cancel</span>
		<button type="submit" class="btn-sbmt">Submit</button>
	</div>
</div>