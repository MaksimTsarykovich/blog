<?php
session_start();

$mysqli = mysqli_connect("mysql", "user", "password", "app");
if (!$mysqli) {
    $_SESSION['error'] = "Ошибка бд: " . mysqli_connect_error();
}
