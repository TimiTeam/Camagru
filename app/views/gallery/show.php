
<div class="main_panel">
<h2> Gallery</h2>
<?php 

if (isset($_SESSION['user_in']))
    $us = true;
else
    $us = false;

if(isset($data) && isset($data[0])){
    echo '<div class="user_photo">';
    foreach($data as $post){
        echo '
            <div class="post_info">
                <div class="title_date">
                    <div class="left_text">
                        <p>'.$post['title'].'</p>
                    </div>
                    <div class="rigth_text">
                        <p>'.$post['published'].'</p>
                    </div>
                </div>
                <img class="img_user" src="/camagru/'.$post['path_photo'].'"> <br>
                <div class="title_date">
                        <div class="left_text">
                            <p>
                                <img class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> <b>'.$post['comments'].'</b>
                            </p>
                        </div>
                        <div class="left_text">'; 
                            if ($us)
                                echo ' <p onclick="likeThePost(this, '.$post['id'].');">';
                            else
                                echo ' <p>';
                                echo'<img class="comment_like" src="/camagru/app/res/like.png"> <u>Like:</u> <b>'.$post['like'].'</b>
                            </p>
                        </div>
                    </div>
            </div>
            <br>';
    }
    echo '</div>';
}   
else
    echo '<h3>Ther will be all users posts</h3>';
?>
</div>