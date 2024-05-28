<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php 
	$page_title = $get_pageinfo['page_title'];
	$page_description = $get_pageinfo['page_description'];
?>

<div class="page-bread">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="breadcrumb-area">
					<ol class="breadcrumb">
					  <li><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i>&nbsp; Home</a></li>
					  <li><a href="#">&nbsp;/&nbsp;Page&nbsp;/&nbsp;</a></li>
					  <li class="active"><?php echo $page_title; ?></li>
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
				<h2 class="pagetitle"><?php echo $page_title; ?></h2>
				<div class="page-description"><?php echo $page_description; ?></div>
			</div>
		</div>
	</div>
</div>