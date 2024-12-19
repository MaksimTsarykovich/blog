<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/category/category_edit.php");

updateCategory($_POST['id'], $_POST['name'], $mysqli);

redirectTo("/public/post/post_selected_category.php");