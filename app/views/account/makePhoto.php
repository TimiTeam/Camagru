<?php
if (!isset($_SESSION['user_in']))
    header("Location: http://localhost:8080/camagru/");
?>
<h2>Make your photo here</h2>
<video id="video" width="640" height="480" autoplay></video>
<div id="photos">
</div>
<br>
<button id="snap" onclick="saveImage();">Make Phto</button>
<script>

var video = document.getElementById('video');
var i = 0;

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.srcObject = stream;
        video.play();
    });
/*
var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');


document.getElementById("snap").addEventListener("click", function() {
    context.drawImage(video, 0, i * 97, 128, 96);
    i++;
    if (i > 4)
        i = 0;
});*/
}

function  saveImage(){
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d')
          .drawImage(video, 0, 0, canvas.width, canvas.height);
    var request = new XMLHttpRequest();
    request.open("POST", "makePhoto");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText != "error"){
                console.log("Ok");
                console.log(this.responseText);
                var img = new Image(video.videoWidth, video.videoHeight);
                //document.createElement("img");
                img.setAttribute("id", "img_"+i);
                img.setAttribute("id", "img_"+i);
                //img.src = this.responseText;
                console.log(this.responseText);
                var src = "/camagru/"+this.responseText;
                //img.src = canvas.toDataURL();
                img.setAttribute("src", src);
                img.classList.add("render");
                document.getElementById("photos").append(img);
                
                //document.getElementById("photos").insertAdjacentHTML('afterbegin', src);
                i++;
                if (i > 4)
                    i = 0;
            }
            else
                console.log("Error");
        }
                
    };
    var formData = new FormData();

   // var img = document.createElement("img");
    //img.src = canvas.toDataURL();

    formData.append('img', canvas.toDataURL("image/png"));
    formData.append('count', i);

    console.log(formData.getAll('img'));

    request.send(formData);

    
    //console.log(canvas.toDataURL("image/png"));
}


</script>