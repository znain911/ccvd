<table class="table table-td-valign-middle m-b-0">
									<thead>
										<tr>
											<th>SL</th>
											<th nowrap>#ID</th>
											<th class="text-center">Photo</th>
											<th class="text-center">Full Name</th>
											<th class="text-center">Home District</th>
											<th class="text-center">Present District</th>
											<th class="text-center">BMDC No</th>
											<th class="text-center">Designation</th>
											<th class="text-center">SSC Year</th>
											<th class="text-center">HSC Year</th>
											<th class="text-center">Payment</th>
											<th class="text-center">Status</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sl = $ttl + 1;
										if(count($get_items) !== 0):
											foreach($get_items as $item):
											$photo = base_url('attachments/students/'.$item['spinfo_photo']);
											/*$photo = base_url('attachments/students/'.$item['student_entryid'].'/'.$item['spinfo_photo']);*/
											if($item['spinfo_middle_name'])
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_middle_name'].' '.$item['spinfo_last_name'];
											}else
											{
												$full_name = $item['spinfo_first_name'].' '.$item['spinfo_last_name'];
											}
										?>
										<tr class="items-row-<?php echo $item['student_id']; ?>">
											<td><?php echo $sl;?></td>
											<td><?php echo $item['student_entryid']; ?></td>
											<?php if($item['spinfo_photo']): ?>
											<td class="text-center"><img src="<?php echo $photo; ?>" width="40" alt="Photo"></td>
											<?php else: ?>
											<td class="text-center"><img src="<?php echo base_url('backend/'); ?>assets/img/user_1.jpg" width="20" class="rounded-corner" alt=""></td>
											<?php endif; ?>
											<td class="text-center"><?php echo $full_name; ?></td>											
											<td class="text-center"><?php echo $item['pdis']; ?></td>
											<td class="text-center"><?php echo $item['name']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_bmanddc_number']; ?></td>
											<td class="text-center"><?php echo $item['spsinfo_designation']; ?></td>
											<?php $academyinfo = $this->Students_model->getStudentAcademyList($item['student_id']);
											if(!empty($academyinfo)){
			foreach($academyinfo as $acinfo){?>
			<td><?php echo $acinfo->sacinfo_year;?></td>
				<?php } }else{?>
					<td></td>
					<td></td>
				<?php }?>
			<?php $onlinepay = $this->Students_model->get_onlinepayment_info($item['student_entryid']);
			$bankpay = $this->Students_model->get_depositpayment_info($item['student_entryid']);
			if(!empty($onlinepay)){
				echo '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
			}elseif (!empty($bankpay)) {
				echo '<td class="text-center"><strong style="color:#0a0">Paid</strong></td>';
			}else{
				$date1=date_create($item['student_approve_date']);
				$date2=date_create(date("Y-m-d"));
				$diff=date_diff($date1,$date2);
				$difdate = $diff->format("%a");
				if ($difdate > 7) {
					/* echo '<td class="text-center"><strong style="color:red">Unpaid</strong><br>Payment Time Over</td>'; */
					echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td>';
				}else{
					echo '<td class="text-center"><strong style="color:red">Unpaid</strong></td>';
				}
				
			}?>


											<!-- <td class="text-center"><?php echo date("d M, Y", strtotime($item['student_regdate'])).'&nbsp;&nbsp;'.date("g:i A", strtotime($item['student_regdate'])); ?></td> -->
											<td class="text-center item-row-status-<?php echo $item['student_id']; ?>">
												<?php if($item['student_status'] === '1'): ?>
												<span class="btn btn-success btn-xs btn-rounded p-l-10 p-r-10">Approved</span>
												<?php else: ?>
												<span class="btn btn-danger btn-xs btn-rounded p-l-10 p-r-10">Pending</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button data-student="<?php echo $item['student_id']; ?>" class="row-action-view btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-eye"></i> View</button>
												<button data-target="#modal-without-animation" data-toggle="modal" data-student="<?php echo $item['student_entryid']; ?>" class="row-action-payment btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-credit-card"></i> Payments</button>
												<span class="row-action-status-holder-<?php echo $item['student_id']; ?>">
													<?php if($item['student_status'] === '0'): ?>
													<button data-status="1" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-default btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Approve</button>
													<?php else: ?>
													<button data-status="0" data-student="<?php echo $item['student_id']; ?>" class="row-action-status btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-cog"></i> Declined</button>
													<button data-target="#reject-modal" data-toggle="modal" data-student="<?php echo $item['student_id']; ?>" data-status="5" class="row-action-rjct btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-trash"></i> Reject</button>
													<?php endif; ?>
												</span>
												<!--<button data-student="<?php echo $item['student_id']; ?>" onclick="return confirm('Are you sure?', true);" class="remove-row btn btn-danger btn-xs p-l-10 p-r-10"><i class="fa fa-times"></i> Reject</button>-->
											</td>
										</tr>
										<?php $sl++; endforeach; ?>
										<?php else: ?>
										<tr>
											<td colspan="6"><span class="not-data-found">No Data Found!</span></td>
										</tr>
										<?php endif; ?>
									</tbody>
								</table>
<div class="page-contr">
	<?php echo $this->ajax_pagination->create_links(); ?>
</div>