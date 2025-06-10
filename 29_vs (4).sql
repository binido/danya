-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 10 2025 г., 22:57
-- Версия сервера: 5.6.51
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `29_vs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Пользователь'),
(2, 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `test_drive`
--

CREATE TABLE `test_drive` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_brand` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `payment_type` enum('Наличные','Банковская карта','Рассрочка') NOT NULL,
  `status` enum('новое','подтверждено','отклонено') NOT NULL DEFAULT 'новое',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `test_drive`
--

INSERT INTO `test_drive` (`id`, `user_id`, `car_brand`, `car_model`, `preferred_date`, `preferred_time`, `payment_type`, `status`, `created_at`) VALUES
(3, 6, 'Волга', '8', '2025-06-14', '14:54:00', '', 'новое', '2025-06-10 18:52:46'),
(4, 6, 'Ламба', '1', '2025-06-22', '10:01:00', 'Наличные', 'новое', '2025-06-10 19:02:28'),
(5, 6, 'Гелик', 'Новый', '2025-06-12', '16:00:00', 'Рассрочка', '', '2025-06-10 19:04:35'),
(6, 6, 'BMW', 'X5', '2025-06-26', '17:00:00', '', '', '2025-06-10 19:07:27'),
(7, 6, 'Toyota', 'Prado', '2025-06-30', '17:00:00', 'Банковская карта', '', '2025-06-10 19:09:08'),
(8, 6, 'Lexus', 'RX', '2025-06-27', '17:40:00', 'Наличные', '', '2025-06-10 19:10:33');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fio` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `fio`, `phone`, `email`, `address`, `role_id`) VALUES
(4, 'user228', 'user228', 'Гулаков Гулак Гулакович', '+7(788)-777-67-76', 'user228@gmail.com', 'Ул. Колатушкино', 2),
(5, 'user229', 'user229', 'Гулаков Гулак Гулакович', '+7(788)-777-67-76', 'user229@gmail.com', 'Ул. Колатушкино', 1),
(6, 'user230', 'user230', 'Кулак Кулак Кулакович', '+7(788)-777-67-76', 'user230@gmail.com', 'Ул. Потапова', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `test_drive`
--
ALTER TABLE `test_drive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `test_drive`
--
ALTER TABLE `test_drive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `test_drive`
--
ALTER TABLE `test_drive`
  ADD CONSTRAINT `test_drive_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
