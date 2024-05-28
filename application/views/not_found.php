<?php require_once APPPATH.'modules/common/header.php'; ?>
<div class="four-zero error-body">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="error-template">
					<h1>
						Oops!</h1>
					<h2>
						404 Not Found</h2>
					<div class="error-details">
						Sorry, an error has occured, Requested page not found!
					</div>
					<div class="error-actions">
						<a href="<?php echo site_url(); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>Take Me Home </a>
						<a href="<?php echo base_url('contact'); ?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php require_once APPPATH.'modules/common/footer.php'; ?>