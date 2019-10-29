<?php
if (!isset($_SESSION['user_in']))
    header("Location: http://localhost:8080/camagru/");
?>
<h2>Make your photo here</h2>
<video id="video" width="640" height="480" autoplay></video>
<canvas id="canvas" width="640" height="480"></canvas>
<br>
<button id="snap">Make Phto</button>
<button id="i" onclick="printI();">print i</button>
<script>
var video = document.getElementById('video');
var i = 0;
if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.srcObject = stream;
        video.play();
    });

var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');

function printI(){
    alert(i);
}

document.getElementById("snap").addEventListener("click", function() {
    context.drawImage(video, 0, i * 97, 128, 96);
    i++;
    if (i > 4)
        i = 0;
});
}
</script>