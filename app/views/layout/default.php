<?php
    if (isset($_SESSION['user_in'])){
        $dt = array ('Register' =>'<a href="/camagru/account/makePhoto" class="btn btn-outline-primary menu_elem"><li>Make Photo</li>',
            'LogIn' => '<a href="/camagru/account/logout" class="btn btn-outline-primary menu_elem"><li>Sign out</li></a>');
    }
    else{
        $dt = array ('Register' =>'<a href="/camagru/account/register" class="btn btn-outline-primary menu_elem"><li>Registration</li>',
            'LogIn' => '<a href="/camagru/account/login" class="btn btn-outline-primary menu_elem"><li>Sign in</li></a>');
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/camagru/app/style/camagru.css">
        <link rel="stylesheet" href="/camagru/app/style/photo.css">
        <link rel="stylesheet" href="/camagru/app/style/show.css">

        <script  type="text/javascript" src="/camagru/app/scripts/registerJs.js"></script>
        <script  type="text/javascript" src="/camagru/app/scripts/posts.js"></script>
        <title><?php if (isset($title)) echo $title?></title>
    </head>
    <body>
    <header>
    <div class="hor_list">
        <div class="logo_div">
            <a href="/camagru/">
                <img class="logo" src="/camagru/app/res/bigLogo.png">
            </a>
        </div>
        <ul class="hr">
            <a href="/camagru/" class="btn btn-outline-primary menu_elem"><li>Main Page </li>
            </a>
            <a href="/camagru/gallery/show" class="btn btn-outline-primary menu_elem"><li>Gallery</li></a>
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
            <a href="/camagru/" class="btn btn-outline-primary menu_elem"><li>Main Page </li>
            </a>
            <a href="/camagru/gallery/show" class="btn btn-outline-primary menu_elem"><li>Gallery</li></a>
            <?php
                foreach($dt as $d)
                    echo $d;
            ?>
        </ul>
    </footer>
    </body>
</html>