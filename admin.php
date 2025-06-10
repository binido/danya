<?php
session_start();
include_once("db.php");

if (!isset($_SESSION['auth'])) {
	header("Location: avto.php");
	exit();
}

// Получаем общее количество записей
$total_query = "SELECT COUNT(*) as total FROM test_drive";
$total_result = mysqli_query($link, $total_query);
$total = mysqli_fetch_assoc($total_result)['total'];

// Получаем записи с информацией о пользователях
$query = "SELECT t.*, u.fio, u.phone 
		  FROM test_drive t 
		  JOIN users u ON t.user_id = u.id 
		  ORDER BY t.id DESC";
$result = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Панель администратора - АвтоСалон</title>
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
				<li><a href="main.php"><i class="fas fa-home"></i> Главная</a></li>
				<li><a href="admin.php" class="active"><i class="fas fa-cog"></i> Панель администратора</a></li>
				<li><a href="test_drive.php"><i class="fas fa-car-side"></i> Запись на тест-драйв</a></li>
				<li><a href="my_test_drives.php"><i class="fas fa-list"></i> Мои записи</a></li>
				<li><a href="lk.php"><i class="fas fa-user"></i> Личный кабинет</a></li>
				<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
			</ul>
		</nav>
	</header>

	<main>
		<div class="container">
			<div class="page-header">
				<h2><i class="fas fa-cog"></i> Панель администратора</h2>
				<div class="total-count">
					<i class="fas fa-list"></i> Всего записей: <?php echo $total; ?>
				</div>
			</div>

			<div class="test-drives-list">
				<?php if(mysqli_num_rows($result) > 0): ?>
					<?php while($row = mysqli_fetch_assoc($result)): ?>
						<div class="test-drive-card">
							<div class="test-drive-header">
								<div class="test-drive-id">
									<i class="fas fa-hashtag"></i> Заявка #<?php echo $row['id']; ?>
								</div>
								<div class="test-drive-status <?php echo $row['status']; ?>">
									<i class="fas fa-circle"></i> <?php echo ucfirst($row['status']); ?>
								</div>
							</div>
							
							<div class="test-drive-content">
								<div class="test-drive-info">
									<div class="info-group">
										<i class="fas fa-user"></i>
										<div>
											<span class="label">Клиент:</span>
											<span class="value"><?php echo htmlspecialchars($row['fio']); ?></span>
										</div>
									</div>
									<div class="info-group">
										<i class="fas fa-phone"></i>
										<div>
											<span class="label">Телефон:</span>
											<span class="value"><?php echo htmlspecialchars($row['phone']); ?></span>
										</div>
									</div>
									<div class="info-group">
										<i class="fas fa-car"></i>
										<div>
											<span class="label">Автомобиль:</span>
											<span class="value"><?php echo htmlspecialchars($row['car_brand'] . ' ' . $row['car_model']); ?></span>
										</div>
									</div>
									<div class="info-group">
										<i class="fas fa-calendar"></i>
										<div>
											<span class="label">Дата:</span>
											<span class="value"><?php echo date('d.m.Y', strtotime($row['preferred_date'])); ?></span>
										</div>
									</div>
									<div class="info-group">
										<i class="fas fa-clock"></i>
										<div>
											<span class="label">Время:</span>
											<span class="value"><?php echo date('H:i', strtotime($row['preferred_time'])); ?></span>
										</div>
									</div>
									<div class="info-group">
										<i class="fas fa-credit-card"></i>
										<div>
											<span class="label">Способ оплаты:</span>
											<span class="value"><?php echo htmlspecialchars($row['payment_type']); ?></span>
										</div>
									</div>
								</div>
								
								<div class="test-drive-actions">
									<a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
										<i class="fas fa-edit"></i> Изменить статус
									</a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php else: ?>
					<div class="no-records">
						<i class="fas fa-info-circle"></i> Записей на тест-драйв пока нет
					</div>
				<?php endif; ?>
			</div>
		</div>
	</main>

	<style>
		.page-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 2rem;
		}

		.total-count {
			background: #fff;
			padding: 0.75rem 1.5rem;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0,0,0,0.1);
			font-size: 1.1rem;
			color: #333;
		}

		.total-count i {
			color: #007bff;
			margin-right: 0.5rem;
		}

		.test-drives-list {
			display: grid;
			gap: 1.5rem;
		}

		.test-drive-card {
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			overflow: hidden;
		}

		.test-drive-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 1rem 1.5rem;
			background: #f8f9fa;
			border-bottom: 1px solid #eee;
		}

		.test-drive-id {
			font-weight: 500;
			color: #333;
		}

		.test-drive-id i {
			color: #007bff;
			margin-right: 0.5rem;
		}

		.test-drive-status {
			padding: 0.5rem 1rem;
			border-radius: 20px;
			font-size: 0.9rem;
			font-weight: 500;
		}

		.test-drive-status i {
			margin-right: 0.5rem;
			font-size: 0.8rem;
		}

		.test-drive-status.новое {
			background: #e3f2fd;
			color: #1976d2;
		}

		.test-drive-status.подтверждено {
			background: #e8f5e9;
			color: #2e7d32;
		}

		.test-drive-status.отклонено {
			background: #ffebee;
			color: #c62828;
		}

		.test-drive-content {
			padding: 1.5rem;
		}

		.test-drive-info {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
			gap: 1.5rem;
			margin-bottom: 1.5rem;
		}

		.info-group {
			display: flex;
			align-items: flex-start;
			gap: 1rem;
		}

		.info-group i {
			color: #007bff;
			font-size: 1.2rem;
			margin-top: 0.2rem;
		}

		.info-group .label {
			display: block;
			font-size: 0.9rem;
			color: #666;
			margin-bottom: 0.2rem;
		}

		.info-group .value {
			font-weight: 500;
			color: #333;
		}

		.test-drive-actions {
			display: flex;
			justify-content: flex-end;
			gap: 1rem;
		}

		.no-records {
			text-align: center;
			padding: 3rem;
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			color: #666;
			font-size: 1.1rem;
		}

		.no-records i {
			font-size: 2rem;
			color: #007bff;
			margin-bottom: 1rem;
			display: block;
		}

		@media (max-width: 768px) {
			.page-header {
				flex-direction: column;
				gap: 1rem;
				text-align: center;
			}

			.test-drive-info {
				grid-template-columns: 1fr;
			}

			.test-drive-actions {
				flex-direction: column;
			}

			.test-drive-actions .btn {
				width: 100%;
				text-align: center;
			}
		}
	</style>
</body>
</html>
