<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<title>Distance Learning Programme (DLP)</title>
	<style type="text/css">
		.main-title{
		color: #393939;
		text-align: left;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		.main-title > span{
		color: #ffa500;
		font-weight: bold;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		p.login-dtls{}
		p.regards-best{line-height:23px;}
		p {
		  color: #454545;
		  font-size: 14px;
		  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
		}
		.aftr-pid, .login-dtls{line-height:22px;}
		.mail-container-bdy{
			background: #fff;
			padding: 37px 50px 50px;
			margin: 0px 150px;
		}
		.main-body{
			background:#3C73B1;
			padding:100px 0px;
			margin:0;
		}
		@media (min-width: 320px) and (max-width: 480px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 360px) and (max-width: 640px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 768px) and (max-width: 1024px) {
			.main-body {
			  background: #3c73b1 none repeat scroll 0 0;
			  margin: 0;
			  padding: 5px;
			}
			.mail-container-bdy {
			  background: #fff none repeat scroll 0 0;
			  margin: 0;
			  padding: 10px 25px 30px;
			}
		}
		@media (min-width: 980px) and (max-width: 1280px) {}
		@media (min-width: 980px) and (max-width: 1280px) {}
	</style>
</head>
<body class="main-body">
	<div class="mail-container-bdy">
		<h2 class="main-title"><span>Congratulation, </span><?php echo $faclt_full_name; ?></h2>
		<p>You have been successfully registered with Distance Learning Programme (DLP).</p>
		
		<p class="aftr-pid"><strong>Click</strong> on the button below to redirect at login page.</p>
		
		<p>
			<a href="<?php echo base_url('faculty/login'); ?>" style="display: inline-block; background: rgb(60, 115, 177) none repeat scroll 0% 0%; color: rgb(255, 255, 255); text-align: center; text-decoration: none; padding: 8px 15px; text-transform: uppercase; border-radius: 4px; box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);">
				Go To Login
			</a>
		</p>
		
		<p class="login-dtls">
			<strong>Your Login Email : </strong> <?php echo $faclt_login_email; ?> <br />
			<strong>Your Password : </strong> <?php echo $faclt_login_password; ?> <br />
		</p>
		
		<p class="regards-best">
			Thanks & Regards <br />
			<strong>CEO</strong> <br />
			Distance Learning Programme (DLP)
		</p>
	</div>
</body>
</html>