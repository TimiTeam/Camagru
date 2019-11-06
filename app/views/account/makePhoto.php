<style>
body {
    height: 100%;
}

@keyframes animate {
    from {
    top:-320px; opacity:0}
    to {top:0; opacity:1}
}

.main_panel{
    width: 60%;
    min-width: 400px;
    height: 100%;
    min-height: 720px;
    margin-left: 20%;
}

div.cont{
    width: 100%;
    min-width: 420px;
    display: inline-flex;
    border: 2px dashed blue;
}

img.cont{
    max-width: 100%;
    height: auto;
}

.masks{
    padding: 2%;
    width: 20%;
}

div.video_div{
    padding: 2%;
    width: 100%;
    min-width: 320px;
    text-align: center;
    display: inline-block;
}

div.rendered{
    padding: 2%;
    width: 20%;
    height: 600px;
    overflow-y:scroll;
}

video{
    border: 1px solid #ddd;
    border-radius: 2%;
    width: 100%;
    padding: 5px;
}

img.render {
    border: 1px solid #ddd;
    border-radius: 10%;
    padding: 5px;
    width: 76%;
    height: auto;
}

.masks{
    min-width: 64px;
}

.one_mask{
    margin-top: 5%;
    width: 60%;
}

img.render:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}

.modal {
    display: none;
    position: absolute;
    background-color: rgb(0,0,0);
    background-color: rgba(120, 74, 226, 0.92);
    overflow: auto;
    z-index: 1000;
    width: 50%;
    margin-left: 5%;
    border-radius: 1%;
}

.title{
    width: 30%;
}

.modal-header-footer{
    text-align: center;
}

.img_modal{
    border-radius: 2%;
    width: 70%;
    height: auto;
    border: 1px dashed black;
}

.modal-content {
    text-align: center;
    animation-name: animate;
    animation-duration: 0.5s
}

.close {
    float: right;
    margin-right: 2%;
    font-size:  30px;
    font-weight:  bold;
}
</style>

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
            var r = video.getBoundingClientRect();
            if (e.clientY >= r.top && e.clientY <= r.bottom && e.clientX >= r.left && e.clientX <= r.right){
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


    var ms = video.getBoundingClientRect();

    var re = getCoords(video);


    console.log(ms);
    console.log(re);
    masksArray.forEach (function(masksArray){
        var r = masksArray.getBoundingClientRect();
        var pso = getCoords(masksArray);
        console.log(r);
        console.log(pso);
        var x = pso.left - re.left;
        var y = pso.top - re.top;
        console.log(x);
        console.log(y);
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