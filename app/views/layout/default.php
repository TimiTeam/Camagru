    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
        div.cont{
            display: inline-flex;
            border: 2px dashed blue;
        }
        div.first{
            display: inline-block;
        }

        div.second{
            height: 600px;
            overflow-y:scroll;
        }
        video{
            border: 1px solid #ddd;
            border-radius: 2%;
            padding: 5px;
        }
        img.render {
            border: 1px solid #ddd;
            border-radius: 10%;
            padding: 5px;
            width: 160px;
            height: 120px;
        }

        img.render:hover {
            box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
        }
        </style>
        <title><?php echo $title?></title>
    </head>
    <body>
    <header>
    <ul class="hr">
        <a href="http://localhost:8080/camagru/"><li>Main Page </li></a>
        <a href="http://localhost:8080/camagru/gallery/show"><li>Gallery</li></a>
        <a href="http://localhost:8080/camagru/account/makePhoto"><li>Make Photo</li></a>
        <a href="http://localhost:8080/camagru/account/setting"><li>My Settings</li></a>
        <a href="http://localhost:8080/camagru/account/<?php if (isset($_SESSION['user_in'])) echo 'logout"><li>Sign out</li>'; else  echo 'login"><li>Sign in</li>'; ?></a>
    </ul>
    </header>
        <?php echo $content; 
        ?>