	var logic = function( currentDateTime ){
	// 'this' is jquery object datetimepicker
	if(currentDateTime!==null){
		if( currentDateTime.today()===newDate.today() ){
			this.setOptions({
				minTime:currentTime
			});
		}else{
			this.setOptions({
				minTime:'0:00'
			});
		}
	}
	};

	jQuery('#timeStart1').datetimepicker({
		format:'Y-m-d H:i',
		minDate: Date.now(),
		onChangeDateTime:logic,
		onShow:logic
	});
	jQuery('#timeEnd1').datetimepicker({
		format:'Y-m-d H:i',
		minDate: Date.now(),
		onChangeDateTime:logic,
		onShow:logic
	});	
