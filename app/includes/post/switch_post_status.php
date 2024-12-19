<?php 
require_once('../functions.php');

switchTaskStatus($mysqli, $_GET['id']);

redirectTo("/public/post/post_show.php?id=".$_GET['id']);