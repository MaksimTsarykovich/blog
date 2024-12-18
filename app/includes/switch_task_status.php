<?php 
require_once('../functions.php');

switchTaskStatus($mysqli, $_GET['id']);

redirectToHomePage();