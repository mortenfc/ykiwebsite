<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Level 1</title>
  
  <link rel="stylesheet" href="../olCustom.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link id="loading" rel="stylesheet" href="../media/loading/loading.css">
  <link rel="stylesheet" href="../styles.css?version=1.3">
  <link rel="text/javascript" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

  <link href="https://vjs.zencdn.net/7.6.0/video-js.css" rel="stylesheet">


</head>

<body oncontextmenu="return false">
  <!-- <script src="../media/pdfViewer.js">
    $('link[href="../media/loading/loading.css"], style').remove();
  </script> -->
  <script>
    $(document).ready(function() {
      // let canvas = document.getElementById("myCanvas");
      // const ctx = canvas.getContext('2d');

      // const image = new Image(); // Using optional size for image
      // image.onload = drawImageActualSize; // Draw when image has loaded

      // Load an image of intrinsic size 300x227 in CSS pixels
      // image.src = '../cat.jpg';

      // function drawImageActualSize() {
      //   // Use the intrinsic size of image in CSS pixels for the canvas element
      //   canvas.width = this.naturalWidth;
      //   canvas.height = this.naturalHeight;

      //   // Will draw the image as 300x227, ignoring the custom size of 60x45
      //   // given in the constructor
      //   ctx.drawImage(this, 0, 0);

      //   // To use the custom size we'll have to specify the scale parameters 
      //   // using the element's width and height properties - lets draw one 
      //   // on top in the corner:
      //   // ctx.drawImage(this, 0, 0, this.width, this.height);
      // }
      // $('#vidOne').style.display = "block";
      // document.getElementById("vidOneWrap").style.display = "";
      // document.getElementById("enableJS").style.display = "none";
      // var x = document.getElementById("vidOne");
      // if (x.style.display === "none") {
      //   x.style.display = "block";
      // } else {
      //   x.style.display = "none";
      // }
      var width = 1400;
      $('#vidOne').attr("width", width.toString());
      $('#vidOne').attr("height", (1080 / 1920 * width).toString());
    });
  </script>

  <div class="home-wrapper-wrapper">
    <div class="home-wrapper">
      <div class="video">

        <!-- <div class="loading">
          <div class="shape shape-1"></div>
          <div class="shape shape-2"></div>
          <div class="shape shape-3"></div>
          <div class="shape shape-4"></div>
        </div> -->
        <h1> Level 1 </h1>
        <hr>
        <h3 id="enableJS" style="color:blueviolet;">Please enable JavaScript in your browser settings to access the content</h3>
        <script>
          document.getElementById("enableJS").style.display = "none";
        </script>
        <div id="vidOneWrap" style="display: none;">
          <video id='vidOne' class='video-js vjs-default-skin vjs-16-9' controls preload='auto' poster='../media/worldMap.jpg' data-setup='{}'>
            <!-- <video id='vidOne' class='video-js' controls preload='auto' width='640' height='264' data-setup='{}'> -->
            <source src='http://localhost/multiLoginOOP/media/videos/vidOne.mp4' type='video/mp4'>
            <p class='vjs-no-js'>
              To view this video please enable JavaScript, and consider upgrading to a web browser that
              <a href='https://videojs.com/html5-video-support/' target='_blank'>supports HTML5 video</a>
            </p>
          </video>
        </div>
        <script>
          document.getElementById("vidOneWrap").style.display = "";
        </script>
      </div>

      <div class="pdf">

        <div class="loading">
          <div class="shape shape-1"></div>
          <div class="shape shape-2"></div>
          <div class="shape shape-3"></div>
          <div class="shape shape-4"></div>
        </div>

        <!-- <canvas id="myCanvas"></canvas> -->
        <!-- <canvas id="canvasPages"></canvas>
        <div>
          <span id="page_num"></span>
          <span>/</span>
          <span id="page_count"></span>
        </div>
        <button id="prev" class="btn btn-lg btn-secondary">Prev</button>
        <button id="fullScreen" class="btn btn-lg vjs-icon-placeholder">Fullscreen</button>
        <button id="zoomIn" class="btn btn-lg vjs-icon-placeholder">Zoom in</button>
        <button id="zoomOut" class="btn btn-lg vjs-icon-placeholder">Zoom out</button>
        <button id="zoomReset" class="btn btn-lg vjs-icon-placeholder">Reset</button>
        <button id="next" class="btn btn-lg btn-secondary">Next</button> -->

      <!-- </div>
      <div class="footer pull-down">
        Copyright ©
        <?php $the_year = date("Y");
        echo $the_year; ?>
        <?php echo "https://www.ykitest.website/" ?>
        All Rights Reserved.
      </div>
    </div> -->
  </div>

  <script src='https://vjs.zencdn.net/7.6.0/video.js'></script>
  <script src='../dist/main.js'></script>

</body>

</html>