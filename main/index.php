<?php

$db = new SQLite3('blog.db');


$db->exec("CREATE TABLE IF NOT EXISTS posts (id INTEGER PRIMARY KEY, title TEXT, content TEXT)");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'], $_POST['content'])) {
    $stmt = $db->prepare("INSERT INTO posts (title, content) VALUES (:title, :content)");
    $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
    $stmt->bindValue(':content', $_POST['content'], SQLITE3_TEXT);
    $stmt->execute();
}


$result = $db->query("SELECT * FROM posts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Простой блог</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: auto; }
        form { margin-bottom: 20px; }
        textarea, input { width: 100%; margin-top: 5px; padding: 8px; }
        .post { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .delete-btn { background: red; color: white; border: none; padding: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Добавить запись</h2>
    <form method="post">
        <input type="text" name="title" placeholder="Заголовок" required>
        <textarea name="content" placeholder="Текст записи" required></textarea>
        <button type="submit">Добавить</button>
    </form>

    <h2>Все записи</h2>
    <?php while ($row = $result->fetchArray()): ?>
        <div class="post">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
            <form method="post" action="delete.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="delete-btn">Удалить</button>
            </form>
        </div>
    <?php endwhile; ?>
</body>
</html>
