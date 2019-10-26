<?php
    if (!isset($_SESSION['user_in']))
        header("Location: http://localhost:8080/camagru/");
    $json = json_encode($param);
    $changed = $param;
?>
<h2>Welcome <?php echo $login ?> </h2>
<form action="" method="POST">
    <p>First name: <b id="name"> <?php echo $first_name?></b><br>
    <input type="hidden" id="first_name" name="first_name">
    <input type="button" name="first_name" value="Edit" onclick="editElement(this, 'name');">
    </p>
    <p>Laste name: <b id="last"><?php echo $last_name ?></b><br>
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
    <p>Notify me by email about commenting on my post</p>
    <input type="radio" name="notify" value="1" checked> Activate
    <input type="radio" name="notify" value="0"> Deactivate
    <button>Save</button>
</form>

<script>
function    editElement(element, filed){
    var name = <?php echo $json;?>;
    var text = prompt("Please enter new "+filed, "");
    if (text != null){
        text = text.replace(/ /g, '');
        if (text.length > 2){
            document.getElementById(filed).textContent = text;
            document.getElementById(element.name).value = text;
            console.log(document.getElementById(element.name));
            console.log(document.getElementById(element.name).text);   
        }
    }
}
</script>
