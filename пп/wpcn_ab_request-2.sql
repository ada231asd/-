-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 09 2024 г., 13:46
-- Версия сервера: 5.7.39
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `wpcn_ab_request-2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `wpcn_ab_request`
--

CREATE TABLE `wpcn_ab_request` (
  `ID` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `telegram_id` bigint(20) NOT NULL DEFAULT '0',
  `message_id` bigint(20) NOT NULL DEFAULT '0',
  `car_brand` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `car_number` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `request_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `request_done` datetime DEFAULT NULL,
  `user_id2` bigint(20) NOT NULL DEFAULT '0',
  `done` bigint(20) NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `wpcn_ab_request`
--

INSERT INTO `wpcn_ab_request` (`ID`, `user_id`, `telegram_id`, `message_id`, `car_brand`, `car_number`, `request_time`, `request_done`, `user_id2`, `done`) VALUES
(1, 1, 0, 0, 'Toyota', 'A111Ap', '2024-10-08 16:23:13', NULL, 0, 3),
(2, 1, 0, 0, 'Honda', 'B222BB', '2024-10-08 16:23:13', NULL, 0, 3),
(3, 2, 0, 0, 'Ford', 'C333CC', '2024-10-08 16:23:13', NULL, 0, 3),
(4, 2, 0, 0, 'Chevrolet', 'D444DD', '2024-10-08 16:23:13', NULL, 0, 3),
(5, 3, 0, 0, 'BMW', 'E555EE', '2024-10-08 16:23:13', NULL, 0, 3),
(7, 2, 0, 0, 'BMW', 'A552QW', '2024-10-08 16:24:51', NULL, 0, 3),
(8, 1, 0, 0, 'Lada', 'B453WN', '2024-10-08 16:41:42', NULL, 0, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `wpcn_users`
--

CREATE TABLE `wpcn_users` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `wpcn_users`
--

INSERT INTO `wpcn_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'user1', 'password1', 'User One', 'user1@example.com', '', '2024-10-08 16:22:59', '', 0, 'User One'),
(2, 'user2', 'password2', 'User Two', 'user2@example.com', '', '2024-10-08 16:22:59', '', 0, 'User Two'),
(3, 'user3', 'password3', 'User Three', 'user3@example.com', '', '2024-10-08 16:22:59', '', 0, 'User Three');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `wpcn_ab_request`
--
ALTER TABLE `wpcn_ab_request`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `wpcn_users`
--
ALTER TABLE `wpcn_users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `wpcn_ab_request`
--
ALTER TABLE `wpcn_ab_request`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `wpcn_users`
--
ALTER TABLE `wpcn_users`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `wpcn_ab_request`
--
ALTER TABLE `wpcn_ab_request`
  ADD CONSTRAINT `wpcn_ab_request_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `wpcn_users` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
