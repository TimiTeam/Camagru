
    <h3>Enter your <u>login </u> and <u>password </u></h3>
    <p style="color:red;"><?php if (isset($message)) echo $message ?></p>
    <form action="" method="POST">
        <p>Login</p>
        <p><input type="text" name="login" placeholder="LOGIN"></p>
        <p>Password</p>
        <p><input type="password" name="pass" placeholder="*****"></p>
        <a href="http://localhost:8080/camagru/account/reset">Forgot password?</a>
        <p><button>Enter</button></p>
    </form>
</body>
</html>