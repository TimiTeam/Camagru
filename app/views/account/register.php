<div class="main_panel">
    <div class="welcome">
    <p>Welcome to registration</p>
    </div>
    <br>
    <?php if (isset($errors_message)) foreach ($errors_message as $message) echo '<p  style="color:red;">'.$message.'</p>'; ?>
    <form action="" method="POST">
        <table>
            <tr>
                <td class="name">
                    <p></p>
                </td>
                <td class="data">
                    <p id="error" style="color:red;"></p>
                </td>
            </tr>
            <tr>
                <td class="name">
                   <p> First name</p>
                </td>
                <td class="data">
                    <input type="text" name="first_name" required minlength="1" onchange="inputValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p> Last name</p>
                </td>
                <td class="data">
                    <input type="text" name="last_name" required minlength="1" onchange="inputValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p>Nickname</p>
                </td>
                <td class="data">
                    <input type="text" name="nickname" required minlength="4" onchange="loginValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p>E-mail</p>
                </td>
                <td class="data">
                    <input type="email" name="email" size="50" minlength="4" required onchange="emailValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p>Login</p>
                </td>
                <td class="data">
                    <input type="text" name="login" required minlength="4" onchange="loginValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p>Password</p>
                </td>
                <td class="data">
                    <input id="pass" type="password" required minlength="4" name="pass" onchange="inputValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p>Confirm password</p>
                </td>
                <td class="data">
                    <input id="confirm" type="password" required minlength="4" name="confirm" onchange="passwordValidation(this);">
                </td>
            </tr>
            <tr>
                <td class="name">
                </td>
                <td class="data">
                    <br>
                </td>
            </tr>
            <tr>
                <td class="name">
                    <p><br></p>
                </td>
                <td class="data">
                    <button id="registerBtn" class="btn btn-success">Check-in </button>
                </td>
            </tr>
        </table>
    </form>
</div>