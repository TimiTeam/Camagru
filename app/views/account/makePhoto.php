<?php
if (!isset($_SESSION['user_in']))
    header("Location: http://localhost:8080/camagru/");
?>
<div class="main_panel">
    <div class="modal" id="modal">
        <div class="modal-content">
            <div class="modal-title">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close" onclick="closePostWind();">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5  id="exampleModalLabel">Post this image?</h5>
            </div>
            <div ">
                <p>Title
                    <input class="title" type="text" id="post_title" name="title" required maxlength="150">><br>
                </p>
                <p>
                    <img class="img_modal" id="posting_image">
                </p>
            </div>
            <div class="my-modal-footer">
                <p class="buttons">
                    <button id="close" onclick="closePostWind();" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="post" class="btn btn-primary">Post</button>
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
            <div class="main_image">
                <video class="image_src" id="video" autoplay width="640" height="480">
                </video>
            </div>
            <p>
                <button class="classic_button" id="snap" onclick="makePhoto();">Make Phto</button> or
                <input name="myFile" type="file" accept=".jpg, .jpeg, .png" onchange="uploadImgOnScreen(this);">
                <button onclick="clearVideo();">Clear</button>
            </p>
        </div>
        <div id="photos" class="rendered">
        </div>
    </div>
</div>

<script>

var drawImg = 0;
var newMsk = {}
var video = document.getElementById('video');
var i = 0;
var currImg = null;
var lastScrollTop = 0;
var rect = video.getBoundingClientRect();

if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        video.srcObject = stream;
        video.play();
    });
}

window.onload = function(){
    let collection = document.querySelectorAll('.one_mask');
    if (collection){
      for(let i = 0; i < collection.length; i++){
          newMsk[collection[i].getAttribute('id')] = 0;
      }
    }
};

function clearVideo(){
    var masksArray = document.querySelectorAll(".mask_on_img");
    if (masksArray.lenght <= 0)
        return ;
    drawImg = 0;
    masksArray.forEach(function(masksArray){
        masksArray.parentNode.removeChild(masksArray);
    });
}

function uploadImgOnScreen(elem) {
    if (elem.files && elem.files[0]) {
        let image = document.createElement('img');
        image.src = window.URL.createObjectURL(elem.files[0]);
        image.setAttribute('id', "video");
        image.className = "image_src";
        image.style.width = "100%";
        let vi = document.getElementById("video");
        let parent = vi.parentNode;
        parent.removeChild(vi);
        parent.append(image);

        video = image;
    }
}

function resizeMaskOnScroll(){
    if(currImg == null || currImg.width > 400)
        return ;
    let curScroll = document.body.scrollTop || document.documentElement.scrollTop;
  //  if (curScroll > lastScrollTop || curScroll > lastScrollTop) {
    if (curScroll != lastScrollTop || curScroll != lastScrollTop){
        currImg.width += 10;
        currImg.height += 10;
    } else {
        currImg.width -= 10;
        currImg.height -= 10;
    }
    lastScrollTop = curScroll <= 0 ? 0 : curScroll;
}

window.addEventListener('scroll', resizeMaskOnScroll);

function moveMask(ele){
    ele.onclick = function(e){
        let newIm = new Image(ele.width, ele.height);
        newIm.src = ele.src;
        let id = newMsk[ele.getAttribute('id')] + 1;
        newIm.className = "mask_on_img";
        newIm.style.position = 'absolute';
        currImg = newIm;
        newIm.onclick = function(e){
            currImg = null;
            let r = video.getBoundingClientRect();
            if (e.clientY >= r.top && e.clientY <= r.bottom && e.clientX >= r.left && e.clientX <= r.right){
                newIm.setAttribute('id', ele.getAttribute("name") + id);
                newMsk[ele.getAttribute('id')] = id;
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

        console.log(document.getElementById("modal"));
    }
}

function makePhoto(){
    if (drawImg == 0)
        return;
    video = document.getElementById('video');
    var canvas = document.createElement("canvas");
    canvas.width = video.getBoundingClientRect().width;
    canvas.height = video.getBoundingClientRect().height;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    var posCanvs = getCoords(video);
    for(var k in newMsk){
        if (k in newMsk && newMsk[k] > 0){
            for(var i = 1; i <= newMsk[k]; i++){
                var mask = document.getElementById(k+i);
                if (mask){
                    var pos = getCoords(mask);
                    var y = pos.top - posCanvs.top;
                    var x = pos.left - posCanvs.left;
                    ctx.drawImage(mask, x, y, mask.width, mask.height);
                }
            }
        }
    }
    var img = new Image(canvas.width, canvas.height);
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
    var top=0, left=0
    top = parseFloat(box.top) + parseFloat(pageYOffset);
    left = parseFloat(box.left) + parseFloat(pageXOffset);
  return {top: Math.round(top), left: Math.round(left)}
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
                document.location.href = this.responseText.replace(/\n|\r/g, "");
        }
    };
    var formData = new FormData();
    formData.append('posted_image', src);
    formData.append('title', document.getElementById("post_title").value);
    request.send(formData);
}

</script>