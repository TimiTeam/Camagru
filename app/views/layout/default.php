<?php
    if (isset($_SESSION['user_in'])){
        $dt = array ('Register' =>'<a href="http://localhost:8080/camagru/account/setting"><li>Account Settings</li>',
            'LogIn' => '<a href="http://localhost:8080/camagru/account/logout"><li>Sign out</li></a>');
    }
    else{
        $dt = array ('Register' =>'<a href="http://localhost:8080/camagru/account/register"><li>Registration</li>',
            'LogIn' => '<a href="http://localhost:8080/camagru/account/login"><li>Sign in</li></a>');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="/camagru/app/style/userStyle.css">
        <link rel="stylesheet" href="/camagru/app/style/mainStyle.css">
        <script src="/camagru/app/scripts/photoMaster.js"></script>
        <title><?php echo $title?></title>
    </head>
    <body>
    <header>
    <div class="hor_list">
        <ul class="hr">
            <a href="http://localhost:8080/camagru/"><li>Main Page </li></a>
            <a href="http://localhost:8080/camagru/gallery/show"><li>Gallery</li></a>
            <a href="http://localhost:8080/camagru/account/makePhoto"><li>Make Photo</li></a>
            <?php
                foreach($dt as $d)
                    echo $d;
            ?>
        </ul>
    </div>
    </header>
    
        <?php echo $content; 
        ?>
    <br>
    <footer>
    <div class="hor_list">
        <ul class="hr">
            <a href="http://localhost:8080/camagru/"><li>Main Page </li></a>
            <a href="http://localhost:8080/camagru/gallery/show"><li>Gallery</li></a>
            <a href="http://localhost:8080/camagru/account/makePhoto"><li>Make Photo</li></a>
            <?php
                foreach($dt as $d)
                    echo $d;
            ?>
        </ul>
    </footer>
    </body>
</html>