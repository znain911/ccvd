<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th nowrap>SL.</th>
			<th nowrap>Student ID</th>
			<th nowrap>Name</th>
			<th nowrap>Payment</th>
			<th nowrap>Amount</th>
			<th nowrap>Transaction ID</th>
			<th nowrap>Transaction Date</th>
			<th nowrap>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			if(count($get_items) !== 0):
			$inc_sl = 1;
			foreach($get_items as $payment):
			$name = $this->Paymentapi_model->student_name($payment['onpay_student_entryid']);
		?>
		<tr>
			<td><?php echo $inc_sl; ?></td>
			<td><?php echo $payment['onpay_student_entryid']; ?></td>
			<td><?php echo $name; ?></td>
			<td><?php echo $payment['onpay_account']; ?></td>
			<td><?php echo 'BDT '.$payment['onpay_transaction_amount']; ?></td>
			<td><?php echo $payment['onpay_transaction_id']; ?></td>
			<td class="text-center">
				<?php
					$time = strtotime($payment['onpay_transaction_date']);
					$myFormatForView = date("M d, Y", $time).'&nbsp;&nbsp;'.date("g:i A", $time);
					echo $myFormatForView;
				?>
			</td>
			<td class="text-center"><strong style="color:#0a0">Paid</strong></td>
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
<div class="page-contr">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>