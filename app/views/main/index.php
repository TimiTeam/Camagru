
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
        echo '<div class="welcome">
            <p>Welcome is Camagru</p>
        </div>
        <p>Here You can select an image in a list of superimposable images take a picture with your webcam or load from device
        and admire the result that will be mixing both pictures.
        <p>You ready to make you super Photo?</p>
        <a href="http://localhost:8080/camagru/account/login">Sign in!</a>
        <p>Or if you dont have <b>account</b> <br> Just a click in:</p>
        <a href="http://localhost:8080/camagru/account/register">Create you own account</a>';
    }
    else if ($user)
        echo '<div class="welcome">
                <p> Hello <b class="user_name">'.$user['first_name'].' '.$user['last_name'].'</b></p>
             </div>
             <table>
                 <tr>
                     <td>
                         <p>At this time you have </p>
                     </td>
                 </tr>
                 <tr>
                     <td>
                         <p>Posts</p>
                 </td>
                     <td>
                         <p>15</p>
                     </td>
                 </tr>        
                 <tr>
                     <td>
                         <p>Comments</p>
                 </td>
                     <td>
                         <p>32</p>
                     </td>
                 </tr>
                 <tr>
                     <td>
                         <p>Likes</p>
                 </td>
                     <td>
                         <p>357</p>
                     </td>
                 </tr>
             </table>
        <p>You can create a new photo with a many different mask and publish it\'s.<br>
        The users can see your photos but only a connected user can like and/or comment your posts.</p>
        <a href="http://localhost:8080/camagru/account/makePhoto"><b>Make Photo</b>!</a>
        <div class="account_settings">
        <br>    
            <a href="/camagru/account/settings">
                <button class="simple_button">Account Settings</button>
            </a>
        </div>
        <p style="text-align: center">Your posts </p> <br>';
        if (isset($posts)){
            echo '<div class="user_photo">';
            foreach($posts as $post){
                echo '
                <div class="post_info">
                     <div class="title_date">
                        <div class="left_text">
                            <a href="account?user_id='.$post['user_id'].'">
                                <p></p>
                            </a>
                        </div>
                        <div class="center_text">
                            <p>'.$post['title'].'</p>
                        </div>
                        <div class="right_text">
                            <p>'.$post['published'].'</p>
                        </div>
                        </div>
                    <a href="/camagru/gallery/showPost?post_id='.$post['id'].'">
                    <img alt="image" class="img_user" src="/camagru/'.$post['path_photo'].'" > <br>
                    <div class="title_date">
                        <div class="comment">
                            <p>
                                <img alt="comment" class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> 
                        </a><b>'.$post['comments'].'</b>
                            </p>
                        </div>
                        <div class="like">
                        <div class="users_likes" id="usr_likes'.$post['id'].'">';
                            foreach ($likes[$post['id']] as $like){
                                echo '<a href="/camagru/gallery/account?user_id='.$like['user_id'].'">'.$like['nickname'].'</a><br>';
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
		                    echo $tag.' <u class="likes" id="likes_'.$post['id'].'">Like:</u> <b>'.$post['like'].'</b>
                            </p>
                        </div>
                    </div>
                    
                </div>
                    <p>
                        <button id="delete" value="'.$post['id'].'" onclick="deletePosts(this);">Delete Post</button>
                    </p>
                    <div id="modal'.$post['id'].'" class="confirm_delete">
                        <p>Do you really want to delete this posts?</p>
                        <br>
                        <p>
                            <div class="title_date">
                                <div class="confirm">
                                    <form action="#" method="get">
                                        <input type="hidden" name="postId" value="'.$post['id'].'">
                                        <button name="confirm" value="yes">Yes, Delete</button>
                                    </form>
                                </div>
                                <div class="cancel">
                                    <input type="button" name="confirm" value="No, leave" onclick="closeModal('.$post['id'].')">
                                </div>
                            </div>
                        </p>
                    </div>
                <br>';
            }
            echo '</div>';
        }
        ?>
    </div>
    <script>
        function closeModal(postId) {
            let modal = document.getElementById("modal"+postId);
            if (modal)
                modal.style.display = "none";
        }
        function deletePosts(elem) {
            let modal = document.getElementById("modal"+elem.value);
            if (modal){/*
                modal.width = "500px";
                modal.height = "90px";

                modal.style.width = "500px";
                modal.style.height = "100px";
                modal.style.left = (document.documentElement.clientWidth / 2 + window.pageXOffset) + "px";
                modal.style.top = (document.documentElement.clientHeight / 2  + window.pageYOffset) + "px";*/
                modal.style.display = "block";
            }
        }
    </script>