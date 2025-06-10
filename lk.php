<?php 
session_start();
include_once("db.php");

if (!isset($_SESSION['auth'])) {
    header("Location: avto.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($link, $query);
$user = mysqli_fetch_assoc($result);

if (empty($user)) {
    session_destroy();
    header("Location: avto.php");
    exit();
}

// Получаем последние 3 записи на тест-драйв
$test_drives_query = "SELECT * FROM test_drive WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 3";
$test_drives_result = mysqli_query($link, $test_drives_query);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - АвтоСалон</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2.5rem;
        }

        .profile-info h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
        }

        .profile-info p {
            margin: 0.5rem 0 0;
            color: #666;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-item i {
            color: #007bff;
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }

        .info-content .label {
            display: block;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.2rem;
        }

        .info-content .value {
            font-weight: 500;
            color: #333;
        }

        .recent-test-drives {
            margin-top: 2rem;
        }

        .recent-test-drives h3 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        .test-drives-list {
            display: grid;
            gap: 1.5rem;
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
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .test-drive-id {
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
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-group {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
        }

        .info-group i {
            color: #007bff;
            font-size: 1.1rem;
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

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

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
                <li><a href="my_test_drives.php"><i class="fas fa-list"></i> Мои записи</a></li>
                <li><a href="lk.php" class="active"><i class="fas fa-user"></i> Личный кабинет</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <h2><i class="fas fa-user"></i> Личный кабинет</h2>
            </div>

            <div class="profile-section">
                <div class="welcome-block">
                    <h3>Добро пожаловать, <?php echo htmlspecialchars($user['fio']); ?>!</h3>
                    <span class="user-role">
                        <?php if($user['role_id'] == 2): ?>
                            <i class="fas fa-user-shield"></i> Администратор
                        <?php else: ?>
                            <i class="fas fa-user"></i> Пользователь
                        <?php endif; ?>
                    </span>
                </div>

                <div class="info-grid">
                    <div class="info-card">
                        <i class="fas fa-user"></i>
                        <div class="info-content">
                            <span class="info-label">ФИО:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['fio']); ?></span>
                        </div>
                    </div>

                    <div class="info-card">
                        <i class="fas fa-phone"></i>
                        <div class="info-content">
                            <span class="info-label">Телефон:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['phone']); ?></span>
                        </div>
                    </div>

                    <div class="info-card">
                        <i class="fas fa-envelope"></i>
                        <div class="info-content">
                            <span class="info-label">Email:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
                        </div>
                    </div>

                    <div class="info-card">
                        <i class="fas fa-map-marker-alt"></i>
                        <div class="info-content">
                            <span class="info-label">Адрес:</span>
                            <span class="info-value"><?php echo htmlspecialchars($user['address']); ?></span>
                        </div>
                    </div>

                    <div class="info-card">
                        <i class="fas fa-calendar-alt"></i>
                        <div class="info-content">
                            <span class="info-label">Дата регистрации:</span>
                            <span class="info-value"><?php echo date('d.m.Y'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="recent-test-drives">
                <h3><i class="fas fa-history"></i> Последние записи на тест-драйв</h3>
                
                <?php if(mysqli_num_rows($test_drives_result) > 0): ?>
                    <div class="test-drives-grid">
                        <?php while($row = mysqli_fetch_assoc($test_drives_result)): ?>
                            <div class="test-drive-card">
                                <div class="test-drive-header">
                                    <h4><i class="fas fa-car"></i> <?php echo htmlspecialchars($row['car_brand'] . ' ' . $row['car_model']); ?></h4>
                                    <span class="status-badge <?php echo strtolower($row['status']); ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </div>
                                <div class="test-drive-info">
                                    <p><i class="fas fa-calendar"></i> Дата: <?php echo date('d.m.Y', strtotime($row['preferred_date'])); ?></p>
                                    <p><i class="fas fa-clock"></i> Время: <?php echo date('H:i', strtotime($row['preferred_time'])); ?></p>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="text-center">
                        <a href="my_test_drives.php" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Все записи
                        </a>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-car-side"></i>
                        <h4>У вас пока нет записей на тест-драйв</h4>
                        <p>Запишитесь на тест-драйв, чтобы оценить понравившийся автомобиль</p>
                        <a href="test_drive.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Записаться на тест-драйв
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>