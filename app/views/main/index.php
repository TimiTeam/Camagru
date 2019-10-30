
    <p> Welcome </p>
    <p>name: <b><?php echo $first_name ?> </b></p>
    <p>email: <b><?php echo $email ?> </b></p>
    <?php if (!isset($_SESSION['user_in'])){
        echo '<h2>You want make you super Photo?</h2>
        <a href="http://localhost:8080/camagru/account/login">Sign in!</a>
        <p>Or if you dont have <b>account</b> <br> Just a click in:</p>
        <a href="http://localhost:8080/camagru/account/register">Create you own account</a>';
    }
    else
        echo '<h2>Welcome '.$_SESSION['user_login'].'</h2>
        <a href="http://localhost:8080/camagru/account/makePhoto"><b>Make more Photo</b>!</a>';
        ?>
</body>
</html> 