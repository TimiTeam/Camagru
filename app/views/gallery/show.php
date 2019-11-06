<style>
    
.user_photo{
    min-width: 400px;
    border: 1px solid salmon;
    border-radius: 2%;
    text-align: center;
}


.post_info{
    width: 60%;
    margin-left: 20%;
    border: 1px solid rebeccapurple;
}

.img_user{
    width: 90%;
    border: 2px solid black;
}   

.title_date{
    text-align: none;
    display: inline-flex;
}

.left_text{
    margin-left: 0%;
    border: 1px solid orchid;
}
.rigth_text{
    margin-right: 0%;
    border: 1px double yellowgreen;
}

.comment_like{
    width: 22px;
    height: 22px;;
}
</style>


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
    echo '<h3>Ther will be all users posts</h3>';
?>
</div>