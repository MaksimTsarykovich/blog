<?php
require_once('../config.php');
require_once('../functions.php');

isMethodPOST() ? null : redirectToCreatePage();

createTask($_POST['name'], $_POST['data'], $mysqli) ? null : redirectToCreatePage();

redirectToHomePage();
