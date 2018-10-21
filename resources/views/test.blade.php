@extends('layouts.app')

@section('content')
	<form submit="testJSON(this)" id="test">
		<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
		<input type="text" name="text">
		<input type="submit" name="submit">
	</form>
	<p id="result">
	</p>
	<div id="comment_image" class="row col-sm-5">
	</div>
	<div class="row col-sm-12">
		
	</div>
	<script type="text/javascript">
		var form = document.getElementById("test");
		form.addEventListener("submit", function(e){
			e.preventDefault();
			testJSON(this);
		});
		function testJSON(form){ 
			var formData = new FormData(form);
			var request = new XMLHttpRequest();
			request.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	var myObject = JSON.parse(this.responseText);
			     	getResult(myObject[0]["id"]);
			     	console.log(myObject[1].length);
			     	var i = 0;
			     	var container = document.getElementById("comment_image");
			     	var str = "";
			     	/*for(i=0; i < myObject.length; i++){
			     		

			     		var path = myObject[i]["path"];
						str += '<img src="{{url('') }}' + '/' + myObject[i]["path"]  + 
						'" class="img-fluid" height="150px">';
									     		
			    	}*/
			    	
			    	container.innerHTML = str;
			 	}
			}
			request.open("POST", "{{url('comment/images')}}", true);
			request.send(formData);
		}
		
		function getResult(result){
			var element = document.getElementById("result");
			element.innerHTML = result;
		}
	</script>
@endsection