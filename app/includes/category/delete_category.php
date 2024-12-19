<?php
require_once('../functions.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : redirectTo("/");

deleteCategory($id, $mysqli);

redirectTo("/public/category/category_list.php");