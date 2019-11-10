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

echo '<div class="user_photo">
            <div class="post_info">
                <div class="title_date">
                    <div class="left_text">
                        <a href="account?user_id='.$post['user_id'].'">
                            <p>'.$post['user_name'].'</p>
                        </a>
                    </div>
                    <div class="right_text">
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
                        </a>
                        <div class="right_text">
                        <p>';
                             $tag = "<img class=\"comment_like\" src=\"/camagru/app/res/";
                            if (searchCurrUserLike($likes)){
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
                <div class="comments">';
                	foreach ($comments as $comment){
                		echo '<div class="one_comment">
								<div class="left_text">
									<a href="account?user_id='.$comment['user_id'].'">
                            			<p>'.$comment['nickname'].'</p>
                        			</a>
                        		</div>
                        		<div class="comment_data">
                        			<p>'.$comment['comment'].'</p>	
								</div>
							</div>';
					}
                echo '
				<div class="leave_comment">
					<form action="#" method="get">
						<input type="hidden" name="post_id" value="'.$post['id'].'">
						<textarea rows="6" name="comment" autofocus></textarea >
						<br>
						<button>
							Leave a comment
						</button>
					</form>
				</div>
				</div>
            </div>
            <br>
         </div>';