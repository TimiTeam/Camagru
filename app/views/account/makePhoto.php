<?php
if (!isset($_SESSION['user_in']))
    header("Location: http://localhost:8080/camagru/");
?>
<div class="main_panel">
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-header-footer" >
                <span class="close" onclick="closePostWind();">×</span>
                <h2>Post this image?</h2>
            </div>
            <div class="modal-body">
                <p >Title
                    <input class="title" type="text" id="post_title" name="title" required ><br>
                </p>
                <p>
                    <img class="img_modal" id="posting_image" width="640" height="480">
                </p>
            </div>
            <div class="modal-header-footer">
                <p class="buttons">
                    <button id="close" onclick="closePostWind();">Cancel</button>
                    <button id="post">Post</button>
                <p>
            </div>
        </div>
    </div>
    <h2>Make your photo here</h2>
    <div class="cont">
        <div class="masks">
            <img>
            <br>
            <img>
        </div>
        <div class="video_div">
            <video id="video" width="640" height="480" autoplay></video>
            <br>
            <button class="clasic_button" id="snap" onclick="makePhoto();">Make Phto</button>
        </div>
        <div id="photos" class="rendered">
        </div>
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

document.getElementById("post").onclick = function() {
    saveImage();
    document.getElementById("modal").style.display = "none";
    //dialog.close();
};


function closePostWind(){
    document.getElementById("modal").style.display = "none";
}

function loadImg(elem){
    if (elem.src.length > 0)
    {
        document.getElementById("posting_image").setAttribute("src", elem.src);
        document.getElementById("modal").style.display = "block";
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

</script>