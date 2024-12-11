<?php
require_once('../functions.php');

isMethodPOST() ? null : redirectToEditPage();

editTask($_POST['name'], $_POST['date'], $_POST['id'], $mysqli) ? redirectToHomePage() : redirectToEditPage();


