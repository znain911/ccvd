$(document).ready(function(){
	$("#phaseA").validate({
		rules:{
			module_name:{
				required: true,
			},
			module_title:{
				required: true,
			},
		},
		messages:{
			module_name:{
				required: null,
			},
			module_title:{
				required: null,
			},
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "coordinator/course/create",
                data : $('#phaseA').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.status == "ok")
					{
						document.getElementById("phaseA").reset();
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						sqtoken_hash=data._jwar_t_kn_;
						$('#alert').html(data.success);
						$('#loader').hide();
						$('#getContents').html(data.content);
						return false;
					}else if(data.status == "error"){
						$('#alert').html(data.error);
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						sqtoken_hash=data._jwar_t_kn_;
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
	
	$("#upPhaseA").validate({
		rules:{
			module_name:{
				required: true,
			},
			module_title:{
				required: true,
			},
		},
		messages:{
			module_name:{
				required: null,
			},
			module_title:{
				required: null,
			},
		},
        submitHandler : function () {
			$('#loader').show();
            // your function if, validate is success
            $.ajax({
                type : "POST",
                url : baseUrl + "coordinator/course/update",
                data : $('#upPhaseA').serialize(),
                dataType : "json",
                success : function (data) {
					if(data.status == "ok")
					{
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						sqtoken_hash=data._jwar_t_kn_;
						$('#alert').html(data.success);
						$('#loader').hide();
						$('#getContents').html(data.content);
						return false;
					}else if(data.status == "error"){
						$('#alert').html(data.error);
						$('[name="_jwar_t_kn_"]').val(data._jwar_t_kn_);
						sqtoken_hash=data._jwar_t_kn_;
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
});