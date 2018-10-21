

{{-- Trigger the modal with a button --}}
{{--<button type="button" class="btn btn-info btn-lg" id="camera">Open Modal</button>--}}

{{-- Modal --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      {{-- Modal content--}}
      	<div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title">Modal Header</h4>
	          <button type="button" class="close" data-dismiss="modal" id="modal_close">&times;</button>
	          
	        </div>
	        <div class="modal-body">
	          <video id="player" autoplay class="img-fluid"></video>
	        </div>
	        <div class="modal-footer">
	          <button id="capture" type="button" class="btn btn-default">Capture</button>
	        </div>
      	</div>
      
    </div>
 </div>
<script>
	
		function camera(containerId) {
		
			var x = document.getElementById(containerId);
			
			while (x.hasChildNodes()) {   
    			x.removeChild(x.firstChild);
			}
			dataURL = "";
			$("#myModal").modal("show");			
			var player = document.getElementById('player');
			var captureButton = document.getElementById('capture');
			var closeButton = document.getElementById('modal_close');
			const constraints = {
			    video: true,
			};
			 // Attach the video stream to the video element and autoplay.
			navigator.mediaDevices.getUserMedia(constraints)
			    .then((stream) => {
				     player.srcObject = stream;
			});
			captureButton.onclick = function(){displaySnapshot(x)};
			closeButton.addEventListener('click', () => {
				// Stop all video streams.
			    player.srcObject.getVideoTracks().forEach(track => track.stop());
			    
			    return false;
			});
			
			
		}
		function displaySnapshot(container){
			while (container.hasChildNodes()) {   
    			container.removeChild(container.firstChild);
			}
		 // Draw the video frame to the canvas.
			var canvas = document.createElement("CANVAS"); 
			canvas.setAttribute("width","750px");
			canvas.setAttribute("height", "550px");
			var image = document.createElement('img');
			var context = canvas.getContext('2d');
			context.drawImage(player, 0, 0, canvas.width, canvas.height);
			image.src = canvas.toDataURL('image/png');
			dataURL = canvas.toDataURL('image/png');

		   console.log(typeof dataURL);
			image.style.height = "160px";
			image.style.width = "160px";
			
			
			container.appendChild(image);

		}
	
  
</script>
