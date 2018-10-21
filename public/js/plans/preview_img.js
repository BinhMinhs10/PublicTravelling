function readURL(input) {

	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#imgCover').css('background-image', 'url('+e.target.result+')');
		}

		reader.readAsDataURL(input.files[0]);
	}
}

$("#cover").change(function() {
	readURL(this);
	$("#cover").valid();
});

$("#avatar").change(function() {
	readURL(this);
});