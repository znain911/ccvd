<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $lesson_info['lesson_title']; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/normalize.css">
        <link rel="stylesheet" href="<?php echo base_url('frontend/'); ?>assets/css/main.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
        <div class="main-header">
			<div class="col-lg-12 text-center">
				<h2 style="font-size:19px;font-weight:bold"><?php echo $lesson_info['lesson_title']; ?></h2>
			</div>
		</div>
		<div class="main-body">
			<div class="col-lg-12">
				<?php echo $lesson_info['lesson_content']; ?>
			</div>
		</div>
		<div class="main-footer" style="margin-top:15px;">
			<div class="col-lg-12 text-center">
				<p style="font-size:12px;">&copy; Copyright -2018. Distance Learning Programme (DLP)</p>
			</div>
		</div>
		
    </body>
</html>