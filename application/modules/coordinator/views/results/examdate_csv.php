<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=Exam_date.xls");
?>

<table border="1">
				<thead>
					<tr>
						<th class="text-center" style="font-size: 26px; padding: 15px 0px" colspan="5">IBRAHIM CARDIAC HOSPITAL & RESEARCH INSTITUTE</th>
					</tr>
					<tr>
						<th class="text-center" style="font-size: 16px" colspan="5">122, Kazi Nazrul Islam Avenue, Shahbag, Dhaka–1000, Bangladesh</th>
					</tr>
					<tr>
						<th class="text-center" style="font-size: 22px" colspan="5">CCVDE-DLP</th>
					</tr>
					<tr>
						<th class="text-center" style="font-size: 20px" colspan="5">Exam Date</th>
					</tr>
					<tr>
						<th class="text-center">SL</th>
						<th class="text-center">Batch</th>
						<th class="text-center">Exam Name</th>
						<th class="text-center">Exam Date</th>
						<th class="text-center">Exam Type</th>						
					</tr>
				</thead>
				<tbody class="appnd-not-fnd-row">
					<?php
						$sl=1;
						foreach($get_items as $item):
					?>
					<tr>
						<td class="text-center"><?php echo $sl;?></td>
						<td class="text-center"><?php echo $item->batch_name; ?></td>	
						<td class="text-center"><?php echo $item->phase_name; ?></td>
						<td class="text-center"><?php echo $item->examdt; ?></td>
						<td class="text-center"></td>
					</tr>
					<?php $sl++; endforeach; ?>
				</tbody>
			</table>