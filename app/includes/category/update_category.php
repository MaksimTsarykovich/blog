<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/category/category_edit.php");

updateCategory($_POST['id'], $_POST['name'], $mysqli);

redirectTo("/public/category/category_list.php");