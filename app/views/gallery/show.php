
<div class="main_panel">
<h2> Gallery</h2>
<?php 
//if(isset($posts)) echo $posts;  else echo '<h3>Ther will be all users posts</h3>';
if(isset($data) && isset($data[0])){
    echo '<div class="user_photo">';
    foreach($data as $post){
        echo '<div class="post_info" onclick="showFullPost('.$post['id'].');">
                <div class="title_date">
                    <div class="left_text">
                        <p>'.$post['title'].'</p>
                    </div>
                    <div class="rigth_text">
                        <p>'.$post['published'].'</p>
                    </div>
                </div>
                <img class="img_user" src="/camagru/'.$post['path_photo'].'"> <br>
                <p><img class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> '.$post['comments'].' <img class="comment_like" src="/camagru/app/res/like.png"> <u>Like:</u> <b>'.$post['like'].'</b></p>
            </div>
            <br>';
    }
    echo '</div>';
}   
else
    echo '<h3>Ther will be all users posts</h3>';
?>
</div>