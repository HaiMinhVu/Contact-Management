<input id="inputFileToLoad" type="file" onchange="encodeImageFileAsURL();" />
<div id="imgTest"></div>


<canvas id="canvas" width="5" height="5"></canvas>


<script type='text/javascript'>
  function encodeImageFileAsURL() {

    var filesSelected = document.getElementById("inputFileToLoad").files;
    if (filesSelected.length > 0) {
      var fileToLoad = filesSelected[0];

      var fileReader = new FileReader();

      fileReader.onload = function(fileLoadedEvent) {
        var srcData = fileLoadedEvent.target.result; // <--- data: base64

        var newImage = document.createElement('img');
        newImage.src = srcData;

        document.getElementById("imgTest").innerHTML = newImage.outerHTML;
        alert("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
        console.log("Converted Base64 version is " + document.getElementById("imgTest").innerHTML);
      }
      fileReader.readAsDataURL(fileToLoad);
    }
  }
</script>