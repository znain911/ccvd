<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="course-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<div class="course-content-start">
						<!-- begin #wizard -->
						<div class="wizard-step-start-box">
							<div class="step-wzard completed">
								<a class="step-up-link">
									<span class="step-num"><i class="fa fa-check"></i></span>
									<strong class="phase-name">Phase A</strong>
									<span class="module-dtls">Module 1, 2, 3</span>
								</a>
							</div>
							<div class="step-wzard completed">
								<a class="step-up-link">
									<span class="step-num"><i class="fa fa-check"></i></span>
									<strong class="phase-name">Phase B</strong>
									<span class="module-dtls">Module 4, 5, 6, 7</span>
								</a>
							</div>
							<div class="step-wzard completed">
								<a class="step-up-link">
									<span class="step-num"><i class="fa fa-check"></i></span>
									<strong class="phase-name">Phase C</strong>
									<span class="module-dtls">Module 8, 9, 10</span>
								</a>
							</div>
							<div class="step-wzard completed ece-step">
								<a class="step-up-link">
									<span class="step-num"><i class="fa fa-check"></i></span>
									<strong class="phase-name">ECE</strong>
								</a>
							</div>
						</div>
						<div class="panl-wzrad-container-active">
							<div class="congratulation-message">
								<h1>Congratulations!</h1>
								<h3>ON</h3>
								<h4>PASSING YOUR EXAMINATIONS</h4>
							</div>
						</div>
						<!-- end #wizard -->
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>