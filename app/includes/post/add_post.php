<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/post/post_create.php");


createPost($_POST['name'], $_POST['text'], $mysqli) ? null : redirectTo("/public/post/post_create.php");

redirectTo("/");