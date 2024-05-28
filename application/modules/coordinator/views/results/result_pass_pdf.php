<h2 style="text-align: center;">IBRAHIM CARDIAC HOSPITAL & RESEARCH INSTITUTE</h2>
<h4 style="text-align: center;">122, Kazi Nazrul Islam Avenue, Shahbag, Dhaka–1000, Bangladesh</h4>
<h3 style="text-align: center;">CCVDE-DLP</h3>
<h3 style="text-align: center;">Batch-<?php echo $batchname; ?> <?php echo $etyp; ?> Exam Passed Students Report</h3>

<table border="1">
				<thead>
					
					<tr>
						<th class="text-center">SL</th>
						<th class="text-center">Batch</th>
						<th class="text-center">ID</th>
						<th class="text-center">Student</th>
						<th class="text-center">Chapter Level</th>
						<th class="text-center">Score</th>
						<th class="text-center">Passing Score</th>
						<th class="text-center">Right Answer</th>
						<th class="text-center">Wrong Answer</th>
						<th class="text-center">Result</th>
						<th class="text-center">Date</th>
						
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
						$sl = 1;
						foreach($get_items as $item):
					?>
					<tr>
						<td class="text-center"><?php echo $sl; ?></td>
						<td class="text-center"><?php echo $item['batch_name']; ?></td>
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
						<td class="text-center"><?php echo $item['phase_name']; ?></td>
						<td class="text-center"><?php echo $item['mdlmark_number']; ?></td>
						<td class="text-center"><?php echo $item['mdlmark_passing_number']; ?></td>
						<td class="text-center"><?php echo $item['mdlmark_right_answer']; ?></td>
						<td class="text-center"><?php echo $item['mdlmark_wrong_answer']; ?></td>
						<td class="text-center">
							<?php if($item['cmreport_status'] === '1'): ?>
							<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Passed</span>
							<?php else: ?>
							<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Failed</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
							<?php
								$time = strtotime($item['cmreport_create_date']);
								$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
								echo $myFormatForView;
							?>
						</td>
						
					</tr>
					<?php $sl++; endforeach; ?>
				</tbody>
			</table>