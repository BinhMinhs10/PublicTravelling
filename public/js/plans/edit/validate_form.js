$(document).ready(function (){ 
	$.validator.addMethod("before", function(value, element, param){
		if($(param).val()!==undefined && $(param).val()!==''){
			
			return this.optional(element) || value <= $(param).val();
		}else{
			return true;
		}
		
	}, "This time should be earlier!");
	$.validator.addMethod("before2", function(value, element, param){
		if( $(param).val()!==undefined && $(param).val()!==''){
			
			return this.optional(element) || value <= $(param).val();
		}else{
			return true;
		}
		
	}, "This time should be earlier!");

	$.validator.addMethod("after", function(value, element, param){
		if($(param).val()!==undefined && $(param).val()!==''){
			return this.optional(element) || value >= $(param).val();
		}else{
			return true;
		}
	}, "This time should be later!");
	$.validator.addMethod("after2", function(value, element, param){
		if($(param).val()!==undefined && $(param).val()!==''){
			return this.optional(element) || value >= $(param).val();
		}else{
			return true;
		}
	}, "This time should be later!");

	$.validator.addMethod("afterNow", function(value, element, param){
		if( $(param).val()!==''){
			return this.optional(element) || value >= param;
		}else{
			return true;
		}
	}, "This time should be later the current time!");
	$.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param)
	}, 'File size must be less than {0} bytes (1.5MB)');

	$("#routes").bind('rowAddOrRemove', function() {

		//	remove all rules
		$('#start_at').rules('remove');
		$('#end_at').rules('remove');
		for(var i=0; i<orders.length; i++){
			if($('#start'+orders[i])){
				$('#start'+orders[i]).rules('remove');
			}
			if($('#displayValueActivities'+orders[i])){
				$('#displayValueActivities'+orders[i]).rules('remove');
			}
			if($('#timeStart'+orders[i])){
				$('#timeStart'+orders[i]).rules('remove');
			}
			if($('#timeEnd'+orders[i])){
				$('#timeEnd'+orders[i]).rules('remove');
			}
		}

		//	add new rules
		for(var i=0; i<orders.length; i++){
			$('#start'+orders[i]).rules('add',{
				required: true,
			});
			$('#displayValueActivities'+orders[i]).rules('add',{
				required: true,
			});
			$('#timeStart'+orders[i]).rules('add',{
	            required: true,
	            after: '#start_at',
	            before: '#timeEnd'+orders[i],
	            after2: '#timeEnd'+orders[i-1],
	            afterNow: newDate.today()+" "+currentTime,				
			});

			$('#timeEnd'+orders[i]).rules('add',{
	            required: true,
	            before: '#end_at',
	            after: '#timeStart'+orders[i],
	            before2: '#timeStart'+orders[i+1],			
			});
		}
		$('#start_at').rules('add',{
			required: true,
			before2: '#end_at',
    		afterNow: newDate.today()+" "+currentTime,
    		before: '#timeStart'+orders[0],
		});
		$('#end_at').rules('add',{
			required: true,
			after2: '#start_at',
			after: '#timeEnd'+orders[orders.length-1],
		});
    });
	var routeRules = {};
   
    routeRules['start1'] = {
        required: true
    };
    routeRules['finis1'] = {
        //required: true
    };
    routeRules['displayValueVehicle1'] = {
        //required: true
    };
    routeRules['displayValueActivities1'] = {
        required: true
    };
    routeRules['timeEnd1'] = {
        required: true,
        before: '#end_at',
        after: '#timeStart1',
    };
    routeRules['timeStart1'] = {
        required: true,
        before: '#timeEnd1',
        afterNow: newDate.today()+" "+currentTime,
        after: '#start_at',
    };
    

    $('#routeForm').validate({
		rules: routeRules
	}); 
	$('#createPlanForm').validate({
		ignore: "",
		rules:{
			title:{
				required: true,
				maxlength: 255
			},

			description:{
				required: true,
				//maxlength: 255
			},

			member:{
				number: true,
				step: 1,
				min: 1
			},

			start_at:{
				required: true,
				before2: '#end_at',
        		afterNow: newDate.today()+" "+currentTime,
        		before: '#timeStart'+orders[0],
			},
			end_at:{
				required: true,
				after2: '#start_at',
				after: '#timeEnd'+orders[orders.length-1],
			},
			cover:{
	            filesize : 1536000,
			}
		},

		submitHandler: function(form){
			if($('#routeForm').valid()){
				form.submit();
			}
		}
	});

});