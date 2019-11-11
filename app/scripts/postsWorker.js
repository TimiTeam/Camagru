
window.onload = function () {
    let collection = document.querySelectorAll('.likes');
    if (collection){
        for(let i = 0; i < collection.length; i++){
            let elem = document.getElementById(collection[i].getAttribute('id'));
            if (elem){
                elem.onmouseover = function () {
                    let id = this.getAttribute('id').split('_');
                    let div = document.getElementById('usr_likes'+id[1]);
                    if (div && div.firstChild){
                        div.style.display = "block";
                        div.onmouseout = function () {
                            this.style.display = "none";
                        }
                    }
                }
            }
        }
    }
}

function    updatePost(id, like, status){
    let request = new XMLHttpRequest();
    request.open("POST", "likePost");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText == 'ok'){
                return true;
            }else if (this.responseText == 'error')
                return false
        }
    };
    let formData = new FormData();
    formData.append('pos_id', id);
    formData.append('like', like);
    formData.append('status', status);
    request.send(formData);
    return (true);
}

function    disLikePost(elem, id){
    let like =  Number.parseInt(elem.parentNode.lastElementChild.innerHTML);
    if (updatePost(id, --like, 0)){
        elem.parentNode.lastElementChild.innerHTML = like;
        elem.src = "/camagru/app/res/like.png";
        elem.setAttribute("onclick", 'likeThePost(this,"'+id+'");');
    }
}

function    likeThePost(elem, id){
    let like =  Number.parseInt(elem.parentNode.lastElementChild.innerHTML);
    if (updatePost(id, ++like, 1)){
        elem.parentNode.lastElementChild.innerHTML = like;
        elem.src = "/camagru/app/res/like_like.png";
        elem.setAttribute("onclick", 'disLikePost(this,"'+id+'");');
    }
}
