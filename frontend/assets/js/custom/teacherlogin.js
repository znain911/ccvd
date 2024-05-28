$(document).ready(function(){
	$("#teacherLogin").validate({
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
                url : baseUrl + "faculty/login/checkuser",
                data : $('#teacherLogin').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("teacherLogin").reset();
						$('#proccessLoader').hide();
						$("#alert").html(data.success);
						window.setTimeout(function(){
							window.location.href = baseUrl + "faculty/dashboard";
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
	
	$("#recoverformTeacher").validate({
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
                url : baseUrl + "faculty/login/checkemail",
                data : $('#recoverformTeacher').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("recoverformTeacher").reset();
						window.location.href = baseUrl + "faculty/login/resetform";
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
	
	$("#restFrmTeacher").validate({
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
                url : baseUrl + "faculty/login/checkcode",
                data : $('#restFrmTeacher').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("restFrmTeacher").reset();
						window.location.href = baseUrl + "faculty/login/newpassword";
						return false;
					}else if(data.status == "notok")
					{
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
	
	$("#newPassSetTeacher").validate({
		rules:{
			password:{
				required: true,
			},
			password_confirm:{
				required: true,
				equalTo: "#newPassword",
			}
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "faculty/login/update_password",
                data : $('#newPassSetTeacher').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("newPassSetTeacher").reset();
						window.location.href = baseUrl + "faculty/login/success";
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