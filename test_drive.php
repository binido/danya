<?php
session_start();
include_once("db.php");

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: avto.php");
    exit();
}

if(isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $brand = mysqli_real_escape_string($link, $_POST['brand']);
    $model = mysqli_real_escape_string($link, $_POST['model']);
    $preferred_date = mysqli_real_escape_string($link, $_POST['preferred_date']);
    $preferred_time = mysqli_real_escape_string($link, $_POST['preferred_time']);
    $payment_type = mysqli_real_escape_string($link, $_POST['payment_type']);
    
    $query = "INSERT INTO test_drive (user_id, car_brand, car_model, preferred_date, preferred_time, payment_type, status) 
              VALUES ($user_id, '$brand', '$model', '$preferred_date', '$preferred_time', '$payment_type', 'pending')";
    
    if(mysqli_query($link, $query)) {
        $success = "Заявка на тест-драйв успешно создана!";
    } else {
        $error = "Ошибка при создании заявки: " . mysqli_error($link);
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на тест-драйв - АвтоСалон</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function updateModels() {
            const brandSelect = document.getElementById('brand');
            const modelSelect = document.getElementById('model');
            const selectedBrand = brandSelect.value;
            
            // Очищаем текущие опции
            modelSelect.innerHTML = '<option value="">Выберите модель</option>';
            
            // Добавляем модели в зависимости от выбранной марки
            if (selectedBrand === 'BMW') {
                addModelOptions(['X5', 'X6', 'X7', '5 Series', '7 Series']);
            } else if (selectedBrand === 'Mercedes-Benz') {
                addModelOptions(['GLE', 'GLS', 'S-Class', 'E-Class', 'G-Class']);
            } else if (selectedBrand === 'Audi') {
                addModelOptions(['Q7', 'Q8', 'A8', 'A6', 'RS Q8']);
            } else if (selectedBrand === 'Lexus') {
                addModelOptions(['LX', 'RX', 'NX', 'ES', 'LS']);
            } else if (selectedBrand === 'Toyota') {
                addModelOptions(['Land Cruiser', 'Prado', 'Camry', 'RAV4', 'Highlander']);
            }
        }

        function addModelOptions(models) {
            const modelSelect = document.getElementById('model');
            models.forEach(model => {
                const option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                modelSelect.appendChild(option);
            });
        }
    </script>
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
                <li><a href="test_drive.php" class="active"><i class="fas fa-car-side"></i> Запись на тест-драйв</a></li>
                <li><a href="my_test_drives.php"><i class="fas fa-list"></i> Мои записи</a></li>
                <li><a href="lk.php"><i class="fas fa-user"></i> Личный кабинет</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2><i class="fas fa-car-side"></i> Запись на тест-драйв</h2>
                </div>

                <?php if(isset($success)): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="test-drive-form">
                    <div class="form-group">
                        <label for="brand"><i class="fas fa-car"></i> Марка автомобиля</label>
                        <select id="brand" name="brand" required onchange="updateModels()">
                            <option value="">Выберите марку</option>
                            <option value="BMW">BMW</option>
                            <option value="Mercedes-Benz">Mercedes-Benz</option>
                            <option value="Audi">Audi</option>
                            <option value="Lexus">Lexus</option>
                            <option value="Toyota">Toyota</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="model"><i class="fas fa-car-side"></i> Модель автомобиля</label>
                        <select id="model" name="model" required>
                            <option value="">Выберите модель</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="preferred_date"><i class="fas fa-calendar"></i> Предпочтительная дата</label>
                        <input type="date" id="preferred_date" name="preferred_date" required>
                    </div>

                    <div class="form-group">
                        <label for="preferred_time"><i class="fas fa-clock"></i> Предпочтительное время</label>
                        <input type="time" id="preferred_time" name="preferred_time" min="09:00" max="18:00" required>
                    </div>

                    <div class="form-group">
                        <label for="payment_type"><i class="fas fa-credit-card"></i> Способ оплаты</label>
                        <select id="payment_type" name="payment_type" required>
                            <option value="">Выберите способ оплаты</option>
                            <option value="Наличные">Наличные</option>
                            <option value="Банковская карта">Банковская карта</option>
                            <option value="Рассрочка">Рассрочка</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Отправить заявку
                        </button>
                        <a href="main.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Вернуться на главную
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html> 