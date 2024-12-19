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

function getAllPosts($mysqli): array
{
    $sql = "SELECT
        posts.id AS id,
        posts.name AS name,
        posts.text AS text,
        posts.views AS views,
        posts.status AS status,
        posts.image AS image,
        categories.name AS category_name
FROM
        posts
        JOIN categories ON posts.category_id = categories.id;";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода статей: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getAllCategories($mysqli): array
{
    $sql = "SELECT * FROM categories";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода категорий: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPostStatus($mysqli, $post_id): bool
{
    $sql = "SELECT `status` FROM posts WHERE id = '$post_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода статуса статьи: " . mysqli_error($mysqli);
        exit();
    }
    return !mysqli_fetch_row($result)[0] == 0;
}

function getPostName($mysqli, $post_id): string
{
    $sql = "SELECT `name` FROM posts WHERE id = '$post_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода имени статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["name"];
}

function getPostText($mysqli, $post_id): string
{
    $sql = "SELECT `text` FROM posts WHERE id = '$post_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода текста статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["text"];
}

function getPostCategory($mysqli, $post_id): string
{
    $sql = "SELECT
        posts.id AS id,
        posts.name AS name,
        posts.text AS text,
        posts.views AS views,
        posts.status AS status,
        posts.image AS image,
        categories.name AS category_name
    FROM
        posts
    JOIN categories ON posts.category_id = categories.id
    WHERE posts.id = {$post_id};";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода названия категории: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["category_name"];
}

function getPostImage($mysqli, $post_id): string
{
    $sql = "SELECT `image` FROM posts WHERE id = '$post_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода текста статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["image"];
}

function getPostViews($mysqli, $post_id): string
{
    $sql = "SELECT `views` FROM posts WHERE id = '$post_id'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода текста статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["views"];
}

function createPost($name, $text, $mysqli): bool
{
    $sql = "INSERT INTO `posts` (`id`, `name`, `text`, `category_id`, `views`, `status`, `image`) VALUES (NULL, '{$name}','{$text}', 5,  0, 1, NULL)";
    return executeQueryWithFeedback("Ошибка создания статьи ", "Статьи успешно создана ", $sql, $mysqli);
}

function createCategory($name, $mysqli): bool
{
    $sql = "INSERT INTO `categories` (`id`, `name`) VALUES (NULL, '{$name}')";
    return executeQueryWithFeedback("Ошибка создания категории ", "Категория успешно создана ", $sql, $mysqli);
}

function deletePost($id, $mysqli): bool
{
    $sql = "DELETE FROM `posts` WHERE `id` = '$id'";
    return executeQueryWithFeedback("Ошибка удаления статьи ", "Статья успешно удалена ", $sql, $mysqli);
}

function deleteCategory($id, $mysqli): bool
{
    $sql = "DELETE FROM `categories` WHERE `id` = '$id'";
    return executeQueryWithFeedback("Ошибка удаления категории ", "Категория успешно удалена ", $sql, $mysqli);
}

function updateCategory($id, $name, $mysqli): bool
{
    $sql = "UPDATE `categories` SET `name` = '{$name}' WHERE `categories`.`id` = '{$id}'";
    return executeQueryWithFeedback("Ошибка обновления категории ", "Категория успешно обновлена ", $sql, $mysqli);
}

function updatePost($id, $name, $text, $mysqli): bool
{
    $sql = "UPDATE `posts` SET `name` = '{$name}', `text` = '{$text}' WHERE `posts`.`id` = '{$id}'";
    return executeQueryWithFeedback("Ошибка обновления статьи ", "Статья успешно обновлена ", $sql, $mysqli);
}

function executeQueryWithFeedback(string $descriptionError, string $descriptionSuccess, $sql, $mysqli): bool
{
    if (!mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = $descriptionError . mysqli_error($mysqli);
        return false;
    }
    $_SESSION['success'] = $descriptionSuccess;
    return true;
}

function switchTaskStatus($mysqli, $post_id): bool
{
    if (getPostStatus($mysqli, $post_id)) {
        $sql = "UPDATE `posts` SET `status` = '0' WHERE `posts`.`id` = '$post_id'";
    } else {
        $sql = "UPDATE `posts` SET `status` = '1' WHERE `posts`.`id` = '$post_id'";
    }
    return executeQueryWithFeedback("Ошибка обновления статуса статьи ", "Статус статьи успешно обновлен ", $sql, $mysqli);
}

function redirectTo(string $url): void
{
    header("Location: " . $url);
    exit;
}
