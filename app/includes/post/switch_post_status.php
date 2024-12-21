<?php 
require_once('../functions.php');

switchPostStatus($mysqli, $_GET['id']);

redirectTo("/public/post/post_show.php?id=".$_GET['id']);