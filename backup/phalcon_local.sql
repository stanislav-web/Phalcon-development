-- phpMyAdmin SQL Dump
-- version 4.3.0-beta1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Дек 29 2014 г., 10:49
-- Версия сервера: 5.6.19-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `phalcon.local`
--

DELIMITER $$
--
-- Функции
--
CREATE DEFINER=`root`@`localhost` FUNCTION `REBUILD_TREE`() RETURNS int(11)
    MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
    -- Изначально сбрасываем все границы в NULL
    UPDATE categories t SET lft = NULL, rgt = NULL;
    
    -- Устанавливаем границы корневым элементам
    SET @i := 0;
    UPDATE categories t SET lft = (@i := @i + 1), rgt = (@i := @i + 1)
    WHERE t.parent_id IS NULL;

    forever: LOOP
        -- Находим элемент с минимальной правой границей -- самый левый в дереве
        SET @parent_id := NULL;
        SELECT t.id, t.rgt FROM categories t, categories tc
        WHERE t.id = tc.parent_id AND tc.lft IS NULL AND t.rgt IS NOT NULL
        ORDER BY t.rgt LIMIT 1 INTO @parent_id, @parent_right;

        -- Выходим из бесконечности, когда у нас уже нет незаполненных элементов
        IF @parent_id IS NULL THEN LEAVE forever; END IF;

        -- Сохраняем левую границу текущего ряда
        SET @current_left := @parent_right;

        -- Вычисляем максимальную правую границу текущего ряда
        SELECT @current_left + COUNT(*) * 2 FROM categories
        WHERE parent_id = @parent_id INTO @parent_right;

        -- Вычисляем длину текущего ряда
        SET @current_length := @parent_right - @current_left;

        -- Обновляем правые границы всех элементов, которые правее
        UPDATE categories t SET rgt = rgt + @current_length
        WHERE rgt >= @current_left ORDER BY rgt;

        -- Обновляем левые границы всех элементов, которые правее
        UPDATE categories t SET lft = lft + @current_length
        WHERE lft > @current_left ORDER BY lft;

        -- И только сейчас обновляем границы текущего ряда
        SET @i := (@current_left - 1);
        UPDATE categories t SET lft = (@i := @i + 1), rgt = (@i := @i + 1)
        WHERE parent_id = @parent_id ORDER BY id;
    END LOOP;

    -- Возвращаем самый самую правую границу для дальнейшего использования
    RETURN (SELECT MAX(rgt) FROM categories t);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` tinyint(3) unsigned NOT NULL COMMENT 'Category id',
  `title` varchar(255) DEFAULT NULL COMMENT 'Category title',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT 'Category description',
  `alias` varchar(64) NOT NULL DEFAULT '' COMMENT 'Category alias',
  `parent_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'Parent category',
  `lft` smallint(5) unsigned DEFAULT NULL COMMENT 'Left padding',
  `rgt` smallint(5) unsigned DEFAULT NULL COMMENT 'Right padding',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Sort index',
  `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Create date',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Update date'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `description`, `alias`, `parent_id`, `lft`, `rgt`, `sort`, `date_create`, `date_update`) VALUES
(22, 'First category', 'my first category', 'first_category', NULL, 1, 8, 0, '2014-11-20 00:00:00', '2014-12-01 01:53:00'),
(23, 'Second category', 'My second category', 'second_category', NULL, 9, 16, 0, '2014-11-18 00:00:00', '2014-12-01 01:53:00'),
(24, 'Third category', 'My third category', 'third_category', NULL, 17, 24, 0, '2014-11-17 00:00:00', '2014-12-01 01:53:00'),
(25, 'Child of first 1', 'Description of child', 'child_first1', 22, 2, 3, 0, '2014-11-25 00:00:00', '2014-12-01 01:53:00'),
(26, 'Child of first 2', 'Description of child', 'child_first2', 22, 4, 5, 0, '2014-11-04 00:00:00', '2014-12-01 01:53:00'),
(27, 'Child of first 3', 'Description of child', 'child_first3', 22, 6, 7, 0, '2014-11-16 00:00:00', '2014-12-01 01:53:00'),
(28, 'Child of second 2', 'Description of second', 'child_second2', 23, 10, 11, 0, '2014-11-18 00:00:00', '2014-12-01 01:53:00'),
(29, 'Child of second 3', 'Description of second', 'child_second3', 23, 12, 13, 0, '0000-00-00 00:00:00', '2014-12-01 01:53:00'),
(30, 'Child of second 1', 'Description of second', 'child_second1', 23, 14, 15, 0, '2014-11-18 00:00:00', '2014-12-01 01:53:00'),
(31, 'Child of third 1', 'Description of third', 'child_third1', 24, 18, 19, 0, '2014-11-12 00:00:00', '2014-12-01 01:53:00'),
(32, 'Child of third 2', 'Description of third', 'child_third2', 24, 20, 21, 0, '2014-11-08 00:00:00', '2014-12-01 01:53:00'),
(33, 'Child of third 3', 'Description of third', 'child_third3', 24, 22, 23, 0, '2014-11-08 00:00:00', '2014-12-01 01:53:00');

-- --------------------------------------------------------

--
-- Структура таблицы `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
`id` tinyint(3) unsigned NOT NULL COMMENT 'Currency ID',
  `code` char(3) NOT NULL COMMENT 'Currency Code',
  `name` varchar(45) DEFAULT NULL COMMENT 'Currency name',
  `symbol` varchar(4) DEFAULT NULL COMMENT 'Currency symbol'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currency`
--

INSERT INTO `currency` (`id`, `code`, `name`, `symbol`) VALUES
(1, 'USD', 'USA Dollar', '$'),
(2, 'RUR', 'Российский рубль', 'руб.'),
(3, 'EUR', 'Euro', '€'),
(4, 'UAH', 'Украинская гривна', '₴'),
(5, 'GBP', 'Pound', '£');

-- --------------------------------------------------------

--
-- Структура таблицы `engines`
--

CREATE TABLE IF NOT EXISTS `engines` (
`id` tinyint(2) unsigned NOT NULL COMMENT 'Engine ID',
  `name` varchar(45) NOT NULL COMMENT 'Engine name',
  `description` varchar(512) NOT NULL COMMENT 'Engine description',
  `host` varchar(45) DEFAULT NULL COMMENT 'identity host name',
  `code` char(3) NOT NULL COMMENT 'Engine short code',
  `currency_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'Relation to `currency` table',
  `status` bit(1) NOT NULL COMMENT 'enabled/disabled',
  `date_create` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 MAX_ROWS=10;

--
-- Дамп данных таблицы `engines`
--

INSERT INTO `engines` (`id`, `name`, `description`, `host`, `code`, `currency_id`, `status`, `date_create`, `date_update`) VALUES
(31, 'Phalcon Shop', '<p><span style="color: #575757; font-family: ProximaNovaLight, ''Helvetica Neue'', Helvetica, Arial, sans-serif; font-size: 15px; line-height: 24px;">While meta descriptions won''t directly help move your online store up in the search results, they are an important factor that will affect whether people click on it in the search results. When composing your descriptions, aim to create great ad copy that will draw the user into your site.</span></p>', 'phalcon.local', 'PHL', 4, b'1', '2014-11-30 17:28:53', '2014-11-30 15:28:53');

-- --------------------------------------------------------

--
-- Структура таблицы `engines_categories_rel`
--

CREATE TABLE IF NOT EXISTS `engines_categories_rel` (
  `engine_id` tinyint(2) unsigned DEFAULT NULL COMMENT 'to engines.id rel',
  `category_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'to categories.id rel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) unsigned NOT NULL COMMENT 'User ID',
  `login` varchar(40) NOT NULL DEFAULT '' COMMENT 'User login',
  `name` varchar(40) NOT NULL COMMENT 'User name',
  `surname` varchar(40) NOT NULL COMMENT 'User surname',
  `password` varchar(150) NOT NULL DEFAULT '' COMMENT 'Password hash',
  `salt` varchar(150) NOT NULL COMMENT 'Salt',
  `state` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT 'Activity state, 0 - disabled, 1 - active, 2 - banned',
  `rating` decimal(10,0) unsigned NOT NULL DEFAULT '0' COMMENT 'User rating',
  `date_registration` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Registration date',
  `date_lastvisit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Last visit date',
  `ip` int(10) unsigned DEFAULT NULL COMMENT 'IP addres',
  `ua` varchar(255) NOT NULL DEFAULT '' COMMENT 'User agent'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Common users table';

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `surname`, `password`, `salt`, `state`, `rating`, `date_registration`, `date_lastvisit`, `ip`, `ua`) VALUES
(1, 'stanisov@gmail.com', 'Stanislav', 'WEB', '$2a$08$Sfv19bymtI2T0zehGFFvcukropITsLTrwCUIoqACCwbariVetrhOm', '0123456789', '2', '0', '2007-12-31 23:59:59', '2014-12-23 23:51:48', 2130706433, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36'),
(2, 'moderator@gmail.com', 'Moder', 'Site', '$2a$08$i8eF./itFwHjirh2A5Qq.OPfa3I1T/mut.Q3uHBXbw9BCMWQoVcda', '0123456789', '2', '1', '2007-12-31 23:59:59', '2007-12-31 23:59:59', 3232235521, 'USER AGENT');

-- --------------------------------------------------------

--
-- Структура таблицы `users_observer`
--

CREATE TABLE IF NOT EXISTS `users_observer` (
  `user_id` int(10) unsigned NOT NULL COMMENT 'User Id',
  `start` binary(8) DEFAULT NULL COMMENT 'User logIn',
  `end` binary(8) DEFAULT NULL COMMENT 'User logOut'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Watchdog for authorized users';

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uni_alias` (`alias`), ADD KEY `idx_rgt` (`rgt`), ADD KEY `idx_lft` (`lft`);

--
-- Индексы таблицы `currency`
--
ALTER TABLE `currency`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique code';

--
-- Индексы таблицы `engines`
--
ALTER TABLE `engines`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uni_code` (`code`) COMMENT 'Unique value of code', ADD UNIQUE KEY `uni_host` (`host`), ADD KEY `fk_currency_id` (`currency_id`);

--
-- Индексы таблицы `engines_categories_rel`
--
ALTER TABLE `engines_categories_rel`
 ADD KEY `idx_category_id` (`category_id`), ADD KEY `idx_engine_id` (`engine_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `login` (`login`), ADD KEY `state` (`state`);

--
-- Индексы таблицы `users_observer`
--
ALTER TABLE `users_observer`
 ADD UNIQUE KEY `user_id_UNIQUE` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Category id',AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT для таблицы `currency`
--
ALTER TABLE `currency`
MODIFY `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Currency ID',AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `engines`
--
ALTER TABLE `engines`
MODIFY `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Engine ID',AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User ID',AUTO_INCREMENT=3;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `engines`
--
ALTER TABLE `engines`
ADD CONSTRAINT `fk_currency_id` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `engines_categories_rel`
--
ALTER TABLE `engines_categories_rel`
ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_engine_id` FOREIGN KEY (`engine_id`) REFERENCES `engines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users_observer`
--
ALTER TABLE `users_observer`
ADD CONSTRAINT `fk_users_observer` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
