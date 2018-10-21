<div class="container">
  <!-- The Modal -->
  <div class="modal" id="modalImage">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
          <div id="container" class="carousel slide" data-ride="carousel">
            <!-- The slideshow -->
            <div class="carousel-inner" id="content">
              
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#container" data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#container" data-slide="next">
              <span class="carousel-control-next-icon"></span>
            </a>

          </div>
        </div>
        <!-- Modal footer -->
    </div>
  </div>
</div>
{{--modal error--}}
<!-- The Modal -->
  <div class="modal fade" id="imageError">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body" >
          <div class="carousel-inner" id="contentError">

          </div>
        </div>
      </div>
    </div>
  </div>
<script>
  function showImage(element){
    var images = element.getElementsByTagName("img");
    var i = 0;
    var str = '';
    str += '<div class="carousel-item active">' + 
              '<img src="'+ images[0].src +'" class="img-center">' +
              '</div>';
    for(i = 1; i < images.length; i++){
     
      str += '<div class="carousel-item">' + 
              '<img src="'+ images[i].src +'" class="img-center">' +
              '</div>';
    }
    var container = document.getElementById("content");
    container.innerHTML = str;
    $("#modalImage").modal("show");
  }
</script>

</body>
</html>
