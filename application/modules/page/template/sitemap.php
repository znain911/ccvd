<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-bread">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb-area">
					<ol class="breadcrumb">
					  <li><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i>&nbsp; Home</a></li>
					  <li><a href="#">Page</a></li>
					  <li class="active">Sitemap</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="page-container">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2 class="pagetitle">Sitemap</h2>
				<h3>Categories</h3>
				<div class="row">
					<?php 
						$get_maincats = $this->Outer_model->get_main_categories();
						foreach($get_maincats as $maincat):
					?>
					<div class="col-lg-4">
						<ul>
							<li>
								<a href="<?php echo base_url('category/'.$maincat['parentcat_slug']); ?>"><?php echo $maincat['parentcat_title']; ?></a>
								<?php 
									$get_subcats = $this->Outer_model->get_subitemsby_mainitem($maincat['parentcat_id']);
									if(count($get_subcats) !== 0):
								?>
								<ul>
									<?php 
										foreach($get_subcats as $subcat):
									?>
									<li>
										<a href="<?php echo base_url('category/'.$subcat['subcat_slug']); ?>"><?php echo $subcat['subcat_title']; ?></a>
										<?php 
											$get_furthercats = $this->Outer_model->get_further_cats($subcat['subcat_id']);
											if(count($get_furthercats) !== 0):
										?>
										<ul>
											<?php foreach($get_furthercats as $furthercat): ?>
											<li><a href="<?php echo base_url('category/'.$furthercat['furthercat_slug']); ?>"><?php echo $furthercat['furthercat_title']; ?></a></li>
											<?php endforeach; ?>
										</ul>
										<?php endif; ?>
									</li>
									<?php endforeach; ?>
								</ul>
								<?php endif; ?>
							</li>
						</ul>
					</div>
					<?php endforeach; ?>
				</div>
				<br /><br /><br />
				<h3>Pages</h3>
				<div class="row">
					<div class="col-lg-12">
						<ul>
							<?php 
								$get_all_pages = $this->Outer_model->get_all_pages();
								foreach($get_all_pages as $page):
							?>
							<li><a href="<?php echo base_url('page/'.$page['page_slug']); ?>"><?php echo $page['page_title']; ?></a></li>
							<?php endforeach; ?>
							<li><a href="<?php echo base_url('page/faq'); ?>">Faq</a></li>
							<li><a href="<?php echo base_url('page/contact'); ?>">Support / Contact Us</a></li>
							<li><a href="<?php echo base_url('page/sitemap'); ?>">Sitemap</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>