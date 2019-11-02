
<div class="main_panel">
<h2> Gallery</h2>
<?php 
//if(isset($posts)) echo $posts;  else echo '<h3>Ther will be all users posts</h3>';
if(isset($data) && isset($data[0])){
    foreach($data as $post)
        echo '<p>'.$post['title'].' --  сreated at '.$post['published'].'</p>
            <img src="/camagru/'.$post['path_photo'].'"> <br>
            <p><u>Like:</u> <b>'.$post['like'].'</b></p><br>';
}
else
    echo '<h3>Ther will be all users posts</h3>';
?>
</div>