<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/category/category_edit.php");

updateCategory($_POST['postId'], $_POST['categoryId'], $mysqli);

redirectTo("/public/post/post_select_category.php?id=".$_POST['postId']);