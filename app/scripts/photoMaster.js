
function    updatePost(id, like){
    var request = new XMLHttpRequest();
    request.open("POST", "likePost");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText == 'ok'){
                return true;
            }else if (this.responseText == 'error')
                return false
        }
    };
    var formData = new FormData();
    formData.append('pos_id', id);
    formData.append('like', like);
    request.send(formData);
    return (true);
}

function    desLikePost(elem, id){
    var like =  Number.parseInt(elem.lastElementChild.innerHTML);
    if (updatePost(id, --like)){
        elem.lastElementChild.innerHTML = like;
        hart = elem.children[0];
        if (hart)
            hart.src = "/camagru/app/res/like.png";
        elem.setAttribute("onclick", 'likeThePost(this,"'+id+'");');
    }
}

function    likeThePost(elem, id){
    var like =  Number.parseInt(elem.lastElementChild.innerHTML);
    if (updatePost(id, ++like)){
        elem.lastElementChild.innerHTML = like;
        hart = elem.children[0];
        if (hart)
            hart.src = "/camagru/app/res/like_like.png";
        elem.setAttribute("onclick", 'desLikePost(this,"'+id+'");');
    }
}

