<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="registration-container reg-student" id="regContainer">
					<div id="stepWizard">
						<?php 
							$seg_1 = $this->uri->segment(1);
							$seg_2 = $this->uri->segment(2);
							$seg_3 = $this->uri->segment(3);
							if($seg_1 == 'student' && $seg_2 == 'onboard' && $seg_3 == 'payment'):
						?>
						<?php require_once APPPATH.'modules/student/views/regflow/stepflow_payment.php'; ?>
						<?php elseif($seg_1 == 'student' && $seg_2 == 'onboard' && $seg_3 == 'approval'): ?>
						<?php require_once APPPATH.'modules/student/views/regflow/stepflow_approval.php'; ?>
						<?php else: ?>
						<?php require_once APPPATH.'modules/student/views/regflow/stepflow.php'; ?>
						<?php endif; ?>
					</div>
					<div class="form-top-description"></div>
					<div class="form-field-description" id="formDescField">
						<?php require_once APPPATH.'modules/student/views/regflow/'.$template.'.php'; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>