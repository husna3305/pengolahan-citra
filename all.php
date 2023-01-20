<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=500, initial-scale=1.0">
  <title>Pengolahan Citra</title>
</head>
<style>
  #myCanvas {
    border: 1px solid black;
  }
</style>

<body>
  <input type="file" id="file" onchange="pilihGambar(event)"><br><br>
  <button onclick="setReset()">Reset</button>
  <button onclick="setGrayscale()">Grayscale</button>
  <button onclick="setInvert()">Invert</button>
  <button onclick="setBlackAndWhite()">Black & White</button>
  <button onclick="setBrightness('-')">Brightness (-)</button>
  <button onclick="setBrightness('+')">Brightness (+)</button>
  <br>
  <br>
  <img src="133-400x300.jpg" id="img" style="display: none;">
  <canvas id="myCanvas" width="400" height="400"></canvas>

  <script>
    img = document.querySelector('#img');
    img.crossOrigin = "Anonymous";

    myCanvas = document.querySelector('#myCanvas');
    context = myCanvas.getContext("2d");

    img.onload = function() {
      myCanvas.width = img.width;
      myCanvas.height = img.height;
      context.drawImage(img, 0, 0);
    }

    function pilihGambar(event) {
      var selectedFile = event.target.files[0];
      var reader = new FileReader();

      var imgtag = document.getElementById("img");
      imgtag.title = selectedFile.name;

      reader.onload = function(event) {
        imgtag.src = event.target.result;
      };

      reader.readAsDataURL(selectedFile);
    }

    function setReset() {
      context.drawImage(img, 0, 0);
      img.onload = function() {
        myCanvas.width = img.width;
        myCanvas.height = img.height;
        var imageData = context.getImageData(0, 0, img.width, img.height);
        context.putImageData(imageData, 0, 0);
      }
    }

    function setGrayscale() {

      // context.filter = 'grayscale(1)';
      // context.drawImage(img, 0, 0, img.width, img.height);

      var imageData = context.getImageData(0, 0, img.width, img.height);
      var dataArray = imageData.data;
      for (var i = 0; i < dataArray.length; i += 4) {
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        var alpha = dataArray[i + 3];

        var gray = 0.2126 * red + 0.7152 * green + 0.0722 * blue;

        dataArray[i] = gray;
        dataArray[i + 1] = gray;
        dataArray[i + 2] = gray;
        dataArray[i + 3] = alpha;
      }
      imageData.data = dataArray;
      context.putImageData(imageData, 0, 0);
    }

    function setInvert() {
      var imageData = context.getImageData(0, 0, img.width, img.height);
      var dataArray = imageData.data;
      for (var i = 0; i < dataArray.length; i += 4) {
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        var alpha = dataArray[i + 3];

        imageData.data[i] = 255 - red;
        imageData.data[i + 1] = 255 - green;
        imageData.data[i + 2] = 255 - blue;
        imageData.data[i + 3] = 255;
      }
      imageData.data = dataArray;
      context.putImageData(imageData, 0, 0);
    }

    function setBlackAndWhite(param = 128) {
      var imageData = context.getImageData(0, 0, img.width, img.height);
      var dataArray = imageData.data;
      for (var i = 0; i < dataArray.length; i += 4) {
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        var alpha = dataArray[i + 3];

        bw = (red + green + blue) / 3;
        if (bw < param) {
          bw = 0;
        } else {
          bw = 255;
        }
        imageData.data[i] = bw;
        imageData.data[i + 1] = bw;
        imageData.data[i + 2] = bw;
        imageData.data[i + 3] = 255;
      }
      imageData.data = dataArray;
      context.putImageData(imageData, 0, 0);
    }

    function setBrightness(param) {
      var imageData = context.getImageData(0, 0, img.width, img.height);
      var dataArray = imageData.data;
      for (var i = 0; i < dataArray.length; i += 4) {
        var red = dataArray[i];
        var green = dataArray[i + 1];
        var blue = dataArray[i + 2];
        var alpha = dataArray[i + 3];

        if (param == '+') {
          imageData.data[i] = dataArray[i] + 5;
          imageData.data[i + 1] = dataArray[i + 1] + 5;
          imageData.data[i + 2] = dataArray[i + 2] + 5;
        } else {
          imageData.data[i] = dataArray[i] - 5;
          imageData.data[i + 1] = dataArray[i + 1] - 5;
          imageData.data[i + 2] = dataArray[i + 2] - 5;
        }
        imageData.data[i + 3] = 255;
      }
      imageData.data = dataArray;
      context.putImageData(imageData, 0, 0);
    }
  </script>
</body>

</html>