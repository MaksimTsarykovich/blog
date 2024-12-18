<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectToCreatePostPage();


createPost($_POST['name'], $_POST['text'], $mysqli) ? null : redirectToCreatePostPage();

redirectToHomePage();