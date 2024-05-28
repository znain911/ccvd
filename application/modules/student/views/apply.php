<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="">
		<div class="container">
			<div class="row">
				<div class="col-lg-3">
					<?php require_once APPPATH.'modules/student/templates/sidebar.php'; ?>
				</div>
				<div class="col-lg-9">
					<?php if($type === 'SDT'): ?>
					<?php require_once APPPATH.'modules/student/views/apply/sdt.php'; ?>
					<?php elseif($type === 'WORKSHOP'): ?>
					<?php require_once APPPATH.'modules/student/views/apply/workshop.php'; ?>
					<?php elseif($type === 'ECE'): ?>
					<?php require_once APPPATH.'modules/student/views/apply/ece.php'; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>