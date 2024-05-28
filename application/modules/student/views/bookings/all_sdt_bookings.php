<?php
$get_booking_details = $this->Booking_model->get_sdt_already_booked_details($phase_lavel);
$details_content = '';
foreach($get_booking_details as $booking):
$details_content .= '<tr>
						<td class="text-center">'.$booking['endmschedule_title'].'</td>
						<td class="text-center">'.$booking['booking_application_id'].'</td>
						<td class="text-center">'.$booking['center_location'].'</td>
						<td class="text-center">'.date("d F, Y", strtotime($booking['centerschdl_to_date'])).' '.$booking['centerschdl_to_time'].'</td>
						<td class="text-center">'.date("d F, Y", strtotime($booking['booking_date'])).'</td>
					</tr>
				   ';
endforeach;

echo $details_content;