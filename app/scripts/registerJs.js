var btn;

var btnParent;

window.onload = function () {
    btn = document.getElementById("registerBtn");
    if (btn)
        btnParent = btn.parentNode;
}

function    setErrorText(text){
    document.getElementById("error").textContent = text;
}

function    validEmail(email){
    let pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    return pattern.test(email);
}

function    inputValidation(elem){
    if (elem.value.length < 4){
        elem.style.border = "2px solid red";
        return false;
    }
    else
        elem.style.border = "2px solid #EBE9ED";
    return true;
}

function    passwordValidation(elem){
    let ps =  document.getElementById("pass");
    if (!inputValidation(elem) || !inputValidation(ps)){
        setErrorText("At less 4 symbols ");
    }
    console.log(elem.value);
    console.log(ps.value);
    if (elem.value != ps.value)
        setErrorText("Passwords do not match");
    else
        setErrorText("");
}

function    loginValidation(elem){
    let request = new XMLHttpRequest();
    request.open("POST", "validData");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText != "ok"){
                setErrorText(elem.value+" "+elem.name.charAt(0).toUpperCase()+elem.name.slice(1)+" exist");
                elem.value = "";
            }
            else
                setErrorText("");
            inputValidation(elem);
        }
    };
    let formData = new FormData();
    formData.append(elem.name, elem.value);
    request.send(formData);
}

function    emailValidation(element){
    let text = document.createTextNode('Invalid');

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