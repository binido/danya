<?php
session_start();
if(empty($_SESSION['auth'])){
    header("Location: avto.php");
    exit();
}

include_once("db.php");
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM test_drive WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои записи на тест-драйв - АвтоСалон</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .test-drives-list {
            display: grid;
            gap: 2rem;
            margin-top: 2rem;
        }

        .test-drive-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1.5rem;
            transition: transform 0.2s;
        }

        .test-drive-card:hover {
            transform: translateY(-2px);
        }

        .test-drive-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .test-drive-id {
            font-size: 1.2rem;
            font-weight: 500;
            color: #333;
        }

        .test-drive-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
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

        .test-drive-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
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
            .test-drive-info {
                grid-template-columns: 1fr;
            }

            .test-drive-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
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
                <li><a href="main.php"><i class="fas fa-home"></i> Главная</a></li>
                <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == '2'): ?>
                <li><a href="admin.php"><i class="fas fa-cog"></i> Панель администратора</a></li>
                <?php endif; ?>
                <li><a href="test_drive.php"><i class="fas fa-car-side"></i> Запись на тест-драйв</a></li>
                <li><a href="my_test_drives.php" class="active"><i class="fas fa-list"></i> Мои записи</a></li>
                <li><a href="lk.php"><i class="fas fa-user"></i> Личный кабинет</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <h2><i class="fas fa-list"></i> Мои записи на тест-драйв</h2>
            </div>

            <?php if(mysqli_num_rows($result) > 0): ?>
                <div class="test-drives-list">
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <div class="test-drive-card">
                            <div class="test-drive-header">
                                <h3><i class="fas fa-car"></i> <?php echo htmlspecialchars($row['car_brand'] . ' ' . $row['car_model']); ?></h3>
                                <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </div>
                            <div class="test-drive-info">
                                <p><i class="fas fa-calendar"></i> Дата: <?php echo date('d.m.Y', strtotime($row['preferred_date'])); ?></p>
                                <p><i class="fas fa-clock"></i> Время: <?php echo date('H:i', strtotime($row['preferred_time'])); ?></p>
                                <p><i class="fas fa-credit-card"></i> Способ оплаты: <?php echo htmlspecialchars($row['payment_type']); ?></p>
                                <p><i class="fas fa-clock"></i> Создано: <?php echo date('d.m.Y H:i', strtotime($row['created_at'])); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-car-side"></i>
                    <h3>У вас пока нет записей на тест-драйв</h3>
                    <p>Запишитесь на тест-драйв, чтобы оценить понравившийся автомобиль</p>
                    <a href="test_drive.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Записаться на тест-драйв
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html> 