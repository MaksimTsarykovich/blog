<?php
require_once('../functions.php');

deleteTask($_POST['id'], $mysqli);

redirectToHomePage();