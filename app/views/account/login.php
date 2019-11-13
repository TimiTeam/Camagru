    <div class="main_panel">
        <div class="login_form">
            <form action="" method="POST">
                <table>
                    <tr>
                        <td class="name">
                            <p></p>
                        </td>
                        <td class="data">
                            <p style="color:red;"><?php if (isset($message)) echo $message; else echo '' ?></p>
                        </td>
                    </tr>
                    <tr class="row">
                        <td class="name">
                            <p>Login</p>
                        </td>
                        <td class="data">
                            <p><input type="text" name="login" placeholder="LOGIN"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="name">
                            <p>Password</p>
                        </td>
                        <td class="data">
                            <p><input type="password" name="pass" placeholder="*****"></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="name">
                            <p></p>
                        </td>
                        <td class="data">
                            <p>
                                <a href="/camagru/account/reset">Forgot password?</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="name">
                            <p></p>
                        </td>
                        <td class="data">
                            <a href="/camagru/account/register">Don't have account?</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="name">
                            <p></p>
                        </td>
                        <td class="data">
                            <p><br></p>
                        </td>
                    </tr>
                    <tr>
                        <td class="name">
                            <p></p>
                        </td>
                        <td class="data">
                            <p>
                                <button class="simple_button">Sign in </button>
                            </p>
                        </td>
                    </tr>

                </table>
            </form>
        </div>
    </div>
</body>
</html>