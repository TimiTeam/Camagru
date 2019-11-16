<div class="main_panel">
	<?php
	function searchCurrUserLike($likesArray)
	{
		if (isset($_SESSION['user_id'])) {
			$currUser = $_SESSION['user_id'];
			foreach ($likesArray as $like) {
				if ($like['user_id'] == $currUser)
					return true;
			}
		}
		return false;
	}

	if (!isset($_SESSION['user_in'])) {
		echo '<div class="welcome">
            <p>Welcome to Camagru</p>
        </div>
        <p>Here You can select an image in a list of superimposable images take a picture with your webcam or load from device
        and admire the result that will be mixing both pictures.
        <p>You ready to make you super Photo?</p>
        <a href="http://localhost:8080/camagru/account/login" class="btn btn-success">Sign in!</a>
        <p>Or if you dont have <b>account</b> <br> Just a click in:</p>
        <a href="http://localhost:8080/camagru/account/register" class="btn btn-success">Create account</a>';
	} else if ($user)
		echo '<div class="welcome">
                <p> Hello <b class="user_name">' . $user['first_name'] . ' ' . $user['last_name'] . '</b></p>
             </div>
              <div class="account_settings">
        <br>
            <a href="/camagru/account/settings">
                <button class="btn btn-secondary">Account Settings</button>
            </a>
            </p>
            
        </div>
        <br>
             <table class="table table-striped table-dark">
             <thead>
                 <tr>
                     <th scope="col"></th>
                     <th scope="col">Count</th>
                 </tr>
             </thead>
             <tbody>
                 <tr>
                     <th scope="row">Your Posts</th>
                     <td>' . $user_posts . '</td>
                 </tr>
                 <tr>
                     <th scope="row">Likes to your posts</th>
                     <td>' . $likesToUser . '</td>
                 </tr>
                 <tr>
                     <th scope="row">Comments to your posts</th>
                     <td>' . $commentsToUser . '</td>
                 </tr>
             </tbody>
             </table>
            
              <button type="button" class="btn btn-secondary" onclick="showAllLikedPosts(this);">Posts that you like: ' . $userLikesPostsCount . '</button><br>
              
              <div id="preview_posts" class="block_preview_posts"><br>';

	if (isset($userLikesPosts)) {
		foreach ($userLikesPosts as $post) {
			echo '<div  class="preview_posts">
                <div class="preview_img"><a href="/camagru/gallery/showPost?post_id=' . $post[0]['id'] . '">
                    <img class="prev_img" alt="pots" src="/camagru/' . $post[0]['path_photo'] . '">
                </div>
                </a>
                <div class="preview_info" >
                    <a href="/camagru/gallery/account?user_id=' . $post[0]['user_id'] . '">
                    ' . $post[0]['user_name'] . '
                    </a>
                    <p>
                    ' . $post[0]['title'] . '
                    </p>
                </div>
              </div>';
		}
	}
	echo '<br></div><br>
        <p>You can create a new photo with a many different mask and publish it\'s.<br>
        The users can see your photos but only a connected user can like and/or comment your posts.</p>
        <a href="http://localhost:8080/camagru/account/makePhoto" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Make More Photo</a>
        
        <p style="text-align: center">Your posts </p> <br>';
	if (isset($posts)) {
		echo '<div class="user_photo">';
		foreach ($posts as $post) {
			echo '
                <div class="post_info">
                     <div class="title_date">
                        <div class="left_text">
                            <a href="account?user_id=' . $post['user_id'] . '">
                                <p></p>
                            </a>
                        </div>
                        <div class="center_text">
                            <p>' . $post['title'] . '</p>
                        </div>
                        <div class="right_text">
                            <p>' . $post['published'] . '</p>
                        </div>
                        </div>
                    <a href="/camagru/gallery/showPost?post_id=' . $post['id'] . '">
                    <img alt="image" class="img_user" src="/camagru/' . $post['path_photo'] . '" > <br>
                    <div class="title_date">
                        <div class="comment">
                            <p>
                                <img alt="comment" class="comment_like" src="/camagru/app/res/comment.png"><u>Comments:</u> 
                        </a><b>' . $post['comments'] . '</b>
                            </p>
                        </div>
                        <div class="like">
                        <div class="users_likes" id="usr_likes' . $post['id'] . '">';
			foreach ($likes[$post['id']] as $like) {
				echo '<a href="/camagru/gallery/account?user_id=' . $like['user_id'] . '">' . $like['nickname'] . '</a><br>';
			}
			echo '</div> <p>';
			$tag = '<img class="comment_like" src="/camagru/app/res/';
			if (searchCurrUserLike($likes[$post['id']])) {
				$tag .= 'like_like.png" onclick="disLikePost(this, ' . $post['id'] . ');"';
			} else if (isset($_SESSION['user_id'])) {
				$tag .= 'like.png" onclick="likeThePost(this, ' . $post['id'] . ');"';
			} else
				$tag .= 'like.png"';
			$tag .= '>';
			echo $tag . ' <u class="likes" id="likes_' . $post['id'] . '">Like:</u> <b>' . $post['like'] . '</b>
                            </p>
                        </div>
                    </div>
                    
                </div>
                    <p>
                        <button id="delete" value="' . $post['id'] . '" class="btn btn-outline-danger" onclick="deletePosts(this);">Delete Post</button>
                    </p>
                    <div id="modal' . $post['id'] . '" class="confirm_delete">
                        <p>Do you really want to delete this posts?</p>
                        <br>
                        <p>
                            <div class="title_date">
                                <div class="confirm">
                                    <form action="#" method="get">
                                        <input type="hidden" name="postId" value="' . $post['id'] . '">
                                        <button class="btn btn-warning" name="confirm" value="yes">Yes, Delete</button>
                                    </form>
                                </div>
                                <div class="cancel">
                                    <input class="btn btn-success" type="button" name="confirm" value="No, leave" onclick="closeModal(' . $post['id'] . ')">
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

    function showAllLikedPosts(elem) {
        let div = document.getElementById("preview_posts");
        if (div) {
            div.style.display = "block";
            div.style.height = "auto";
            let val = elem.textContent;
            elem.textContent = "Hide";
            elem.onclick = function () {
                div.style.display = "none";
                div.style.height = "20px";
                this.textContent = val;
                this.setAttribute("onclick", "showAllLikedPosts(this);");
            }
        }
    }

    function closeModal(postId) {
        let modal = document.getElementById("modal" + postId);
        if (modal)
            modal.style.display = "none";
    }

    function deletePosts(elem) {
        let modal = document.getElementById("modal" + elem.value);
        if (modal) {
            modal.style.display = "block";
        }
    }
</script>