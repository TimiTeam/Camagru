
    <h2>Welcom in registration</h2>
    <h3>Input your <u> first name, lase name, e-maill, login </u> and <u>password </u></h3>
    <?php if (isset($errors_message)) foreach ($errors_message as $message) echo '<p style="color:red;">'.$message.'</p>'; ?>
    <form action="" method="POST">
        <p>First name</p>
        <p><input type="text" name="first_name"></p>
        <p>Last name</p>
        <p><input type="text" name="last_name"></p>
        <p>E-maill</p>
        <input type="email" name="email" size="50" required>
        <p>Login</p>
        <p><input type="text" name="login"></p> 
        <p>Password</p>
        <p><input type="password" name="pass"></p>
        <p>Confirm password</p>
        <p><input type="password" name="confirm"></p>
        <p><button>Register</button></p>
    </form>
</body>
</html>