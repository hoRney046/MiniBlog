<?php
// Подключаем базу
$db = new SQLite3('blog.db');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $stmt = $db->prepare("DELETE FROM posts WHERE id = :id");
    $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
    $stmt->execute();
}

// Возвращаемся на главную страницу
header("Location: index.php");
exit;
