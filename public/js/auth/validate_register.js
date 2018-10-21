$(document).ready(function (){  
	$.validator.addMethod("notEqualTo", function(value, element, param){
		return this.optional(element) || value != param;
	}, "Choose one of gender!");
	$.validator.addMethod("noSpace", function(value, element) { 
	  return value.indexOf(" ") < 0 && value != ""; 
	}, "No space please!");
	$('#msform').validate({
		rules:{
			username:{
				required: true,
				maxlength: 255,
				noSpace: true
			},

			fullname:{
				required: true,
				maxlength: 255
			},

			password: {
				required: true,
				minlength: 6,
			},
			email:{
				required: true,
				email: true
			},
			password_confirmation:{
				equalTo: '#password'
			},
			gender:{
				notEqualTo: -1
			},

			birthday:{
				required: true,
			},
		},
		messages:{
			password: {
				minlength: "Your password must be at least 6 characters long."
			},
		},

		submitHandler: function(form){
			if(form.valid()){
				form.submit();
			}	
		}
	});

});