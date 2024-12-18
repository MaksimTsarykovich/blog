<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectToEditPostPage();


updatePost($_POST['id'], $_POST['name'],$_POST['text'], $mysqli);

redirectToHomePage();