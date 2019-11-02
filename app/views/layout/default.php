    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/camagru/app/style/makePhoto.css">
        <link rel="stylesheet" href="/camagru/app/style/mainStyle.css">
        <script src="/camagru/app/scripts/dropMask.js"></script>
        <title><?php echo $title?></title>
    </head>
    <body>
    <header>
    <div class="hor_list">
        <ul class="hr">
            <a href="http://localhost:8080/camagru/"><li>Main Page </li></a>
            <a href="http://localhost:8080/camagru/gallery/show"><li>Gallery</li></a>
            <a href="http://localhost:8080/camagru/account/makePhoto"><li>Make Photo</li></a>
            <a href="http://localhost:8080/camagru/account/setting"><li>My Settings</li></a>
            <a href="http://localhost:8080/camagru/account/<?php if (isset($_SESSION['user_in'])) echo 'logout"><li>Sign out</li>'; else  echo 'login"><li>Sign in</li>'; ?></a>
        </ul>
    </div>
    </header>
        <?php echo $content; 
        ?>