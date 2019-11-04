

window.onload = function(){
    var collection = document.getElementById("masks").childNodes;
    if (collection){
      for(var i = 0; i < collection.length; i++){
          new_msk.set(collection[i].nodeId, 0);
          console.log(collection);
      }
    }
};

/*
var objects = document.querySelectorAll('#masks> .objects');
if (objects) {
    [].forEach.call(objects, function (el) {
        el.setAttribute('draggable', 'true');
        el.addEventListener('dragstart', dragStart, false);
        el.addEventListener('dragend', dragEnd, false);
        console.log(e.clientX);

  console.log(e.clientY);
    });
}*/