<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectToEditCategoryPage();


updateCategory($_POST['id'], $_POST['name'], $mysqli);

redirectToCategoryPage();