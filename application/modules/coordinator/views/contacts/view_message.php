<?php 
	$contact_info = $this->Contacts_model->get_contactby_id($contact_id);
?>
<div class="form-cntnt lesson-form-number-<?php echo $contact_id; ?>">
	<h2 class="frm-title-ms"><strong>Contact</strong></h2>
	<div class="lesson-information-content">
		<div class="less-content evaluation-content">
			<div class="reviews">
			  <div class="row blockquote review-item">
				<div class="col-md-12">
				  <h4 style="color:#0a0"><strong>Subject : </strong><?php echo $contact_info['contact_subject']; ?></h4>
				  <p><strong>Ticket : </strong><?php echo $contact_info['contact_ticket_id']; ?></p>
				  <p><strong>Name : </strong><?php echo $contact_info['contact_name']; ?></p>
				  <p><strong>Phone Number : </strong><?php echo $contact_info['contact_phone']; ?></p>
				  <p><strong>Email : </strong><?php echo $contact_info['contact_email']; ?></p>
				  <p class="review-text">
					<strong>Message : </strong> <br />
					<?php echo $contact_info['contact_description']; ?>
				  </p>
				  <small class="review-date"><?php echo date("M d, Y", strtotime($contact_info['contact_date'])); ?></small>
				</div>                          
			  </div>  
			</div>
		</div>
	</div>
</div>