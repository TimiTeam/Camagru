
    <h2>Welcom in registration</h2>
    <h3>Input your <u> first name, lase name, e-maill, login </u> and <u>password </u></h3>
    <?php if (isset($errors_message)) foreach ($errors_message as $message) echo '<p  style="color:red;">'.$message.'</p>'; ?>
    <form action="" method="POST">
        <p id="error" style="color:red;"></p>
        <p>First name<br>
        <input type="text" name="first_name" required onchange="inputValidation(this);"></p>
        <p>Last name<br>
        <input type="text" name="last_name" required onchange="inputValidation(this);"></p>
        <p>E-maill <br>
        <input type="email" name="email" size="50" required onchange="emailValidation(this);">
        <p>Login<br>
        <input type="text" name="login" onchange="loginValidation(this);"></p> 
        <p>Password<br>
        <input id="pass" type="password" required name="pass" onchange="inputValidation(this);"></p>
        <p>Confirm password<br>
        <input id="confirm" type="password" required name="confirm" onchange="inputValidation(this);"></p>
        <p><button>Register</button></p>
    </form>

<script>

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
            console.log(this.responseText);
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
</script>
</body>
</html>