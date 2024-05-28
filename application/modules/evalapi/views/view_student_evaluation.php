<?php 
	$evaluation_info = $this->Evaluation_model->get_evaluations_by_id($evaluation_id);
	$faculty_name = $evaluation_info['tpinfo_first_name'].' '.$evaluation_info['tpinfo_middle_name'].' '.$evaluation_info['tpinfo_last_name'];
?>
<table class="table table-bordered">
	<tr>
		<td style="width: 30%;"><strong>Faculty : </strong></td>
		<td>
			<?php echo $faculty_name; ?>
		</td>
	</tr>
	<tr>
		<td><strong>Evaluation Title : </strong></td>
		<td><?php echo $evaluation_info['evaluation_title']; ?></td>
	</tr>
	<tr>
		<td><strong>Evaluation Description : </strong></td>
		<td><?php echo $evaluation_info['evaluation_description']; ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<h3 class="text-center">Evaluation Ratings</h3>
			<?php 
				$ratings = $this->Evaluation_model->get_ratingsby_evaluationid($evaluation_id);
				$evl_row = 1;
				foreach($ratings as $rating):
			?>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th style="width:22%">&nbsp;</th>
						<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_one']; ?></th>
						<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_two']; ?></th>
						<th style="width:18%" class="text-center"><?php echo $rating['eval_rating_type_three']; ?></th>
						<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_four']; ?></th>
						<th style="width:15%" class="text-center"><?php echo $rating['eval_rating_type_five']; ?></th>
					</tr>
					<tr>
						<th><?php echo $rating['eval_label']; ?></th>
						<th><label class="rating-radio"><?php echo ($rating['eval_rating_type_one'] == $rating['rating_eval_rating_type'])? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-times"></i>'; ?></label></th>
						<th><label class="rating-radio"><?php echo ($rating['eval_rating_type_two'] == $rating['rating_eval_rating_type'])? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-times"></i>'; ?></th>
						<th><label class="rating-radio"><?php echo ($rating['eval_rating_type_three'] == $rating['rating_eval_rating_type'])? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-times"></i>'; ?></th>
						<th><label class="rating-radio"><?php echo ($rating['eval_rating_type_four'] == $rating['rating_eval_rating_type'])? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-times"></i>'; ?></label></th>
						<th><label class="rating-radio"><?php echo ($rating['eval_rating_type_five'] == $rating['rating_eval_rating_type'])? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-times"></i>'; ?></label></th>
					</tr>
				</thead>
			</table>
			<input type="hidden" name="rating_rows[]" value="<?php echo $evl_row; ?>" />
			<?php 
				$evl_row++;
				endforeach; 
			?>
		</td>
	</tr>
</table>