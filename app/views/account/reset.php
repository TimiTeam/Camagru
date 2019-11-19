
<div class="main_panel">
<form method="POST" action>
    <table>
        <tr>
            <td>
            </td>
            <td>
                <p id="error" style="color:red;"> <?php if(isset($error)) echo $error; else echo '';?> </p>
            </td>
        </tr>
    <?php if(isset($getData) && $getData) echo '
        <tr>
            <td class="name">
                <p>Login</p>
            </td>
            <td class="data">
                <input type="text" name="login" required>
            </td>
        </tr>
        <tr>
            <td class="name">
                <p>Email</p>
            </td>
            <td class="data">
                 <input type="email" name="email" required>
            </td>
        </tr>
            '; else if(isset($newPassword) && $newPassword) echo '
        <tr>
            <td class="name">
                <p> New password </p>
            </td>
            <td class="data">
                <input id="pass" type="password" name="password" required>
            </td>
        </tr>
        <tr>
            <td class="name">
                <p>Confirm</p>
            </td>
            <td class="data">
                 <input type="password" name="confirm" required onchange="passwordValidation(this);">
            </td>
        </tr>';?>
        <tr>
            <td class="name">
                <p></p>
            </td>
            <td class="data">
                <br>
            </td>
        </tr>
        <tr>
            <td class="name">
                <p></p>
            </td>
            <td class="data">
                <button class="simple_button">Reset</button>
            </td>
        </tr>
    </table>
</form>
</div>