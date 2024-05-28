<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<?php require_once APPPATH.'modules/faculty/templates/sidebar.php'; ?>
			</div>
			<div class="col-lg-9">
				<div class="student-dashboard-notification">
					<div class="row">
						<div class="col-lg-7">
							<div class="admin-notification-title">
								<h2>
									<span class="top-tt">ADMINISTRATION</span> <br />
									<span class="bottom-tt">NOTIFICATION</span>
								</h2>
							</div>
							<div class="jsVerSlidr">
								<?php 
									$notifications = $this->Dashboard_model->get_dahboard_notifications();
									foreach($notifications as $notification):
									$crnt_date = strtotime(date("Y-m-d"));
									$notice_date = strtotime(date("Y-m-d", strtotime($notification['notif_create_date'])));
								?>
								<div class="single-notification">
									<span class="new-or-op-nt pull-right"><?php echo ($notice_date == $crnt_date)? 'NEW' : 'OLD'; ?></span>
									<div class="coordinator-nt-date">
										<span class="nt-date"><?php echo date("d F Y", strtotime($notification['notif_create_date'])); ?>, </span>
										<span class="nt-time"><?php echo date("H:i:s A", strtotime($notification['notif_create_date'])); ?></span>
									</div>
									<div class="coordinator-nt-description">
										<?php echo $notification['notif_content']; ?>
									</div>
								</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="col-lg-5 evnts">
							<h2>
								<span class="top-tt">SCHEDULED</span> <br />
								<span class="bottom-tt">EVENTS</span>
							</h2>
							<div class="events-calender">
								<?php 
									
									if($this->uri->segment(4) && is_numeric($this->uri->segment(4)) && $this->uri->segment(5) && is_numeric($this->uri->segment(5)))
									{
										//$date_src =  $this->uri->segment(4).'-'.$this->uri->segment(5);
										$get_sdt_schedule_dates      = $this->Dashboard_model->get_sdt_schedule_dates();
										$get_workshop_schedule_dates = $this->Dashboard_model->get_workshop_schedule_dates();
										$get_ece_schedule_dates      = $this->Dashboard_model->get_ece_schedule_dates();
										/*
										$data = array(
												3  => '<span class="clndr-sdt">',
												7  => '<span class="clndr-sdt-two">',
												13 => '<span class="clndr-workshp">',
												17 => '<span class="clndr-ece">',
										);
										*/
										echo $this->calendar->generate($this->uri->segment(4), $this->uri->segment(5));
									}else
									{
										//$date_src =  date("Y").'-'.date("m");
										$get_sdt_schedule_dates      = $this->Dashboard_model->get_sdt_schedule_dates();
										$get_workshop_schedule_dates = $this->Dashboard_model->get_workshop_schedule_dates();
										$get_ece_schedule_dates      = $this->Dashboard_model->get_ece_schedule_dates();
										
										/*
										$data = array(
												3  => '<span class="clndr-sdt">',
												7  => '<span class="clndr-sdt-two">',
												13 => '<span class="clndr-workshp">',
												17 => '<span class="clndr-ece">',
										);
										*/
										echo $this->calendar->generate(date("Y"), date("m"));
									}
								?>
							</div>
							<!--
							<div class="schdl-indicator">
								<span class="indicator indicator-one"><span class="color-box color-box-1"></span> Schedule for SDT - 1</span>
								<span class="indicator indicator-two"><span class="color-box color-box-2"></span> Schedule for SDT - 2</span>
								<span class="indicator indicator-three"><span class="color-box color-box-3"></span> Schedule for workshop</span>
								<span class="indicator indicator-four"><span class="color-box color-box-4"></span> Schedule for ECE</span>
							</div>
							-->
							<div class="schdl-indicator">
								<?php foreach($get_sdt_schedule_dates as $sdt): ?>
								<span class="indicator indicator-two"><i class="fa fa-star"></i> &nbsp; <?php echo $sdt['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($sdt['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($sdt['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
								
								<?php foreach($get_workshop_schedule_dates as $workshop): ?>
								<span class="indicator indicator-three"><i class="fa fa-star"></i> &nbsp; <?php echo $workshop['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($workshop['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($workshop['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
								
								<?php foreach($get_ece_schedule_dates as $ece): ?>
								<span class="indicator indicator-four"><i class="fa fa-star"></i> &nbsp; <?php echo $ece['endmschedule_title']; ?> schedule available from <?php echo date("d F, Y", strtotime($ece['endmschedule_from_date'])).' - '.date("d F, Y", strtotime($ece['endmschedule_to_date'])); ?></span>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>