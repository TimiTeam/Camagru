<?php 

namespace app\controllers;

use app\core\Controller;

class GalleryController extends Controller{

    public function showAction(){
        $res = [];
        $likes = [];
        if (isset($_GET['nickname'])){
            $nickname = htmlentities($_GET['nickname']);
            $res = $this->model->getAllUserPosts($nickname);
        }
        else
            $res = $this->model->showAllPosts();
        if ($res) {
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
                echo 'error';
            exit;
        }
        echo 'error';
    }

    public function showPostAction(){
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post_id'])){
			$post_id = htmlentities($_GET['post_id']);
			$post = $this->model->getCurrentPost($post_id);
        	if (isset($_GET['comment'])){
        		$comment = htmlentities($_GET['comment']);
        		$this->model->updateCommentToPost($post, $comment);
				$post = $this->model->getCurrentPost($post_id);
			}
            $comments = [];
            $likes = [];
            if ($post) {
				$likes = $this->model->getPostLikes($post['id']);
				$comments = $this->model->getPostComments($post['id']);
			}
            $this->view->render("Post", array('post' => $post, 'comments' => $comments, 'likes' => $likes));
        }
        exit;
    }

    public function accountAction(){
        $likes = [];
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id'])){
            $user_id = htmlentities($_GET['user_id']);
            $user = $this->model->getUserInfo($user_id);
            if ($user != false) {
                $posts = $this->model->getAllUserPosts($user['nickname']);
                $likes = $this->model->getAllLikes($posts);
                $this->view->render($user['nickname'], array('userInfo' => $user, 'data' => $posts, 'likes' => $likes));
            }
        }
        exit;
    }
}