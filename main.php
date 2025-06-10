<?php
session_start();
include_once("db.php");

if (!isset($_SESSION['auth'])) {
    header("Location: avto.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная - АвтоСалон</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2.5rem 2rem;
            margin-bottom: 2.5rem;
        }
        .hero-content {
            flex: 1 1 320px;
        }
        .hero-image {
            flex: 1 1 320px;
            text-align: center;
        }
        .hero-image img {
            max-width: 350px;
            width: 100%;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            color: var(--primary-color);
        }
        .hero-desc {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        .hero-btns {
            display: flex;
            gap: 1.2rem;
            flex-wrap: wrap;
        }
        .hero-btns .btn {
            font-size: 1.1rem;
            padding: 1rem 2.2rem;
        }
        .section-title {
            text-align: center;
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-weight: 600;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 2rem;
            margin-bottom: 2.5rem;
        }
        .feature-card {
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 2rem 1.2rem;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .feature-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.7rem;
            color: var(--primary-color);
        }
        .about-section {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            background: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 2.5rem 2rem;
            margin: 2.5rem 0;
        }
        .about-content {
            flex: 1 1 320px;
        }
        .about-image {
            flex: 1 1 320px;
            text-align: center;
        }
        .about-image img {
            max-width: 350px;
            width: 100%;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }
        .about-list {
            margin-top: 1.2rem;
            list-style: none;
            padding: 0;
        }
        .about-list li {
            margin-bottom: 0.7rem;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        .about-list i {
            color: var(--secondary-color);
            margin-right: 0.5rem;
        }
        @media (max-width: 900px) {
            .hero, .about-section {
                flex-direction: column;
                text-align: center;
            }
            .hero-image img, .about-image img {
                margin: 0 auto;
            }
            .about-list li {
                justify-content: center;
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
                <li><a href="main.php" class="active"><i class="fas fa-home"></i> Главная</a></li>
                <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == '2'): ?>
                <li><a href="admin.php"><i class="fas fa-cog"></i> Панель администратора</a></li>
                <?php endif; ?>
                <li><a href="test_drive.php"><i class="fas fa-car-side"></i> Запись на тест-драйв</a></li>
                <li><a href="my_test_drives.php"><i class="fas fa-list"></i> Мои записи</a></li>
                <li><a href="lk.php"><i class="fas fa-user"></i> Личный кабинет</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Выход</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container">
            <section class="hero">
                <div class="hero-content">
                    <h1 class="hero-title">Добро пожаловать в АвтоСалон!</h1>
                    <p class="hero-desc">Мы предлагаем широкий выбор автомобилей для тест-драйва. Выберите понравившуюся модель и запишитесь на тест-драйв прямо сейчас!</p>
                    <div class="hero-btns">
                        <a href="test_drive.php" class="btn btn-primary">
                            <i class="fas fa-car-side"></i> Записаться на тест-драйв
                        </a>
                        <a href="my_test_drives.php" class="btn btn-secondary">
                            <i class="fas fa-list"></i> Мои записи
                        </a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="image.jpg" alt="Автомобиль">
                </div>
            </section>

            <section class="features">
                <h2 class="section-title">Почему выбирают нас?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <i class="fas fa-car fa-3x"></i>
                        <h3>Большой выбор</h3>
                        <p>Широкий ассортимент автомобилей различных марок и моделей</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-clock fa-3x"></i>
                        <h3>Удобное время</h3>
                        <p>Выбирайте удобное для вас время тест-драйва</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-credit-card fa-3x"></i>
                        <h3>Гибкая оплата</h3>
                        <p>Различные способы оплаты: наличные, карта, рассрочка</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-shield-alt fa-3x"></i>
                        <h3>Гарантия качества</h3>
                        <p>Все автомобили проходят тщательную проверку перед тест-драйвом</p>
                    </div>
                </div>
            </section>

            <section class="about-section">
                <div class="about-content">
                    <h2 class="section-title" style="text-align:left;">О нашем салоне</h2>
                    <p>Мы - современный автомобильный салон, предлагающий услуги тест-драйва различных автомобилей. Наша цель - помочь вам выбрать идеальный автомобиль, который будет соответствовать всем вашим требованиям.</p>
                    <ul class="about-list">
                        <li><i class="fas fa-check"></i> Профессиональные консультанты</li>
                        <li><i class="fas fa-check"></i> Современный автопарк</li>
                        <li><i class="fas fa-check"></i> Удобное расположение</li>
                        <li><i class="fas fa-check"></i> Гибкие условия оплаты</li>
                        <li><i class="fas fa-check"></i> Индивидуальный подход</li>
                    </ul>
                </div>
                <div class="about-image">
                    <img src="team.jpg" alt="Команда">
                </div>
            </section>
        </div>
    </main>
</body>
</html>