function    setErrorText(text){
    document.getElementById("error").textContent = text;
}

function    validEmail(email){
    var pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  return pattern.test(email);
}

function    inputValidation(elem){
    if (elem.value.length < 3)
        elem.style.border = "2px solid red";
    else
        elem.style.border = "2px solid #EBE9ED";
}

function    loginValidation(elem){
    var request = new XMLHttpRequest();
    request.open("POST", "validLogin");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText != "ok"){
                setErrorText(elem.value+" Login exist");
                elem.value = "";
            }
            else
                setErrorText("");          
            inputValidation(elem);
        }
    };
    var formData = new FormData();
    formData.append('login', elem.value);

    request.send(formData);
}

function    emailValidation(element){
    var text = document.createTextNode('Invalid');

    if (!validEmail(element.value)){
        element.style.border = "2px solid red";
        setErrorText(" Invalid E-maill");
    }
    else
    {
        element.style.border = "2px solid #EBE9ED";
        setErrorText("");
    }
}
