<?php  
	$get_bookings = $this->Course_model->get_workshop_booked();
	foreach($get_bookings as $booking):
	$get_center_details = $this->Course_model->get_workshopcenter_location($booking['booking_schedule_centerid']);
	$booking_status = $this->Course_model->check_workshopbooking_status($booking['booking_id']);
?>
<tr>
	<td class="text-left"><?php echo $booking['booking_application_id']; ?></td>
	<td class="text-center"><?php echo $booking['endmschedule_title']; ?></td>
	<td class="text-center"><?php echo $booking['phase_name']; ?></td>
	<td class="text-center"><?php echo $get_center_details['center_location']; ?></td>
	<td class="text-center"><?php echo date("d M Y", strtotime($get_center_details['centerschdl_to_date'])); ?>, <?php echo $get_center_details['centerschdl_to_time']; ?></td>
	<td class="text-center"><?php echo date("d M Y", strtotime($booking['booking_date'])); ?>, <?php echo date("g:i A", strtotime($booking['booking_date'])); ?></td>
	<td class="text-center">
		<?php if($booking_status == true && $booking_status['programme_status'] == '1'): ?>
		<strong style="color:#0a0">Approved</strong>
		<?php else: ?>
		<strong style="color:#F00">Pending</strong>
		<?php endif; ?>
	</td>
</tr>
<?php endforeach; ?>