<?php 

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller{

    public function showAction(){
        $res = [];
        $likes = [];
        if (!isset($_GET['sort']))
			$_GET['sort'] = 'new';
        if (isset($_GET['nickname']) && strlen($_GET['nickname']) > 0){
            $nickname = htmlentities($_GET['nickname']);
			if (isset($_GET['sort']) && stristr($_GET['sort'], 'like') !== false)
            	$res = $this->model->getAllUserPostsByLikes($nickname);
			else
				$res = $this->model->getAllUserPosts($nickname);
        }
        else if (isset($_GET['sort']) && stristr($_GET['sort'], 'like') !== false)
            $res = $this->model->getAllPostsByLikes();
        else
			$res = $this->model->showAllPosts();
        if ($res) {
        	if (isset($_GET['sort']) && $_GET['sort'] == 'new' || (isset($_GET['sort'])  && $_GET['sort'] == 'like_more'))
				$res = array_reverse($res);
            $likes = $this->model->getAllLikes($res);
        }
        $this->view->render("Gallery", array('data' => $res, 'likes' => $likes));
    }

    public function likePostAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['pos_id']) && isset($_POST['like'])){
            if (isset($_SESSION['user_id'])) {
                $user = $this->model->getUserInfo($_SESSION['user_id']);
                $post_id = htmlentities($_POST['pos_id']);
                $status = htmlentities($_POST['status']);
                if ($user) {
                    $this->model->updatePost($post_id, array('like' => 1, 'data' => $_POST['like']));
                    if ($status == 1)
                        $this->model->addLike($post_id, $user);
                    else if ($status == 0)
                        $this->model->deleteLine($post_id, $user);
                    echo 'ok';
                }
                else
                	echo 'error';
            }
            else
				header("Location: /camagru/gallery/show");
        }
        echo
		header("Location: /camagru/gallery/show");

		exit;
    }

    public function showPostAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post_id'])){
			$post_id = htmlentities($_GET['post_id']);
			$post = $this->model->getCurrentPost($post_id);
			if ($post){
        		if (isset($_GET['comment'])){
        			$comment = htmlentities($_GET['comment']);
        			$this->model->updateCommentToPost($post, $comment);
					$url = explode('&', $_SERVER['REQUEST_URI']);
					header('Location: '.$url[0]);
					exit;
				}
            	$comments = [];
            	$likes = [];
            	if ($post) {
					$likes = $this->model->getPostLikes($post['id']);
					$comments = $this->model->getPostComments($post['id']);
				}

				$this->view->render("Post", array('post' => $post, 'comments' => $comments, 'likes' => $likes));
			}
			else
				header("Location: /camagru/gallery/show");
        }
        exit;
    }

    public function accountAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])){
            $user_id = htmlentities($_GET['user_id']);
            $user = $this->model->getUserInfo($user_id);
            if ($user != false) {
                $posts = $this->model->getAllUserPosts($user['nickname']);
				$posts = array_reverse($posts);
                $likes = $this->model->getAllLikes($posts);
                $user['post_count'] = count($posts);
				$user['like_count'] = 0;
				$user['comment_count'] = 0;
				foreach ($posts as $post){
					$user['like_count'] += $post['like'];
					$user['comment_count'] += $post['comments'];
				}
				$this->view->render($user['nickname'], array('userInfo' => $user, 'data' => $posts, 'likes' => $likes));
            }else
				header("Location: /camagru/gallery/show");
        }
		exit;
    }
}