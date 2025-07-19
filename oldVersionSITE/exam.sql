-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 19 2025 г., 10:21
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `exam`
--

-- --------------------------------------------------------

--
-- Структура таблицы `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `species` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `cage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `animals`
--

INSERT INTO `animals` (`id`, `species`, `name`, `age`, `description`, `image`, `cage_id`) VALUES
(9, 'Олень', 'Тимрок', 2, 'Тимрок любит покушать', 'img/687a2e5076afc_1.jpg', 5),
(10, 'Тигр', 'Король', 7, 'Он король лев, но очень любит кушать', 'img/687a2eb191f73_2.jpg', 5),
(11, 'Обезьяна', 'Смумки', 3, 'Улыбака', 'img/687a2f0030e58_3.jpg', 5),
(14, 'Крокодил', 'Гена', 10, 'Съел чебурашку', 'img/687b409f633a3_krokodil.jpg', 10),
(15, 'Попугай', 'Голубь', 1, 'Голубой попугай', 'img/687b429084df3_123.jpeg', 7),
(16, 'Попугай', 'Пират', 5, 'Он говорит', 'img/687b42ac981ac_132.jpg', 7),
(17, 'Слон', 'Малютка', 6, 'Гигагигагига', 'img/687b432fa5f95_slon.jpg', 8),
(18, 'Суслик', 'Мелочь', 1, 'Самый крутой', 'img/687b439013ef4_uslik.jpg', 9),
(19, 'Фугу', 'Шарик', 2, 'Самый опасный из всех', 'img/687b43d292b62_qr.jpg', 15);

-- --------------------------------------------------------

--
-- Структура таблицы `cages`
--

CREATE TABLE `cages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `cages`
--

INSERT INTO `cages` (`id`, `name`, `capacity`) VALUES
(5, 'Смешанная', 7),
(7, 'Птицы', 2),
(8, 'Большие животные', 3),
(9, 'Маленькие животные', 10),
(10, 'Крокодилы', 3),
(15, 'Рыбки', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`) VALUES
(1, 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cage_id` (`cage_id`);

--
-- Индексы таблицы `cages`
--
ALTER TABLE `cages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `cages`
--
ALTER TABLE `cages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`cage_id`) REFERENCES `cages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
