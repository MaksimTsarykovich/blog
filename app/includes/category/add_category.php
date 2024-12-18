<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectToCategoryPage();


createCategory($_POST['name'], $mysqli);

redirectToCategoryPage();