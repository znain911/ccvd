$(document).ready(function(){
	$("#loginform").validate({
		rules:{
			email:{
				required: true,
				email: true,
			},
			password:{
				required: true,
			}
		},
		messages:{
			email:{
				required: null,
				email: null,
			},
			password:{
				required: null,
			}
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "coordinator/login/checkadmin",
                data : $('#loginform').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("loginform").reset();
						$('#loader').hide();
						$("#alert").html(data.success);
						window.setTimeout(function(){
							window.location.href = baseUrl + "coordinator/dashboard";
						}, 3000);
						return false;
					}else if(data.status == "warning")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#loader').hide();
						$("#alert").html(data.warning);
						return false;
					}else if(data.status == "failed_error")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#loader').hide();
						$("#alert").html(data.error);
						return false;
					}else if(data.status == "valid_error")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						$('#loader').hide();
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
                url : baseUrl + "coordinator/checkemail",
                data : $('#recoverform').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("recoverform").reset();
						setTimeout(function() {
							window.location.href = baseUrl + "coordinator/resetform";
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
                url : baseUrl + "coordinator/checkcode",
                data : $('#restFrm').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("restFrm").reset();
						setTimeout(function() {
							window.location.href = baseUrl + "coordinator/newpassword";
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
                url : baseUrl + "coordinator/update_password",
                data : $('#newPassSet').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("newPassSet").reset();
						setTimeout(function() {
							window.location.href = baseUrl + "coordinator/success";
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