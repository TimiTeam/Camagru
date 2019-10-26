    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php echo $title?></title>
    </head>
    <body>
    <header>
    <ul class="hr">
        <a href="http://localhost:8080/camagru/"><li>Main Page </li></a>
        <a href="http://localhost:8080/camagru/gallery/show"><li>Gallery</li></a>
        <a href="http://localhost:8080/camagru/account/setting"><li>MyAccount</li></a>
        <a href="http://localhost:8080/camagru/account/<?php if (isset($_SESSION['user_in'])) echo 'logout"><li>Logout</li>'; else  echo 'login"><li>Login</li>'; ?></a>
    </ul>
    </header>
        <?php echo $content; 
        ?>