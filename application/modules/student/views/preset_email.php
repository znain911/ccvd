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
	</style>
</head>
<body style="background:#3C73B1;padding:100px 0px;margin:0">
	<div class="mail-container-bdy" style="background: #fff;padding: 37px 50px 50px;margin: 0px 150px;">
		<h2 class="main-title"><span>Dear Mr/Ms/Mrs </span><?php echo $student_info->spinfo_first_name.' '.$student_info->spinfo_middle_name.' '.$student_info->spinfo_last_name; ?>,</h2>
		<p><strong><?php echo $reset_code; ?></strong></p>
		
		<p class="regards-best">
			<strong>Thanks</strong> <br />
			Distance Learning Programme (DLP)
		</p>
	</div>
</body>
</html>