<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/post/post_edit.php");

updatePost($_POST['id'], $_POST['name'], $_POST['text'], $mysqli);

redirectTo("/");
