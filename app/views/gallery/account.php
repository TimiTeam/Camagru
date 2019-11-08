
<div class="main_panel">
<?php

function searchCurrUserLike($likesArray){
    if (isset($_SESSION['user_id'])) {
        $currUser = $_SESSION['user_id'];
        foreach ($likesArray as $like) {
            if ($like['user_id'] == $currUser)
                return true;
        }
    }
    return false;
}

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
                        <div class="left_text">
                        <p>';
                            $tag = "<img class=\"comment_like\" src=\"/camagru/app/res/";
                            if (searchCurrUserLike($likes[$post['id']])){
                                $tag .= 'like_like.png" onclick="disLikePost(this, '.$post['id'].');"';
                            }
                            else if(isset($_SESSION['user_id'])){
                                $tag .= 'like.png" onclick="likeThePost(this, '.$post['id'].');"';
                            }
                            $tag.='like.png" >';
                            echo $tag.' <u>Like:</u> <b>'.$post['like'].'</b>
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