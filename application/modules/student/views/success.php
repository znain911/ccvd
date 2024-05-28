<?php require_once APPPATH.'modules/common/header.php'; ?>
	<div class="container dlp-login">
        <div class="row justify-content-md-center">
          <div class="col-lg-6">
            <div class="card card-hero card-primary">
              <div class="card-body">
                <h1 class="color-primary text-center">Password reset successful.</h1>
                <p>You have successfully reset the password for your account.</p>
				<p class="p-forget-pass"><a href="<?php echo base_url('student/login'); ?>"><strong>Back to login.</strong></a></p>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- container -->
<?php require_once APPPATH.'modules/common/footer.php'; ?>