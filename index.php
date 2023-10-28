<?php

require_once 'User.php';
require_once 'FileUserPersist.php';
require_once 'DatabaseUserPersist.php';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $filePersister = new FileUserPersist();

    if (isset($_GET['action']) && 'login' === $_GET['action']) {
        $user = $filePersister->get(strtolower($_POST['login']));
        #Если не нашелся пользователь, то просто выдаст ошибку и остановится на этом
        if (!$user) {
            die('Неверный логин или пароль');
        }

        if ($user->getPassword() === sha1($_POST['password'])) {
            session_start();

            $_SESSION['user'] = $user->getLogin();
        }

        header('Location: index.php');
        die();
    }
#Передаем логин, пароль и его подтверждение, дату регистрации
#Если эти данные Не переданы, то с помощью указания типа (string) будут выданы просто пустые строчки
    $user = new User((string) $_POST['login'], (string) $_POST['password'], (string) $_POST['passwordConfirm']);

    echo $user->getCreatedAt()->format('d.m.Y H:i:s') . '<br>';
    echo ($user->isPasswordsEquals() ? 'Одинаковые' : 'Разные') . ' пароли';

#Если пароли НЕ одинаковы, то выводим ошибку
    if (!$user->isPasswordsEquals()) {
        echo 'Ошибка: пароли не совпадают!';
        die();
    }
#Если пользователь уже зарегистрирован, то есть он есть уже в файле или базе, то выдаст ошибку
    if ($filePersister->get($_POST['login']) instanceof User) {
        echo 'Ошибка: пользователь уже существует!';
        die();
    }

    $filePersister->save($user);

    header('Location: index.php?registration=success');
    die();

}

if (isset($_GET['action']) && 'logout' === $_GET['action']) {
    session_unset();
    header('Location: index.php');
    die();
}
?>

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
    <?php if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_SESSION['user'])) {
        echo sprintf('Привет, %s', $_SESSION['user']). '<a class "btn btn-success" href="index.php?action=logout">Выйти<a/><br>';
        }
        ?>
    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="FormControlInput1" class="form-label">Логин</label>
            <input type="text" class="form-control" name="login" id="FormControlInput1"
        </div>

        <div class="mb-3">
            <label for="FormControlInput2" class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password" id="FormControlInput2" placeholder = "Введите пароль" required>
        </div>

        <div class="mb-3">
            <label for="FormControlInput3" class="form-label">Подтверждение пароля</label>
            <input type="password" class="form-control" name="passwordConfirm" id="FormControlInput3" placeholder = "Подтверждите пароля" required>
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
    if (isset($_GET['registration']) && 'success' === $_GET['registration']) {
        ?>
        <form action="index.php?action=login" method="post">
            <div class="mb-3">
                <label for="FormControlInput1" class="form-label">Логин</label>
                <input type="text" class="form-control" name="login" id="FormControlInput1">
            </div>

            <div class="mb-3">
                <label for="FormControlInput2" class="form-label">Пароль</label>
                <input type="password" class="form-control" name="password" id="FormControlInput2" placeholder="Пароль">
            </div>

            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Войти">
            </div>
        </form>
    <?php
    }
    ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>