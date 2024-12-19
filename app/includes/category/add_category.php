<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectTo("/public/category/category_list.php");

createCategory($_POST['name'], $mysqli);

redirectTo("/public/category/category_list.php");