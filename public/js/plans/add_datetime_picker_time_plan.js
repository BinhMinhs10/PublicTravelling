	jQuery('#start_at').datetimepicker({
		format:'Y-m-d H:i',
		minDate: Date.now(),
		onChangeDateTime:logic,
		onShow:logic
	});
	jQuery('#end_at').datetimepicker({
		format:'Y-m-d H:i',
		minDate: Date.now(),
		onChangeDateTime:logic,
		onShow:logic
	});	