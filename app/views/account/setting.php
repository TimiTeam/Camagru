<?php
if (!isset($_SESSION['user_in']))
	header("Location: http://localhost:8080/camagru/");
if (isset($notify) &&  $notify == 0)
	$notify_input  = '<input type="radio" name="notify" value="1"> Activate
    <input type="radio" name="notify" value="0" checked> Deactivate';
else
	$notify_input  = '<input type="radio" name="notify" value="1" checked> Activate
    <input type="radio" name="notify" value="0"> Deactivate';
?>
<div class="main_panel">
    <h2>Welcome <?php echo $login ?> </h2>
    <form action="" method="POST">
        <p>First name: <b id="name"> <?php echo $first_name?></b><br>
        <input type="hidden" id="first_name" name="first_name">
        <input type="button" name="first_name" value="Edit" onclick="editElement(this, 'name');">
        </p>
        <p>Last name: <b id="last"><?php echo $last_name ?></b><br>
        <input type="hidden" id="last_name" name="last_name">
        <input type="button" name="last_name" value="Edit" onclick="editElement(this, 'last');">
        </p>
        <p>Email: <b id="email"><?php echo $email?></b><br>
        <input type="hidden" id="new_email" name="email">
        <input type="button" name="new_email" value="Edit" onclick="editElement(this, 'email');">
        </p>
        <p>Login: <b id="login"><?php echo $login?></b><br>
        <input type="hidden" id ="new_login" name="login">
        <input type="button" name="new_login" value="Edit" onclick="editElement(this, 'login');">
        </p>
        <p>Notify me by email about commenting my post<br>
    	<?php echo $notify_input ?></p>
        <input type="button" value="Edit password" onclick="changePassword(this);">
        <div id="pas_div" style="display: none">
        <p>
            <p id="error_info" style="color:red;"></p>
            Current password<br>
            <input type="password" id ="cur_pass" name="pass" ></p>
            <input type="button" value="Next" onclick="validCurrentPassword();">

            <div id="new_pas_div" style="display: none">
                <p>New password<br>
                    <input type="password" id ="new_pass" name="password"><br>
                    Confirm password<br>
                    <input type="password" id ="conf_pass" name="conf_pass" onkeyup="confirmPass(this);">
                </p>
            </div>
        </div>
        <br>
        <p><button>Save All</button></p>
    </form>
</div>
<script>
function    editElement(element, filed){
    var elem = document.getElementById(element.name);
    if (element.value == "Edit"){
        element.value = "Cancel";
        document.getElementById(element.name).setAttribute("type", "text");
    }
    else if (element.value == "Cancel"){
        elem.value = "";
        element.value = "Edit";
        document.getElementById(element.name).setAttribute("type", "hidden");
    }
}

function    changePassword(elem){
    var doc = document.getElementById("pas_div");
    doc.style.display = "block";
}

function    setText(text){
    document.getElementById("error_info").textContent = text;
}

function    confirmPass(elem){
    if (document.getElementById("new_pass").value != elem.value)
        setText("Password does not match");
    else
        setText("");
}


function    validCurrentPassword(){
    var elem = document.getElementById("cur_pass");
    var request = new XMLHttpRequest();
    request.open("POST", "validPassword");
    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            if (this.responseText != "ok"){
                setText("Wrong password");
                elem.value = "";
            }
            else{
                setText("");
                document.getElementById("new_pas_div").style.display = "block";
            }
            console.log(this.responseText);
        }
    };
    var formData = new FormData();
    formData.append('curr_pass', elem.value);
    request.send(formData);
}

</script>
