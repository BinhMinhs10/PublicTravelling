@extends('layouts.app')

@section('content')
<div class="container">
<form onsubmit="test(event,this)" enctype="multipart/form-data">
	<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
	<input type="text" name="text">
	<input type="file" name="images[]" multiple>
	<input type="submit" value="Submit">
</form>
<p id="result">
</p>
<p id="error">
</p>
</div>
<script type="text/javascript">
	function test(e, form){
		e.preventDefault();
		var input = form.getElementsByTagName("input");
		var content = input[1].value;
		var images = input[2];
		console.log(content == "");
		if(content == "" && images.files.length == 0)
			return false;
		
		var formData = new FormData(form);
		var request = new XMLHttpRequest();
		request.onreadystatechange = function() {
		    if (this.readyState == 4 && this.status == 200) {
		    	var data = this.responseText;
		    	var result = document.getElementById("result");
		    	if(data == "error"){
		    		result.innerHTML = "error";
		    	}else{
		    		result.innerHTML = data;
		    	}
		    } 
		 };
		request.open("POST", "{{route('image.upload')}}",true);
		request.send(formData);
	}
	
</script>
@endsection