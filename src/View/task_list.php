<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="styleseet" href="main.css">
    <title>Лист Задач</title>
</head>

<body>
    <div class="container">
        <h1>Список задач</h1>
        
        <a href="?route=task/add" class="btn-add">+ Добавить задачу</a>
        
        <?php if (empty($tasks)): ?>
            <div class="empty-state">
                <p>Задач пока нет.</p>
                <p><a href="?route=task/add" class="btn-add">Добавьте первую задачу</a></p>
            </div>
        <?php else: ?>
            <ul>
                <?php foreach ($tasks as $task): ?>
                    <li class="<?= $task->isCompleted() ? 'completed' : '' ?>">
                        <span class="task-status">
                            <?= $task->isCompleted() ? "✔" : "❌"?>
                        </span>
                        <span><?= htmlspecialchars($task->getTitle())?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>

</html>


