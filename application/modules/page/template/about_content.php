<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-container">
	<div class="container">
		<?php 
			$header_pages = $this->Common_model->get_pages(1);
			foreach($header_pages as $page):
		?>
		<div class="row about-rows" id="<?php echo $page['page_slug']; ?>">
			<div class="col-lg-12">
				<h2 class="section-title"><?php echo $page['page_title']; ?></h2>
				<div class="section-content"><?php echo $page['page_description']; ?></div>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>