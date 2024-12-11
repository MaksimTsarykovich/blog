<?php

require_once('config.php');

function isMethodPOST(): bool
{
    if (!$_SERVER["REQUEST_METHOD"] == "POST") {
        $_SESSION['error'] = "Неверный метод запроса";
        return false;
    }
    return true;
}

function getAllTasks($mysqli): array
{
    $sql = "SELECT * FROM tasks";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода задач: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getTaskStatus($mysqli, $task_id): bool
{
    $sql = "SELECT `status` FROM tasks WHERE id = '$task_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода задач: " . mysqli_error($mysqli);
        exit();
    }
    return !mysqli_fetch_row($result)[0] == 0;
}

function createTask($name, $date, $mysqli): bool
{
    $sql = "INSERT INTO `tasks` (`id`, `name`, `status`, `date`) VALUES (NULL, '{$name}', '0' , '{$date}')";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка записи задачи: " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

function deleteTask($id, $mysqli): bool
{
    $sql = "DELETE FROM `tasks` WHERE `id` = '$id'";
    if (!mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка удаления задачи " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

function editTask($name, $date, $id, $mysqli): bool
{
    $sql = "UPDATE `tasks` SET `name` = '{$name}', `date` = '{$date}' WHERE `tasks`.`id` = '{$id}'";
    if (!mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка обновления задачи " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

function switchTaskStatus($mysqli, $task_id): bool
{
    if (getTaskStatus($mysqli, $task_id)) {
        $sql = "UPDATE `tasks` SET `status` = '0' WHERE `tasks`.`id` = '$task_id'";
    } else {
        $sql = "UPDATE `tasks` SET `status` = '1' WHERE `tasks`.`id` = '$task_id'";
    }
    if (!mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка обновления задачи " . mysqli_error($mysqli);
        return false;
    }
    return true;
}

function redirectToHomePage(): void
{
    header("Location: /");
    exit();
}

function redirectToEditPage(): void
{
    header("Location: /public/edit.php");
    exit();
}

function redirectToCreatePage(): void
{
    header("Location: /public/create.php");
    exit();
}
