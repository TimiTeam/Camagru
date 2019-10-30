<?php
if (!isset($_SESSION['user_in']))
    header("Location: http://localhost:8080/camagru/");
?>
<h2>Make your photo here</h2>
<dialog id="dialog">
    <p>Post this image?</p>
    <input type="text" id="post_title" name="title" required><br>
    <p>
        <img id="posting_image" width="640" height="480">
    </p>
    <br>
    <button id="close">Cancel</button>
    <button id="post">Post</button>
</dialog>
<div class="cont">
    <div class="first">
        <video id="video" width="640" height="480" autoplay></video>
        <br>
        <button id="snap" onclick="makePhoto();">Make Phto</button>
    </div>
    <div id="photos" class="second" style="width:200px">
    </div>
</div>
<script>

var video = document.getElementById('video');
var i = 0;

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.srcObject = stream;
        video.play();
    });
}

document.getElementById("close").onclick = function() {
    dialog.close();
};

document.getElementById("post").onclick = function() {
    saveImage();
    dialog.close();
};


function loadImg(elem){
    if (elem.src.length > 0)
    {
        document.getElementById("posting_image").setAttribute("src", elem.src);
        document.getElementById("dialog").show();
    }
}

function makePhoto(){
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d')
          .drawImage(video, 0, 0, canvas.width, canvas.height);
    var img = new Image(video.videoWidth, video.videoHeight);
    img.setAttribute("id", "img_"+i);
    img.setAttribute("onclick", "loadImg(this);");
    img.classList.add("render");
    img.src = canvas.toDataURL("image/png");
    document.getElementById("photos").prepend(img);
    document.getElementById("img_"+i).insertAdjacentHTML('beforebegin', '<br>');
    i++;
}


function  saveImage(){
    var src = document.getElementById("posting_image").src;
    var request = new XMLHttpRequest();
    request.open("POST", "postPhoto");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText == "error"){
                alert("Some error, ty again");
            }
                document.location.href = this.responseText;
        }
    };
    var formData = new FormData();
    formData.append('posted_image', src);
    formData.append('title', document.getElementById("post_title").value);
    request.send(formData);
}

function  saveImage2(){
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

                var src = "/camagru/"+this.responseText;
               /* var img = new Image(video.videoWidth, video.videoHeight);
                //document.createElement("img");
                img.setAttribute("id", "img_"+i);
                img.setAttribute("id", "img_"+i);
                //img.src = this.responseText;
                console.log(this.responseText);
                //img.src = canvas.toDataURL();
                img.setAttribute("src", src);
                img.classList.add("render");
                document.getElementById("photos").append(img);
                //document.getElementById("photos").insertAdjacentHTML('afterbegin', src);*/
                //document.getElementById("img_"+i).setAttribute("name", src);
                document.getElementById("img_"+i).setAttribute("src", canvas.toDataURL());
            }
            else
                console.log("Error");
        }
                
    };
    var formData = new FormData();

   // var img = document.createElement("img");
    //img.src = 

    formData.append('img', canvas.toDataURL("image/png"));
    formData.append('count', i);
    request.send(formData);

    
    //console.log(canvas.toDataURL("image/png"));
}


</script>