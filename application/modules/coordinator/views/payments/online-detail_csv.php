<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=online_payment_list_details.xls");
?>

<table border="1">
	<thead>
		<tr>
			<th nowrap>SL.</th>
			<th nowrap>Student ID</th>
			<th nowrap>Name</th>
			<th nowrap>Mobile</th>
			<th nowrap>Email</th>
			<th nowrap>Batch</th>
			<th nowrap>Address</th>
			<th nowrap>BMDC Number</th>
			<th nowrap>REGISTRATION DATE</th>
			<th nowrap>Payment Date</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		if(count($get_items) !== 0):
			$inc_sl = 1;
			foreach($get_items as $payment):
				$name = $this->Payments_model->student_name($payment['onpay_student_entryid']);
				
				?>
				<tr>
					<td><?php echo $inc_sl; ?></td>
					<td><?php echo $payment['onpay_student_entryid']; ?></td>
					<td><?php echo $name; ?></td>
					<td><?php echo $payment['spinfo_personal_phone']; ?></td>
					<td><?php echo $payment['student_email']; ?></td>
					<td><?php echo $payment['batch_name']; ?></td>
					<td><?php echo $payment['spinfo_current_address']; ?></td>
					<td><?php echo $payment['spsinfo_bmanddc_number']; ?></td>
					<td class="text-center">
						<?php
						$time = strtotime($payment['student_regdate']);
						$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
						echo $myFormatForView;
						?>
					</td>
					<td class="text-center">
						<?php
						$time = strtotime($payment['onpay_transaction_date']);
						$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
						echo $myFormatForView;
						?>
					</td>
					<!-- <td class="text-center"><strong style="color:#0a0">Paid</strong></td> -->
				</tr>
				<?php 
				$inc_sl++;
			endforeach; 
		else:
			?>
			<tr>
				<td colspan="8"><span class="not-data-found">No Data Found!</span></td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>