<?php
require_once('../functions.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : redirectTo("/");

deletePost($id, $mysqli);

redirectTo("/");
