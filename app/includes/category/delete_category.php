<?php
require_once('../functions.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : redirectToHomePage();

deleteCategory($id, $mysqli);

redirectToCategoryPage();