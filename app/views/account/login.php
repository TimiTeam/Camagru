
    <h3>Enter your <b>login </b> and <b>password </b><h3>
    <p style="color:red;"><?php if (isset($message)) echo $message ?></p>
    <form action="" method="POST">
        <p>Login</p>
        <p><input type="text" name="login" placeholder="LOGIN"></p>
        <p>Password</p>
        <p><input type="password" name="pass" placeholder="*****"></p>
        <p><button>Enter</button></p>
    </form>
</body>
</html>