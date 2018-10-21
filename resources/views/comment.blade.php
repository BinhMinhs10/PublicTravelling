
<link href="{{ asset('css/comment.css') }}" rel="stylesheet">

	
	@include('snapshot')
	@include('show_image')
	<h2>Comment</h2>
	
	@php
		$no=1;

	@endphp
	
	@foreach($comments as $comment)
	<div class="row comment-container">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-2 avatar-container"> 
		<a href="#"><img src="{{asset($comment->user->avatar)}}" class="img-center img-avatar">
		<p class="username">{{$comment->user->username}}</p></a>
		</div>
		<div class="col-sm-7 total-comment">
			<div class="jumbotron content-container">
			@if($comment->content != null)
			
			<p class="text-comment">{{$comment->content}}</p>
			
			@endif
			@if(! $comment->images->isEmpty())
			@php
				$count = $comment->images->count();
				$i = 0;
			@endphp
			
			

			<a href="#" onclick="showImage(this)">
				
				@if($count > 1)
					<span class="text-over-image">(+{{$count - 1}})</span>
				@endif
				<img class="image-under-text img-center" src="{{asset($comment->images[0]->path)}}">
				@for($i=1; $i < $count; $i++)
				<img class="img-fluid" src="{{asset($comment->images[$i]->path)}}" 
					style="display: none">
				@endfor
				
			</a>
			

			@endif
			<span class="text-location"><i>{{$comment->location}}</i></span>
			</div>
			@auth
			@php
				$user = Auth::user();
			@endphp

			<div onclick='replyComment(this, "{{$comment->id }}", "{{$user->username}}", "{{$user->avatar}}")'>REPLY</div>
			@endauth
			@foreach($comment->children as $child)
			<div class="row comment-container">
				<div class="col-sm-2 avatar-container"> 
					<a href="#">
						<img src="{{asset($child->user->avatar)}}" class="img-center img-avatar-child">
						<p class="username">{{$child->user->username}}</p>
					</a>
				</div>
				<div class="col-sm-10">
					<div class="jumbotron content-container">
						@if($child->content != null)
							<p class="text-comment">{{$child->content}}</p>
						@endif
						@php
							$countChildren = $child->images->count();
						@endphp
						@if($countChildren > 0)
						<a href="#" onclick="showImage(this)">
							@if($countChildren > 1)
							<span class="text-over-image">(+{{$countChildren - 1}})</span>
							@endif
							<img class="image-under-text img-center" src="{{asset($child->images[0]->path)}}">
							@for($i=1; $i < $countChildren; $i++ )
								<img class="img-center" src="{{asset($child->images[$i]->path)}}" style="display: none">
							@endfor
						</a><br>
						@endif
						<span class="text-location"><i>{{$comment->location}}</i></span>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-sm-2">
		</div>
	</div>
	@endforeach
	
	@auth
	@php
		$user = Auth::user();
	@endphp
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-2 avatar-container"> 

			<a href="#"><img src="{{asset( Auth::user()->avatar )}}" class="img-center img-avatar">
				<p class="username">{{Auth::user()->username}}</p>
			</a>
		</div>
		<div class="col-sm-7 total-comment">
			<div class="jumbotron content-container">
				<form id="comment_form"  enctype="multipart/form-data" 
					onsubmit='commentPlan(event, this)'>
					<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
					
						<input type="text" name="comment_text" id="comment_text" style="width: 80%;" placeholder="Write a comment...">
						<label for="comment_images" class="lb-image" style="padding: 0px; margin: 0px;">
							<span class="fa fa-file-picture-o" style="font-size:24px"></span>
						</label>
						<input type="file" name="comment_images[]" id="comment_images" 
							multiple onchange='openFile(event,"images_container")' style="visibility: hidden; width: 0%" accept="image/*">
						<input type="submit" value="cmt" style="visibility: hidden; width: 0%">
						<button type="button" onclick='camera("snapshot_container")' class="btn" style="background-color: transparent; margin: 0px; padding: 0px;">
							<span class="fa fa-camera" style="font-size: 24px;"></span>
						</button>
				</form> 
			</div>
			<div class="row col-sm-12" id="images_container">
			</div>
			<div class="row col-sm-12" id="snapshot_container">
			</div>
			
		</div>
		<div class="col-sm-2">
			<div id="location">
			</div>
		</div>
		
	</div>
	@endauth
	
	<script type="text/javascript">
		function countComment(){
			var element = document.getElementById("count_comment");
			var count = element.innerHTML;
			element.innerHTML = parseInt(count) + 1;
			
		}

	//	var checkin;
		var dataURL = "";
		var no = 0;
		
		function validateImage(file){
			var extention = file.substring(
							file.lastIndexOf('.')+1);
			console.log(extention);
			var patter = /(jpg|jpeg|png|gif)$/i;
			return patter.test(extention)
		}
		function comment2(form, parent_id){
			var is_pass = validateForm(form);
			if(!is_pass)
				return false;
			getLocation();
			var formData = new FormData(form);
			formData.append("address", checkin);
			formData.append("snapShot", dataURL);
			formData.append("parent_id", parent_id);
			
			var request = new XMLHttpRequest();
			request.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	dataURL = "";
			      	var result = JSON.parse(this.responseText);
			      	var parent = form.parentElement;
					var grandParent = parent.parentElement;
					str = '<div class="jumbotron content-container">'
					if(result[0]["content"] != null)
						str += '<p class="text-comment">' + result[0]["content"] + '</p>';
					if(result[1].length > 0){
						var i;
						str += '<a href="#" onclick="showImage(this)">';
						if(result[1].length > 1){
							str += '<span class="text-over-image">' + '(+' + (result[1].length -1) + ')</span>'; 
						}
						str += '<img src="{{url('') }}' + '/' + result[1][0]["path"] + '" class="image-under-text img-center">';

						for(i=1; i < result[1].length; i++){
							str += '<img src="{{url('') }}' + '/' + result[1][i]["path"] + '" class="img-fluid" style="display: none;">';
						}
						str += '</a>';
					}
					str += '<span class="text-location"><i>' + result[0]["location"] + '</i></span>';
					str += '</div>'
					
					grandParent.innerHTML = str;
					countComment();
			    }
			  };
			request.open("POST", "{{route('comment.upload',['plan_id' => $plan->id])}}", 
				true);
			request.send(formData);
		}
		function openFile(event, imgContainerId) {
			var input = event.target;
			var is_image = false;
			var x = document.getElementById(imgContainerId);
			while (x.hasChildNodes()) {   
    			x.removeChild(x.firstChild);
			}
			var i;
			var length = input.files.length;
			for(i = 0; i < input.files.length; i++) {
				console.log(input.files[i].name);
				is_image = validateImage(input.files[i].name);
				if(!is_image){
					var error = document.getElementById("contentError");
					error.innerHTML = '<div class="alert alert-danger">' 
					+ '<strong>Error</strong> Please, choose image!</div>';
					$("#imageError").modal("show");
					return false;
				}
				readFile(input.files[i], i, x);
		
			}
			
		};
		function readFile(file, i, x) {
			var image = document.createElement("img");
			image.id = "image" + i;
			var reader = new FileReader();
			reader.addEventListener('load', function() {
				var dataURL = reader.result;
				image.src = dataURL;
				image.classList.add("img-fluid");
				image.style.width = "160px";
				image.style.height = "160px";
 				
			});
			reader.readAsDataURL(file); 
			x.appendChild(image);
		}

		function test(node) {
			var parent = node.parentElement;
			var spans = parent.getElementsByTagName("span");
			
			checkin = "Van Anh";
		}
		function replyComment(node, parent_id, user_name, user_avatar ){
			
			var parent = node.parentElement;
			//form existed
			var forms = parent.getElementsByTagName("form");
			if(forms.length > 0)
				return false;
			//avatar side
			no++;
			var parentDiv1 = document.createElement("div");
			parentDiv1.classList.add("row");
			parentDiv1.classList.add("comment-container")
			createAvatar(parentDiv1,true, user_name, user_avatar);
			makeCommentForm(parentDiv1, true, parent_id);
			parent.appendChild(parentDiv1);
		}
		function makeCommentForm(node, is_child, parent_id) {
				var div2 = document.createElement("div");
				var _1stChildDiv2 = document.createElement("div");
				_1stChildDiv2.classList.add("jumbotron");
				_1stChildDiv2.classList.add("content-container");
				var _2ndChildDiv2 = document.createElement("div");
				_2ndChildDiv2.classList.add("row");
				_2ndChildDiv2.classList.add("col-sm-12");
				var _3rdChildDiv2 = document.createElement("div");
				_3rdChildDiv2.classList.add("row");
				_3rdChildDiv2.classList.add("col-sm-12");
				div2.appendChild(_1stChildDiv2);
				div2.appendChild(_2ndChildDiv2);
				div2.appendChild(_3rdChildDiv2);
				var formComment = document.createElement("form");
				formComment.enctype = "multipart/form-data";
				var token = document.createElement("input");
				token.name = "_token";
				token.type = "hidden";
				token.value = "{{csrf_token()}}";
				var comment_text = document.createElement("input");
				comment_text.type = "text";
				comment_text.name = "comment_text";
				comment_text.style.width = "80%";
				comment_text.placeholder = "Write a comment...";
				var label_images = document.createElement("label");
				label_images.style.paddingLeft = "5px";
				label_images.style.margin = "0px";
				var icon_images = document.createElement("span");
				
				icon_images.setAttribute('class','fa fa-file-picture-o')
				icon_images.setAttribute('aria-hidden', true);
				
				icon_images.style.fontSize = "24px";
				label_images.appendChild(icon_images);
				var comment_images = document.createElement("input");
				comment_images.type = "file";
				comment_images.name = "comment_images[]";
				comment_images.setAttribute("multiple", "");
				comment_images.style.visibility = "hidden";
				comment_images.style.width = "0%";
				var submitBtn = document.createElement("input");
				submitBtn.type = "submit";
				submitBtn.value = "cmt";
				submitBtn.style.visibility = "hidden";
				submitBtn.style.width = "0%";
				var cameraBtn = document.createElement("button");
				cameraBtn.type = "button";
				cameraBtn.classList.add("btn");
				cameraBtn.style.backgroundColor = "transparent";
				cameraBtn.style.margin = "0px";
				cameraBtn.style.padding = "0%";
				var icon_camera = document.createElement("span");
			
				icon_camera.setAttribute('class','fa fa-camera');
				icon_camera.setAttribute('aria-hidden', true);
				icon_camera.style.fontSize = "24px";
				cameraBtn.appendChild(icon_camera);
				if(is_child){
					div2.classList.add("col-sm-10");
					cameraBtn.id = "camera" + no;
					_2ndChildDiv2.id = "images_container" + no;
					_3rdChildDiv2.id = "snapshot_container" + no;
					formComment.id = "comment_child" + no;
					comment_images.id = "comment_images" + no;
					label_images.htmlFor = comment_images.id;
					formComment.addEventListener("submit", function(e){
						e.preventDefault();
						$("#location").empty();
						comment2(this, parent_id);
					});
					
				}else{
					div2.classList.add("col-sm-7");
					div2.classList.add("total-comment");
					cameraBtn.id = "camera";
					_2ndChildDiv2.id = "images_container";
					_3rdChildDiv2.id = "snapshot_container";
					formComment.id = "comment_form";
					comment_images.id = "comment_images";
					label_images.htmlFor = comment_images.id;
					formComment.onsubmit = function(){commentPlan(event, this)};
				}
				comment_images.onchange = function(){openFile(event, _2ndChildDiv2.id)};
				cameraBtn.onclick = function(){camera(_3rdChildDiv2.id)};
				
				formComment.appendChild(token);
				formComment.appendChild(comment_text);
				formComment.appendChild(label_images)
				formComment.appendChild(comment_images);
				formComment.appendChild(submitBtn);
				formComment.appendChild(cameraBtn);
				_1stChildDiv2.appendChild(formComment);
				node.appendChild(div2);
		}
		//avatar comment div-a-img
		
		function createAvatar(node, is_child, user_name, user_avatar) {
				var div1 = document.createElement("div");
				div1.classList.add("col-sm-2");
				div1.classList.add("avatar-container");
				var userLink = document.createElement("a");
				userLink.href = "#";
				var usernameContainer = document.createElement("p");
				usernameContainer.classList.add("username");
				var usernameText = document.createTextNode(user_name);
				usernameContainer.appendChild(usernameText);
				var str = '';
				if(is_child){
					str += '<img class="img-center img-avatar-child" src="{{url('') }}' + '/' + user_avatar + '">';
				} else{
					str += '<img class="img-center img-avatar" src="{{url('') }}' + '/' + user_avatar + '">'
				}
				userLink.innerHTML = str;
				userLink.appendChild(usernameContainer);
				div1.appendChild(userLink);
				node.appendChild(div1);
		}
		
		//content comment-div-p
		function createContent(node) {
				var div2 = document.createElement("div");
				div2.classList.add("row");
				div2.classList.add("col-sm-9");
				div2.classList.add("jumbotron");
				var para = document.createElement("p");
				var content = document.createTextNode("Duis non volutpat arcu, eu mollis tellus. Sed finibus aliquam neque sit amet sodales. Lorem ipsum dolor sit amet, consectetur adipiscin.");
				para.appendChild(content);
				div2.appendChild(para);
				node.appendChild(div2);


		}
		
		function validateForm(form){
			var input_elements = form.getElementsByTagName("input");
			if((input_elements[1].value == "") && (input_elements[2].files.length == 0) && (dataURL == ""))
				return false;
			var i =0;
			var is_image = false;
			for(i = 0; i < input_elements[2].files.length; i++){
				is_image = validateImage(input_elements[2].files[i].name);
				if(!is_image){
					var error = document.getElementById("contentError");
					error.innerHTML = '<div class="alert alert-danger">' 
					+ '<strong>Error</strong> Please, choose image!</div>';
					$("#imageError").modal("show");
					return false;
				}
				console.log("true");
			}
			return true;
		}
		function commentPlan(e, form){
			getLocation();
			e.preventDefault();
			var is_pass = validateForm(form);
			if(!is_pass)
				return false;
			var formData = new FormData(form);
			formData.append("address", checkin);
			console.log(checkin);
			formData.append("snapShot", dataURL);
			var request = new XMLHttpRequest();
			request.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	dataURL = "";
			      	var result = JSON.parse(this.responseText);
			      	var parent = form.parentElement;
					var grandParent = parent.parentElement;
					str = '<div class="jumbotron content-container">'
					if(result[0]["content"] != null)
						str += '<p class="text-comment">' + result[0]["content"] + '</p>';
					if(result[1].length > 0){
						var i;
						str += '<a href="#" onclick="showImage(this)">';
						if(result[1].length > 1){
							str += '<span class="text-over-image">' + '(+' + (result[1].length -1) + ')</span>'; 
						}
						str += '<img src="{{url('') }}' + '/' + result[1][0]["path"] + '" class="image-under-text img-center">';
						for(i=1; i < result[1].length; i++){
							str += '<img src="{{url('') }}' + '/' + result[1][i]["path"] + '" class="img-fluid" style="display: none;">';
						}
						str += '</a>';
					}
					str += '<span class="text-location"><i>' + result[0]["location"] + '</i></span>';
					str += '</div>';
					str += '<div onclick=\'replyComment(this,'+ result[0]["id"]+',\"' +result[2]["username"] + '\",\"' + result[2]["avatar"]+ '\")\'>REPLY</div>';
					var comment = document.createElement("div");
					comment.classList.add("row");
					comment.classList.add("comment-container");
					var _1stChild = document.createElement("div");
					_1stChild.classList.add("col-sm-1");
					var lastChild = document.createElement("div");
					lastChild.classList.add('col-sm-2');
					comment.appendChild(_1stChild);
					createAvatar(comment,false, result[2]["username"], result[2]["avatar"]);
					makeCommentForm(comment, false);
					comment.appendChild(lastChild);
					grandParent.innerHTML = str;
					var node = grandParent.parentElement;
					node.parentElement.appendChild(comment);
					countComment();
					
			    }
			  };
			request.open("POST", "{{route('comment.upload',['plan_id' => $plan->id])}}", 
				true);
			request.send(formData);
		}
		
	
	</script>


