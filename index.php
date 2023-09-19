<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Регситрация пользователя</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="box form-box">
        <header class="d-flex justify-content-center py-3">
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="#" class="nav-link active" aria-current="page">Регистрация</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Продукт</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Цены</a></li>
                <li class="nav-item"><a href="#" class="nav-link">FAQ</a></li>
            </ul>
        </header>
    </div>
</div>
<div class="container">
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="FormControlInput1" class="form-label">Имя пользователся</label>
            <input type="text" class="form-control" name="username" id="FormControlInput1" value="<?php echo $_POST['username'] ?? '' ?>" placeholder = "Придумайте имя пользователя">
        </div>

        <div class="mb-3">
            <label for="FormControlInput2" class="form-label">E-mail*</label>
            <input type="email" class="form-control" name="e-mail" id="FormControlInput2" value="<?php echo $_POST['e-mail'] ?? '' ?>" placeholder = "Введите ваш e-mail" required>
        </div>

        <div class="mb-3">
            <label for="FormControlInput3" class="form-label">Пароль*</label>
            <input type="password" class="form-control" name="password" id="FormControlInput3" placeholder = "Придумайте пароль" required>
        </div>

        <div class="mb-3">
            <input type="submit" class="btn btn-primary" value="Зарегистрироваться">
        </div>
    </form>
        <?php
    }
    ?>
</div>
<div class="container">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo '<b>username</b> = ' . ($_POST['username'] ?? '') . '<br>';
        echo 'e-mail = ' . ($_POST['e-mail'] ?? '');
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>