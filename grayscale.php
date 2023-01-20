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
  </script>
</body>

</html>