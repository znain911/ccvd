<?php  
	$get_bookings = $this->Course_model->get_phase_booked($phase_level);
	foreach($get_bookings as $booking):
	$get_center_details = $this->Course_model->get_center_location($booking['booking_schedule_centerid']);
?>
<tr>
	<td class="text-left"><?php echo $booking['endmschedule_title']; ?></td>
	<td class="text-center"><?php echo $booking['phase_name']; ?></td>
	<td class="text-center"><?php echo $booking['booking_application_id']; ?></td>
	<td class="text-center"><?php echo $get_center_details['center_location']; ?></td>
	<td class="text-center"><?php echo date("d M Y", strtotime($get_center_details['centerschdl_to_date'])); ?>, <?php echo $get_center_details['centerschdl_to_time']; ?></td>
	<td class="text-center"><?php echo date("d M Y", strtotime($booking['booking_date'])); ?>, <?php echo date("g:i A", strtotime($booking['booking_date'])); ?></td>
</tr>
<?php endforeach; ?>