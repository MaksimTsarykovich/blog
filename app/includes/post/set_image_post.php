<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/post/post_image.php?id=".$_POST['postId']);
isImageValid($_FILES["file"]['size'], $_FILES["file"]['type']) ? null : redirectTo("/public/post/post_image.php?id=".$_POST['postId']);

updatePostImage($_POST['postId'], $_FILES["file"]['name'], $mysqli) ? null : redirectTo("/public/post/post_image.php?id=".$_POST['postId']);

saveImage($_FILES["file"]['name'], $_FILES["file"]['tmp_name'], $mysqli);

redirectTo("/public/post/post_image.php?id=".$_POST['postId']);
