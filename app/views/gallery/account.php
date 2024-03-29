
<div class="main_panel">
<?php

if (!isset($_SESSION['user_in']))
	header("Location: http://localhost:8080/camagru/");

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
    echo '<div class="welcome">
                <p class="user_name">'.$userInfo['first_name'].' '.$userInfo['last_name'] . '</p>
                <p>Send email <a href = "mailto:'.$userInfo['email'].'">'.$userInfo['email'].'</a>
             </div>
             <div class="table_info">
             
             <p>User info</p>
             <table class="table table-striped table-dark">
             <thead>
                 <tr>
                     <th scope="col">#</th>
                     <th scope="col">Count</th>
                 </tr>
             </thead>
             <tbody>
                 <tr>
                     <th scope="row">Posts</th>
                     <td>' . $userInfo['post_count'] . '</td>
                 </tr>
                 <tr>
                     <th scope="row">Likes</th>
                     <td>' . $userInfo['like_count']  . '</td>
                 </tr>
                 <tr>
                     <th scope="row">Comments</th>
                     <td>' . $userInfo['comment_count']  . '</td>
                 </tr>
             </tbody>
             </table>
             <br>
             </div>';
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
                    <div class="center_text">
                        <p>'.$post['title'].'</p>
                    </div>
                    <div class="right_text">
                        <p>'.$post['published'].'</p>
                    </div>
                </div>
                <a href="http://localhost:8080/camagru/gallery/showPost?post_id='.$post['id'].'">
                <img class="img_user" src="/camagru/'.$post['path_photo'].'" > <br>
                <div class="title_date">
                        <div class="comment">
                            <p>
                                <img class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> 
                            </a>
                                <b>'.$post['comments'].'</b>
                            </p>
                        </div>
                        <div class="like">
                        <div class="users_likes" id="usr_likes'.$post['id'].'">';
                            foreach ($likes[$post['id']] as $like){
                                echo '<a href="account?user_id='.$like['user_id'].'">'.$like['nickname'].'</a><br>';
                            }
                        echo '</p></div>
                        <p>';
                             $tag = '<img class="comment_like" src="/camagru/app/res/';
                            if (searchCurrUserLike($likes[$post['id']])){
                                $tag .= 'like_like.png" onclick="disLikePost(this, '.$post['id'].');"';
                            }
                            else if(isset($_SESSION['user_id'])){
                                $tag .= 'like.png" onclick="likeThePost(this, '.$post['id'].');"';
                            }
                            $tag.='like.png" >';
                            echo $tag.' <u class="likes" id="likes_'.$post['id'].'">Like:</u> <b>'.$post['like'].'</b>
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
