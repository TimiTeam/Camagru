
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
    if (!isset($_SESSION['user_in'])){
        echo '<h3>Welcome is camagru</h3>
        <p>Here You can select an image in a list of superimposable images take a picture with his/her webcam and admire the result that should be mixing
        both pictures.
        <p>You ready to make you super Photo?</p>
        <a href="http://localhost:8080/camagru/account/login">Sign in!</a>
        <p>Or if you dont have <b>account</b> <br> Just a click in:</p>
        <a href="http://localhost:8080/camagru/account/register">Create you own account</a>';
    }
    else if ($user)
        echo '<h3>Hello '.$user['first_name'].' '.$user['last_name'].'</h3>
        <p>You can create a new photo with a many different mask and publish it\'s.<br>
        The users can see your photos but only a connected user can like and/or comment your posts.</p>
        <a href="http://localhost:8080/camagru/account/makePhoto"><b>Make Photo</b>!</a>
        <p>Your posts </p>';
        if (isset($posts)){
            echo '<div class="user_photo">';
            foreach($posts as $post){
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
                <p>'.$post['title'].'</p>
                <a href="http://localhost:8080/camagru/gallery/showPost?post_id='.$post['id'].'">
                <img class="img_user" src="/camagru/'.$post['path_photo'].'" > <br>
                <div class="title_date">
                        <div class="left_text">
                            <p>
                                <img class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> 
                        </a><b>'.$post['comments'].'</b>
                            </p>
                        </div>
                        <div class="right_text">
                        <div class="users_likes" id="usr_likes'.$post['id'].'">';
                            foreach ($likes[$post['id']] as $like){
                                echo '<a href="account?user_id='.$like['user_id'].'">'.$like['nickname'].'</a><br>';
                            }
                        echo '</div> <p>';
                            $tag = '<img class="comment_like" src="/camagru/app/res/';
                            if (searchCurrUserLike($likes[$post['id']])){
                                $tag .= 'like_like.png" onclick="disLikePost(this, '.$post['id'].');"';
                            }
                            else if(isset($_SESSION['user_id'])){
                                $tag .= 'like.png" onclick="likeThePost(this, '.$post['id'].');"';
                            }
                            else
                                $tag .='like.png"';
                            $tag .= '>';
		                    echo $tag.' <u>Like:</u> <b>'.$post['like'].'</b>
                            </p>
                        </div>
                    </div>
                    
                </div>
                        <p>
                        <button id="delete" value="'.$post['id'].'" onclick="deletePhoto(this);">Delete Post</button>
                        </p>
                <br>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <script>
        function deletePhoto(elem){
            console.log(elem);
        }
        function    showFullPost(postId){
            document.location.href = "gallery/showPost?post_id="+postId;
        }
    </script>