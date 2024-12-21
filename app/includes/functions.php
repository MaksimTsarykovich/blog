<?php

require_once('config.php');

function isMethodPOST(): bool
{
    if (!$_SERVER["REQUEST_METHOD"] === "POST") {
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

function getPostStatus($mysqli, $postId): bool
{
    $sql = "SELECT `status` FROM posts WHERE id = '$postId'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода статуса статьи: " . mysqli_error($mysqli);
        exit();
    }
    return !mysqli_fetch_row($result)[0] == 0;
}

function getPostName($mysqli, $postId): string
{
    $sql = "SELECT `name` FROM posts WHERE id = '$postId'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода имени статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["name"];
}

function getPostText($mysqli, $postId): string
{
    $sql = "SELECT `text` FROM posts WHERE id = '$postId'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода текста статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["text"];
}

function getPostCategory($mysqli, $postId): string
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
    WHERE posts.id = {$postId};";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода названия категории: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["category_name"];
}

function getPostImage($mysqli, $postId): string
{
    $sql = "SELECT `image` FROM posts WHERE id = '$postId'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода текста статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["image"];
}

function getPostViews($mysqli, $postId): string
{
    $sql = "SELECT `views` FROM posts WHERE id = '$postId'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка вывода текста статьи: " . mysqli_error($mysqli);
        exit();
    }
    return mysqli_fetch_assoc($result)["views"];
}

function createPost($name, $text, $mysqli): bool
{
    $sql = "INSERT INTO `posts` (`id`, `name`, `text`, `category_id`, `views`, `status`, `image`) VALUES (NULL, '{$name}','{$text}', 5,  0, 1, 'default-image.jpg')";
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
    if ($id == 5) {
        $_SESSION['error'] = "Нельзя удалить эту категорию:";
        return false;
    }
    $sql = "SELECT `post_count` FROM `categories` WHERE `id` = '{$id}'";
    if (!$result = mysqli_query($mysqli, $sql)) {
        $_SESSION['error'] = "Ошибка переноса числа кол-ва статей: " . mysqli_error($mysqli);
        exit();
    }
    $postCountOld = mysqli_fetch_assoc($result)["post_count"];

    $sql = "UPDATE `categories` SET `post_count` = `post_count` + '{$postCountOld}' WHERE id = 5;";
    executeQueryWithFeedback("Ошибка выставкления статуса 'Без категории' для статьи ", "Статус успешно обновлен ", $sql, $mysqli) ? null : exit();

    $sql = "UPDATE `posts` SET `category_id` = 5 WHERE `id` = '{$id}'";
    executeQueryWithFeedback("Ошибка выставкления статуса 'Без категории' для статьи ", "Статус успешно обновлен ", $sql, $mysqli) ? null : exit();

    $sql = "DELETE FROM `categories` WHERE `id` = '{$id}'";
    return executeQueryWithFeedback("Ошибка удаления категории ", "Категория успешно удалена ", $sql, $mysqli);
}

function updateCategory($postId, $categoryId, $mysqli): bool
{
    if ($categoryId == 5) {
        $_SESSION['error'] = "Нельзя обновить эту категорию:";
        return false;
    }
    $sql = "UPDATE `posts` SET `category_id` = '{$categoryId}' WHERE `id` = '{$postId}'";
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

function switchPostStatus($mysqli, $postId): bool
{
    if (getPostStatus($mysqli, $postId)) {
        $sql = "UPDATE `posts` SET `status` = '0' WHERE `posts`.`id` = '$postId'";
    } else {
        $sql = "UPDATE `posts` SET `status` = '1' WHERE `posts`.`id` = '$postId'";
    }
    return executeQueryWithFeedback("Ошибка обновления статуса статьи ", "Статус статьи успешно обновлен ", $sql, $mysqli);
}
function isImageValid($fileSize, $fileType): bool
{
    if (empty($fileSize)) {
        $_SESSION['error'] = "Выберете изображения";
        return false;
    }
    if (!($fileType == "image/jpeg" || $fileType == "image/png")) {
        $_SESSION['error'] = "Можно загрузить изображение только в формате .jpg и .png";
        return false;
    }
    return true;
}

function saveImage($fileName, $fileTmpName, $mysqli): bool
{
    $upLoadDir = dirname(__DIR__, 2) . '/public/public/images/';
    $upLoadFile = $upLoadDir . basename($fileName);
    return move_uploaded_file($fileTmpName, $upLoadFile);
}

function updatePostImage($postId, $imageName, $mysqli): bool
{
    $sql = "UPDATE `posts` SET `image` = '{$imageName}' WHERE `id` = '{$postId}'";
    return executeQueryWithFeedback("Ошибка обновления изображение ", "Изображение успешно обновлено ", $sql, $mysqli);
}

function incrementViewCount($postId, $mysqli):void 
{
    $sql = "UPDATE `posts` SET `views` = `views` + 1 WHERE id = '{$postId}'";
    mysqli_query($mysqli, $sql) ? null : $_SESSION['error'] = "Ошибка обновления счетчика просмотров" . mysqli_error($mysqli);
}

function redirectTo(string $url): void
{
    header("Location: " . $url);
    exit;
}
