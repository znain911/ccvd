$(document).ready(function(){
	$("#studentLogin").validate({
		rules:{
			email_or_id:{
				required: true,
			},
			password:{
				required: true,
			}
		},
        submitHandler : function () {
			$('#proccessLoader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "student/login/checkuser",
                data : $('#studentLogin').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("studentLogin").reset();
						$('#proccessLoader').hide();
						$("#alert").html(data.success);
						window.setTimeout(function(){
							window.location.href = baseUrl + "student/dashboard";
						}, 3000);
						return false;
					}else if(data.status == "warning")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#proccessLoader').hide();
						$("#alert").html(data.warning);
						return false;
					}else if(data.status == "failed_error")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#proccessLoader').hide();
						$("#alert").html(data.error);
						return false;
					}else if(data.status == "valid_error")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#proccessLoader').hide();
						$("#alert").html(data.validation_error);
						return false;
					}else
					{
						//have end check.
					}
					return false;
                }
            });
        }
    });
	
	$("#recoverform").validate({
		rules:{
			email:{
				required: true,
				email: true,
			}
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "student/login/checkemail",
                data : $('#recoverform').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("recoverform").reset();
						setTimeout(function() {
							window.location.href = baseUrl + "student/login/resetform";
						}, 3000 );
						return false;
					}else if(data.status == "error"){
						$('#alert').html(data.error_message);
						$('#loader').hide();
						return false;
					}else
					{
						//have end check.
					}
					return false;
                }
            });
        }
    });
	
	$("#restFrm").validate({
		rules:{
			resetcd:{
				required: true,
				number: true,
			}
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "student/login/checkcode",
                data : $('#restFrm').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("restFrm").reset();
						setTimeout(function() {
							window.location.href = baseUrl + "student/login/newpassword";
						}, 3000 );
						return false;
					}else if(data.status == "notok")
					{
						document.getElementById("restFrm").reset();
						$("#alert").html(data.error);
						$('#loader').hide();
						return false;
					}else
					{
						//have end check.
					}
					return false;
                }
            });
        }
    });
	
	$("#newPassSet").validate({
		rules:{
			newpass:{
				required: true,
			},
			cnfpass:{
				required: true,
				equalTo: "#mainpassrd",
			}
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "student/login/update_password",
                data : $('#newPassSet').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("newPassSet").reset();
						setTimeout(function() {
							window.location.href = baseUrl + "student/login/success";
						}, 3000 );
						return false;
					}else
					{
						//have end check.
					}
					return false;
                }
            });
        }
    });
});