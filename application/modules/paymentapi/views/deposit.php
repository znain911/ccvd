<table class="table table-td-valign-middle m-b-0">
	<thead>
		<tr>
			<th nowrap>SL.</th>
			<th nowrap>Student ID</th>
			<th nowrap>Name</th>
			<th nowrap>Payment</th>
			<th nowrap>Amount</th>
			<th nowrap>Bank</th>
			<th nowrap>Branch</th>
			<th nowrap>Account Number</th>
			<th nowrap>Deposit Slip</th>
			<th nowrap>Status</th>
			<th nowrap>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php  
			if(count($get_items) !== 0):
			$inc_sl = 1;
			foreach($get_items as $payment):
			$name = $this->Paymentapi_model->student_name($payment['deposit_student_entryid']);
		?>
		<tr>
			<td><?php echo $inc_sl; ?></td>
			<td><?php echo $payment['deposit_student_entryid']; ?></td>
			<td><?php echo $name; ?></td>
			<td><?php echo $payment['deposit_payment']; ?></td>
			<td><?php echo 'BDT '.number_format(intval($payment['deposit_amount']),0); ?></td>
			<td><?php echo $payment['deposit_bank']; ?></td>
			<td><?php echo $payment['deposit_branch']; ?></td>
			<td><?php echo $payment['deposit_account_number']; ?></td>
			<td><a href="<?php echo attachment_url('students/'.$payment['deposit_slip_file']); ?>" target="_blank"><i class="fa fa-eye"></i> View</a></td>
			<td class="text-center" id="dpStatus">
				<?php if($payment['deposit_slip_status'] === '0'): ?>
				<strong style="color:#0aa">Under Review</strong>
				<?php elseif($payment['deposit_slip_status'] === '1'): ?>
				<strong style="color:#0a0">Paid</strong>
				<?php elseif($payment['deposit_slip_status'] === '2'): ?>
				<strong style="color:#F00">Unpaid</strong>
				<?php endif; ?>
			</td>
			<td class="text-center">
				<button data-student="<?php echo $payment['deposit_student_entryid']; ?>" class="row-action-paid btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-credit-card"></i> Paid</button>
				<button data-student="<?php echo $payment['deposit_student_entryid']; ?>" class="row-action-unpaid btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-credit-card"></i> Unpaid</button>
			</td>
		</tr>
		<?php 
			$inc_sl++;
			endforeach; 
			else:
		?>
		<tr>
			<td colspan="11"><span class="not-data-found">No Data Found!</span></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<div class="page-contr">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>