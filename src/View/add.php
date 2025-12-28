<?php
$error = $error ?? null;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="styleseet" href="main.css">
    <title>Добавление задачи</title>
    <style>

    </style>
</head>
<body>
    <div class="form-container">
        <h1>Добавить новую задачу</h1>
        
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="?route=task/add">
            <div class="form-group">
                <label for="title">Название:</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    required 
                    placeholder="Введите название задачи"
                    value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                    autofocus
                >
            </div>
            
            <div class="button-group">
                <button type="submit">Добавить задачу</button>
                <a href="?route=task/list" class="btn btn-cancel">Отмена</a>
            </div>
        </form>
    </div>
</body>
</html>
