<?php
session_start();
include_once("db.php");

if(isset($_POST['submit'])) {
	$login = mysqli_real_escape_string($link, $_POST['login']);
	$password = mysqli_real_escape_string($link, $_POST['password']);
	
	// Проверяем, является ли введенное значение email или логином
	$query = "SELECT * FROM users WHERE (email = '$login' OR login = '$login') AND password = '$password'";
	$result = mysqli_query($link, $query);
	
	if($result) {
		if(mysqli_num_rows($result) > 0) {
			$user = mysqli_fetch_assoc($result);
			$_SESSION['auth'] = true;
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['fio'] = $user['fio'];
			$_SESSION['role_id'] = $user['role_id'];
			
			// Отладочная информация
			echo "ID пользователя: " . $user['id'] . "<br>";
			echo "Роль пользователя: " . $user['role'] . "<br>";
			
			header("Location: main.php");
			exit();
		} else {
			$error = "Неверный логин или пароль";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Вход - АвтоСалон</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<style>
		.auth-container {
			max-width: 500px;
			margin: 2rem auto;
			padding: 2.5rem;
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
		}

		.auth-form {
			display: flex;
			flex-direction: column;
			gap: 1.2rem;
		}

		.form-group {
			display: grid;
			grid-template-columns: 150px 1fr;
			align-items: center;
			gap: 1rem;
		}

		.form-group label {
			margin: 0;
			white-space: nowrap;
			color: #333;
			font-weight: 500;
		}

		.form-group input {
			margin: 0;
			padding: 0.8rem;
			border: 1px solid #ddd;
			border-radius: 6px;
			font-size: 1rem;
			transition: border-color 0.3s;
		}

		.form-group input:focus {
			border-color: #007bff;
			outline: none;
		}

		.btn {
			margin-top: 1rem;
			width: 100%;
			padding: 1rem;
			background: #007bff;
			color: #fff;
			border: none;
			border-radius: 6px;
			font-size: 1rem;
			font-weight: 500;
			cursor: pointer;
			transition: background 0.3s;
			display: flex;
			align-items: center;
			justify-content: center;
			gap: 0.5rem;
		}

		.btn:hover {
			background: #0056b3;
		}

		.auth-links {
			margin-top: 2rem;
			display: flex;
			flex-direction: column;
			gap: 0.8rem;
			align-items: center;
			color: #666;
		}

		.auth-links a {
			color: #007bff;
			text-decoration: none;
			transition: color 0.3s;
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}

		.auth-links a:hover {
			color: #0056b3;
		}

		.message {
			padding: 1rem;
			border-radius: 6px;
			margin-bottom: 1rem;
			display: flex;
			align-items: center;
			gap: 0.8rem;
		}

		.message.error {
			background: #f8d7da;
			color: #721c24;
			border: 1px solid #f5c6cb;
		}

		.message i {
			font-size: 1.2rem;
		}

		@media (max-width: 600px) {
			.form-group {
				grid-template-columns: 1fr;
				gap: 0.5rem;
			}

			.auth-container {
				padding: 1.5rem;
				margin: 1rem;
			}
		}
	</style>
</head>
<body>
	<header>
		<div class="header-content">
			<h1><i class="fas fa-car"></i> АвтоСалон</h1>
		</div>
		<nav>
			<ul>
				<li><a href="index.php"><i class="fas fa-home"></i> Главная</a></li>
				<li><a href="avto.php" class="active"><i class="fas fa-sign-in-alt"></i> Вход</a></li>
				<li><a href="reg.php"><i class="fas fa-user-plus"></i> Регистрация</a></li>
			</ul>
		</nav>
	</header>
	
	<main>
		<div class="container">
			<div class="auth-container">
				<div class="auth-header">
					<h2><i class="fas fa-sign-in-alt"></i> Вход в систему</h2>
				</div>

				<?php if(isset($error)): ?>
					<div class="alert alert-danger">
						<i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
					</div>
				<?php endif; ?>

				<form method="POST" class="auth-form">
					<div class="form-group">
						<label for="login"><i class="fas fa-user"></i> Логин или Email</label>
						<input type="text" id="login" name="login" required>
					</div>

					<div class="form-group">
						<label for="password"><i class="fas fa-lock"></i> Пароль</label>
						<input type="password" id="password" name="password" required>
					</div>

					<div class="form-actions">
						<button type="submit" name="submit" class="btn btn-primary">
							<i class="fas fa-sign-in-alt"></i> Войти
						</button>
						<a href="reg.php" class="btn btn-secondary">
							<i class="fas fa-user-plus"></i> Зарегистрироваться
						</a>
					</div>
				</form>
			</div>
		</div>
	</main>
</body>
</html>