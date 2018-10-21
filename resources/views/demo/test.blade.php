<html>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body >
	

	<div style="background-image: url('images/themes/bg.jpg'); width: 350px; height: 350px;"></div>
	<input type="file" onchange="previewFile()"><br>
	<img src="" height="200" alt="Image preview...">
	<script>
	   	function previewFile(){
	       	var preview = document.querySelector('img'); //selects the query named img
	       	var file    = document.querySelector('input[type=file]').files[0]; //sames as here
	       	var reader  = new FileReader();

	       	reader.onloadend = function () {
	           preview.src = reader.result;
	       	}

	       	if (file) {
	           reader.readAsDataURL(file); //reads the data as a URL
	       	} else {
	           preview.src = "";
	       	}
	  	}

		previewFile();  //calls the function named previewFile()
	</script>

</body>
</html>