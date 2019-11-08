<div class="main_panel">
    <h2>Welcom in registration</h2>
    <h3>Input your <u> first name, lase name, e-maill, login </u> and <u>password </u></h3>
    <?php if (isset($errors_message)) foreach ($errors_message as $message) echo '<p  style="color:red;">'.$message.'</p>'; ?>
    <form action="" method="POST">
        <p id="error" style="color:red;"></p>
        <p>First name<br>
        <input type="text" name="first_name" required minlength="1" onchange="inputValidation(this);"></p>
        <p>Last name<br>
        <input type="text" name="last_name" required minlength="1" onchange="inputValidation(this);"></p>
        <p>Nickname<br>
            <input type="text" name="nickname" required minlength="4" onchange="loginValidation(this);">
        </p>
        <p>E-maill <br>
            <input type="email" name="email" size="50" minlength="4" required onchange="emailValidation(this);">
        <p>Login<br>
        <input type="text" name="login" required minlength="4" onchange="loginValidation(this);"></p>
        <p>Password<br>
        <input id="pass" type="password" required minlength="4" name="pass" onchange="inputValidation(this);"></p>
        <p>Confirm password<br>
        <input id="confirm" type="password" required minlength="4" name="confirm" onchange="passwordValidation(this);"></p>
        <p><button id="registerBtn">Register</button></p>
    </form>
</div>
<script>

var btn = document.getElementById("registerBtn");

var btnParent = btn.parentNode;

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
</script>
</body>
</html>