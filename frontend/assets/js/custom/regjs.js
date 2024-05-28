$(document).ready(function(){
	
	$("#regType").validate({
		rules:{
			regfor:{
				required: true,
			}
		},
        submitHandler : function () {
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "registration/checkregtype",
                data : $('#regType').serialize(),
                dataType : "json",
				cache: false,
                success : function (data) {
					if(data.reg == "student")
					{
						window.location.href = baseUrl + "student/onboard/account";
						return false;
					}else if(data.reg == "teacher")
					{
						window.location.href = baseUrl + "faculty/onboard/account";
						return false;
					}else
					{
						window.location.href = baseUrl;
						return false;
					}
					return false;
                }
            });
        }
    });
	
	$("#loginType").validate({
		rules:{
			login_as:{
				required: true,
			}
		},
        submitHandler : function () {
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "login/logintype",
                data : $('#loginType').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.logintype == "student")
					{
						window.location.href = baseUrl + "student/login";
						return false;
					}else if(data.logintype == "teacher")
					{
						window.location.href = baseUrl + "faculty/login";
						return false;
					}else if(data.logintype == "coordinator")
					{
						window.location.href = baseUrl + "coordinator/login";
						return false;
					}else
					{
						window.location.href = baseUrl;
						return false;
					}
					return false;
                }
            });
        }
    });
	
})