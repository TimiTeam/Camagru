
<div class="main_panel">
<?php

if (isset($_SESSION['user_in']))
    $us = true;
else
    $us = false;

if(isset($userInfo)){
    echo '<h3>'.$userInfo['nickname'].'</h3>
<p>'.$userInfo['first_name']."  ".$userInfo['last_name'].'</p>
<p>'.$userInfo['email'].'</p>';
}

if(isset($data) && isset($data[0])){
    echo '<div class="user_photo">';
    foreach($data as $post){
        echo '
            <div class="post_info">
                <div class="title_date">
                    <div class="left_text">
                        <a href="account?user_id='.$post['user_id'].'">
                            <p>'.$post['user_name'].'</p>
                        </a>
                    </div>
                    <div class="rigth_text">
                        <p>'.$post['published'].'</p>
                    </div>
                </div>
                <p>'.$post['title'].'</p>
                <img class="img_user" src="/camagru/'.$post['path_photo'].'" > <br>
                <div class="title_date">
                        <div class="left_text">
                            <p>
                                <img class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> <b>'.$post['comments'].'</b>
                            </p>
                        </div>
                        <div class="left_text">';
        $pth = "like.png";
        if ($us && !isset($_SESSION['like_'.$post['id']])){
            echo ' <p onclick="likeThePost(this, '.$post['id'].');">';
        }
        else if ($us && isset($_SESSION['like_'.$post['id']])){
            echo ' <p onclick="desLikePost(this, '.$post['id'].');">';
            $pth = "like_like.png";
        }
        else
            echo ' <p>';
        echo'<img class="comment_like" src="/camagru/app/res/'.$pth.'"> <u>Like:</u> <b>'.$post['like'].'</b>
                            </p>
                        </div>
                    </div>
            </div>
            <br>';
    }
    echo '</div>';
}
else
    echo '<h3>Ther will be all user posts</h3>';
?>
</div>
