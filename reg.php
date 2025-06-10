<?php
session_start();
include_once("db.php");

if(isset($_POST['submit'])) {
    $fio = mysqli_real_escape_string($link, $_POST['fio']);
    $login = mysqli_real_escape_string($link, $_POST['login']);
    $phone = mysqli_real_escape_string($link, $_POST['phone']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['password']);
    $address = mysqli_real_escape_string($link, $_POST['address']);
    
    // Проверяем, не занят ли email или логин
    $check_query = "SELECT * FROM users WHERE email = '$email' OR login = '$login'";
    $check_result = mysqli_query($link, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $user = mysqli_fetch_assoc($check_result);
        if($user['email'] == $email) {
            $error = "Этот email уже зарегистрирован";
        } else {
            $error = "Этот логин уже занят";
        }
    } else {
        $query = "INSERT INTO users (fio, login, phone, email, password, address, role_id) 
                 VALUES ('$fio', '$login', '$phone', '$email', '$password', '$address', 1)";
        
        if(mysqli_query($link, $query)) {
            header("Location: avto.php");
            exit();
        } else {
            $error = "Ошибка при регистрации: " . mysqli_error($link);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - АвтоСалон</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1><i class="fas fa-car"></i> АвтоСалон</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Главная</a></li>
                <li><a href="avto.php"><i class="fas fa-sign-in-alt"></i> Вход</a></li>
                <li><a href="reg.php" class="active"><i class="fas fa-user-plus"></i> Регистрация</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="auth-container">
                <div class="auth-header">
                    <h2><i class="fas fa-user-plus"></i> Регистрация</h2>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="fio"><i class="fas fa-user"></i> ФИО</label>
                        <input type="text" id="fio" name="fio" required>
                    </div>

                    <div class="form-group">
                        <label for="login"><i class="fas fa-user-circle"></i> Логин</label>
                        <input type="text" id="login" name="login" required>
                    </div>

                    <div class="form-group">
                        <label for="phone"><i class="fas fa-phone"></i> Телефон</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Пароль</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="address"><i class="fas fa-map-marker-alt"></i> Адрес</label>
                        <input type="text" id="address" name="address" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Зарегистрироваться
                        </button>
                        <a href="avto.php" class="btn btn-secondary">
                            <i class="fas fa-sign-in-alt"></i> Уже есть аккаунт? Войти
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html> 