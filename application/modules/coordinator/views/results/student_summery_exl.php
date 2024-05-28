<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=student_result_summery_batch_".$batchname.".xls");
?>

<table border="1">
				<thead>
					<tr>
						<th class="text-center" style="font-size: 26px; padding: 15px 0px" colspan="14">IBRAHIM CARDIAC HOSPITAL & RESEARCH INSTITUTE</th>
					</tr>
					<tr>
						<th class="text-center" style="font-size: 16px" colspan="14">122, Kazi Nazrul Islam Avenue, Shahbag, Dhaka &#8209; 1000, Bangladesh</th>
					</tr>
					<tr>
						<th class="text-center" style="font-size: 22px" colspan="14">CCVDE-DLP</th>
					</tr>
					<tr>
						<th class="text-center" style="font-size: 20px" colspan="14">Batch-<?php echo $batchname; ?> Students Exam Summary Report </th>
					</tr>
					<tr>
						<th class="text-center">SL</th>
						<th class="text-center">Batch</th>
						<th class="text-center">Student ID</th>
						<th class="text-center">Student Name</th>
						<th class="text-center">Mobile Number</th>
						<th class="text-center">Email</th>
						<th class="text-center">CCA-1 Status</th>
						<th class="text-center">CCA-1 Attande Date</th>
						<th class="text-center">CCA-2 Status</th>
						<th class="text-center">CCA-2 Attande Date</th>
						<th class="text-center">CCA-3 Status</th>
						<th class="text-center">CCA-3 Attande Date</th>
						<th class="text-center">ECE Status</th>
						<th class="text-center">ECE Attande Date</th>
						
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
						$sl=1;
						foreach($get_items as $item):
					?>
					<tr>
						<td class="text-center"><?php echo $sl;?></td>
						<td class="text-center">Batch-<?php echo $item['batch_name']; ?></td>
						<td class="text-center"><?php echo $item['student_entryid']; ?></td>
						<td class="text-center">
							<?php 
								if($item['spinfo_middle_name']):
									$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
								else:
									$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
								endif;
								echo $full_name; 
							?>
						</td>
						<td class="text-center"><?php echo $item['spinfo_personal_phone']; ?></td>
						<td class="text-center"><?php echo $item['student_email']; ?></td>
						<?php
							$phase1 = $this->Results_model->get_resultbystudent($item['student_id'], 1);
							if (empty($phase1)) {
							 $batchdata1 = $this->Results_model->get_batchexam($batchname, 1);
								?>
							 <td class="text-center">
							 	<?php if(empty($batchdata1)) {
							 		echo 'N/A';
							 	}else{
							 		echo 'Absent';
							 	} ?>
							 </td>
							 <td class="text-center">N/A</td>
							<?php }else{
						?>
						<td class="text-center">
							<?php								
								if($phase1->cmreport_status == 1){
									echo 'Passed';
								}else{
									echo 'Failed';
								}
							?>
						</td>
						<td class="text-center">
							<?php
								$time1 = strtotime($phase1->cmreport_create_date);
								$myFormatForView1 = date("M d, Y", $time1).'&nbsp;&nbsp;'.date("g:i A", $time1);
								echo $myFormatForView1;
							?>
						</td>
						<?php } 
						$phase2 = $this->Results_model->get_resultbystudent($item['student_id'], 2);
							if (empty($phase2)) {
								$batchdata2 = $this->Results_model->get_batchexam($batchname, 2);
								?>
							 <td class="text-center">
							 	<?php if(empty($batchdata2)) {
							 		echo 'N/A';
							 	}else{
							 		echo 'Absent';
							 	} ?>
							 </td>
							 <td class="text-center">N/A</td>
							<?php }else{
						?>
						<td class="text-center">
							<?php
								if($phase2->cmreport_status == 1){
									echo 'Passed';
								}else{
									echo 'Failed';
								}
							?>
						</td>
						<td class="text-center">
							<?php
								$time2 = strtotime($phase2->cmreport_create_date);
								$myFormatForView2 = date("M d, Y", $time2).'&nbsp;&nbsp;'.date("g:i A", $time2);
								echo $myFormatForView2;
							?>
						</td>
						<?php } 
						$phase3 = $this->Results_model->get_resultbystudent($item['student_id'], 3);
							if (empty($phase3)) {
							 $batchdata3 = $this->Results_model->get_batchexam($batchname, 3);
								?>
							 <td class="text-center">
							 	<?php if(empty($batchdata3)) {
							 		echo 'N/A';
							 	}else{
							 		echo 'Absent';
							 	} ?>
							 </td>
							 <td class="text-center">N/A</td>
							<?php }else{
						?>
						<td class="text-center">
							<?php								
								if($phase3->cmreport_status == 1){
									echo 'Passed';
								}else{
									echo 'Failed';
								}
							?>
						</td>
						<td class="text-center">
							<?php
								$time3 = strtotime($phase3->cmreport_create_date);
								$myFormatForView3 = date("M d, Y", $time3).'&nbsp;&nbsp;'.date("g:i A", $time3);
								echo $myFormatForView3;
							?>
						</td>
						<?php } 
						$phase4 = $this->Results_model->get_resultbystudent($item['student_id'], 4);
							if (empty($phase4)) {
							 $batchdata4 = $this->Results_model->get_batchexam($batchname, 4);
								?>
							 <td class="text-center">
							 	<?php if(empty($batchdata4)) {
							 		echo 'N/A';
							 	}else{
							 		echo 'Absent';
							 	} ?>
							 </td>
							 <td class="text-center">N/A</td>
							<?php }else{
						?>
						<td class="text-center">
							<?php								
								if($phase4->cmreport_status == 1){
									echo 'Passed';
								}else{
									echo 'Failed';
								}
							?>
						</td>
						<td class="text-center">
							<?php
								$time4 = strtotime($phase4->cmreport_create_date);
								$myFormatForView4 = date("M d, Y", $time4);
								echo $myFormatForView4;
							?>
						</td>
					<?php } ?>
						
					</tr>
					<?php $sl++; endforeach; ?>
				</tbody>
			</table>