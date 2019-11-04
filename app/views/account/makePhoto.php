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
        <div class="masks" id="masks">
            <?php 
                if (isset($arrayMasks)){
                    for ($i = 0; $i < count($arrayMasks); $i++){
                        echo '<img draggable="true" onclick="moveMask(this);" class="one_mask" id="mask_'.$i.'" name="mask_'.$i.'" src="'.$arrayMasks[$i].'">';
                    }
                }
            ?>
        </div>
        <div class="video_div">
            <figure>
                <video id="video" autoplay>

                </video>
            </figure>
            <button class="clasic_button" id="snap" onclick="makePhoto();">Make Phto</button>
        </div>
        <div id="photos" class="rendered">
        </div>
    </div>
</div>

<script>

var drawImg = 0;
var newMsk = new Map();
var video = document.getElementById('video');
var i = 0;
var rect = video.getBoundingClientRect();

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.srcObject = stream;
        video.play();
    });
}

window.onload = function(){
    collection = document.querySelectorAll('.one_mask');
    if (collection){
      for(var i = 0; i < collection.length; i++){
          newMsk.set(collection[i].getAttribute('id'), 0);
      }
    }
};

function moveMask(ele){
    ele.onclick = function(e){
        var newIm = new Image();
        newIm.src = ele.src;
        var id = newMsk.get(ele.getAttribute('id')) + 1;
        newIm.className = "mask_on_img";
        newIm.style.position = 'absolute';
        newIm.onclick = function(e){
            if (e.pageY >= rect.y && e.pageY <= rect.left && e.pageX >= rect.x && e.pageX <= rect.right){
                newIm.setAttribute('id', id);
                newMsk.set(ele.getAttribute('id'), id);
                document.onmousemove = null;
                newIm.onmouseup = null;
                drawImg++;
            }
            else
                newIm.parentNode.removeChild(newIm);
        }
        moveAt(e);
        document.body.appendChild(newIm);
        function moveAt(e) {
          newIm.style.left = e.pageX - newIm.offsetWidth / 2 + 'px';
          newIm.style.top = e.pageY - newIm.offsetHeight / 2 + 'px';
      }
      document.onmousemove = function(e) {
          moveAt(e);
      }
    }
}

document.getElementById("post").onclick = function() {
    saveImage();
    document.getElementById("modal").style.display = "none";
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
    if (drawImg == 0)
        return;
    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    var masksArray = document.querySelectorAll(".mask_on_img");
    console.log(rect);
    masksArray.forEach (function(masksArray){
        var r = masksArray.getBoundingClientRect();
        console.log(r);
        var x = r.left - rect.left + pageXOffset;
        var y = r.top - rect.top + pageYOffset ;
        ctx.drawImage(masksArray, x, y);
    });
    var img = new Image(video.videoWidth, video.videoHeight);
    img.setAttribute("id", "img_"+i);
    img.setAttribute("onclick", "loadImg(this);");
    img.classList.add("render");
    img.src = canvas.toDataURL("image/png");
    document.getElementById("photos").prepend(img);
    document.getElementById("img_"+i).insertAdjacentHTML('beforebegin', '<br>');
    i++;
}

function getCoords(elem) {
  let box = elem.getBoundingClientRect();

  return {
    top: box.top + pageYOffset,
    left: box.left + pageXOffset
  };
}

function getOffsetSum(elem) {
    var top=0, left=0
    while(elem) {
          top = top + parseFloat(elem.offsetTop)
          left = left + parseFloat(elem.offsetLeft)
          elem = elem.offsetParent       
  }
  return {top: Math.round(top), left: Math.round(left)}
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