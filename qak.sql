-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Май 01 2022 г., 12:29
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `qak`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_command`
--

CREATE TABLE IF NOT EXISTS `admin_command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `command` varchar(300) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Дамп данных таблицы `admin_command`
--

INSERT INTO `admin_command` (`id`, `command`, `uid`, `time`) VALUES
(46, '/verification 2 1', 1, 1646671015),
(47, '/verification 2 0', 1, 1646671028),
(48, '/scam 2', 1, 1650045095),
(49, '/verification 2 1', 1, 1650045217);

-- --------------------------------------------------------

--
-- Структура таблицы `black_list`
--

CREATE TABLE IF NOT EXISTS `black_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_blocker` int(11) NOT NULL,
  `user_blocked` int(11) NOT NULL,
  `date_public` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `date_public` varchar(30) NOT NULL DEFAULT '1970-01-01 03.00.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `message`, `date_public`) VALUES
(3, 1, 3, 'Тестовый комментарий!', '2022-01-26 05:36:17'),
(4, 1, 3, 'Тестовый комментарий!', '2022-01-26 05:38:14'),
(5, 1, 3, 'Тестовый комментарий!', '2022-01-26 05:54:31'),
(6, 1, 3, 'Тестовый комм.', '2022-02-20 14:13:55');

-- --------------------------------------------------------

--
-- Структура таблицы `comments_likes`
--

CREATE TABLE IF NOT EXISTS `comments_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '1234000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `comments_likes`
--

INSERT INTO `comments_likes` (`id`, `uid`, `pid`, `cid`, `time`) VALUES
(18, 1, 3, 5, 1643225101),
(24, 1, 3, 4, 1650042003),
(25, 1, 3, 3, 1650042020);

-- --------------------------------------------------------

--
-- Структура таблицы `dialog`
--

CREATE TABLE IF NOT EXISTS `dialog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` varchar(30) NOT NULL,
  `uid` int(11) NOT NULL,
  `uid2` int(11) NOT NULL,
  `date` varchar(30) NOT NULL DEFAULT '1997-01-01 00:00:00',
  `date2` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `status` int(1) NOT NULL DEFAULT '1',
  `send` int(11) NOT NULL,
  `recive` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `dialog`
--

INSERT INTO `dialog` (`id`, `did`, `uid`, `uid2`, `date`, `date2`, `status`, `send`, `recive`, `key`) VALUES
(1, 'wLibCHHmR1Zej55sIGDBl580pDYupO', 1, 1, '2022-01-25 13:03:31', '1647859501', 0, 1, 0, 'RhJpbFT7Q9CF9rfj9GHvSwwepwS2TG5NHcaWIk4BiUc107xtmg');

-- --------------------------------------------------------

--
-- Структура таблицы `dialog_messages`
--

CREATE TABLE IF NOT EXISTS `dialog_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'text',
  `text` varchar(10000) DEFAULT 'Text',
  `source` varchar(500) DEFAULT NULL,
  `reply` varchar(10000) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `date` varchar(30) DEFAULT '1997-01-01 03:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `dialog_messages`
--

INSERT INTO `dialog_messages` (`id`, `did`, `uid`, `type`, `text`, `source`, `reply`, `status`, `date`) VALUES
(4, 1, 1, 'image', 'Text', 'https://sun.qwaker.net/uploads/xianitt-MESSAGE-20220125131651-644339.png', NULL, 0, '1643102211'),
(5, 1, 1, 'text', 'Ctsb96kROAofAs6LEvVHhQuF3c8LFcXzCu7aB/dk5ZjSw5InDTe5QTcdzFCYlNDtRgehY+1ZFFBdGNXvUd+h39ZZwgvQJ6s5g+xlthVff5SyYel1RftvlNroiWvcKip7A=', NULL, '0', 0, '1644738175'),
(7, 1, 1, 'gif', 'Text', '{"static":"https://media3.giphy.com/media/LTYT5GTIiAMBa/100_s.gif?cid=5c00e109zppq3jfy2hi9bfy5c22lt9lawulb6txy9dwd6fkx&rid=100_s.gif&ct=g","url":"https://media3.giphy.com/media/LTYT5GTIiAMBa/giphy.gif?cid=5c00e109zppq3jfy2hi9bfy5c22lt9lawulb6txy9dwd6fkx&rid=giphy.gif&ct=g"}', NULL, 0, '1645045436'),
(8, 1, 1, 'gif', 'Text', '{"static":"https://media1.giphy.com/media/EdS6yxoLJ45Q4/100_s.gif?cid=5c00e109pdqovm431mh5lbndsj1dpd9fuobw6yhtlbb9y4tz&rid=100_s.gif&ct=g","url":"https://media1.giphy.com/media/EdS6yxoLJ45Q4/giphy.gif?cid=5c00e109pdqovm431mh5lbndsj1dpd9fuobw6yhtlbb9y4tz&rid=giphy.gif&ct=g"}', NULL, 0, '1645046467'),
(9, 1, 1, 'gif', 'Text', '{"static":"https://media4.giphy.com/media/EZICHGrSD5QEFCxMiC/100_s.gif?cid=5c00e109z7diuspreoboqnu3jv06vxu0lwkpcw260z54m1tp&rid=100_s.gif&ct=g","url":"https://media4.giphy.com/media/EZICHGrSD5QEFCxMiC/giphy.gif?cid=5c00e109z7diuspreoboqnu3jv06vxu0lwkpcw260z54m1tp&rid=giphy.gif&ct=g"}', NULL, 0, '1645046561'),
(10, 1, 1, 'text', 'fNt48fp4WPmdl85IKx9lhANWf6LzkZxRUgIlUojUGILnJ3cQcbNBTYdSm+3EXvODICxIkTLJIeUwP8NrhIZxYh', NULL, '0', 0, '1645046677'),
(11, 1, 1, 'text', 'XQXmTzMbD0tAl8LRDCFKSA+LdlAvoMJDayhxCeS3Ern7SfQH5WRgud2nalKQ/LUXPZcPCSJiDXDQ6z5aW3QB1XQlwz/Pf9SBMq6vxTA3l1wJrD19nZNhTrdJaWESpMiowF0eIDlL946E8Cx95qy9n6ElIJ6/sozYvymokjslcKgCgc8bKN2dKyUFOYzBvZUGt2LdssNhIyl2S8hrWiquN3j1vbE5xqL2ySPwvAYFjRAQ==', NULL, '0', 0, '1645046899'),
(12, 1, 1, 'text', 'qfPazMA8f9tzXHLHCr69ugs2jry+Q0FCAEawtowdeb3KxhFQ/jQek3NtLtWwmpDZFA+Iivle/zh8xO20g3Ub0Q', NULL, '0', 0, '1645047459'),
(13, 1, 1, 'gif', 'Text', '{"static":"https://media1.giphy.com/media/Qvns6NmhC1MBLKGbL1/100_s.gif?cid=5c00e109v2obkj54nqfupd4cq5va3wyedb5spsp0o05b2ali&rid=100_s.gif&ct=g","url":"https://media1.giphy.com/media/Qvns6NmhC1MBLKGbL1/giphy.gif?cid=5c00e109v2obkj54nqfupd4cq5va3wyedb5spsp0o05b2ali&rid=giphy.gif&ct=g"}', NULL, 0, '1647859501');

-- --------------------------------------------------------

--
-- Структура таблицы `follows`
--

CREATE TABLE IF NOT EXISTS `follows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `date_follow` varchar(30) DEFAULT NULL,
  `date_confirm` varchar(30) DEFAULT NULL,
  `confirm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `followed_id`, `date_follow`, `date_confirm`, `confirm`) VALUES
(1, 1, 1, '2022-03-08 13:49:08', '2022-03-08 13:49:08', 1),
(2, 2, 1, '2022-03-08 14:05:30', '2022-03-20 19:39:20', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `invites`
--

CREATE TABLE IF NOT EXISTS `invites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invite` varchar(500) NOT NULL DEFAULT 'XXXX-XXXX-XXXX',
  `date` varchar(250) DEFAULT NULL,
  `date_activated` varchar(250) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `utoken` varchar(250) DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `invites`
--

INSERT INTO `invites` (`id`, `invite`, `date`, `date_activated`, `uid`, `utoken`, `activated`) VALUES
(11, 'd13aae401269cb1834f39a811b0fdf2f', '1646663602', '1646663783', 1, '211d70290c19c2c5d1caed8a0dfa91fc', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'system',
  `category` varchar(20) DEFAULT NULL,
  `message` varchar(200) DEFAULT NULL,
  `message2` varchar(200) DEFAULT NULL,
  `message3` varchar(200) DEFAULT NULL,
  `readed` tinyint(1) NOT NULL DEFAULT '0',
  `date_public` varchar(30) DEFAULT '1997-01-01 03:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Дамп данных таблицы `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_id`, `type`, `category`, `message`, `message2`, `message3`, `readed`, `date_public`) VALUES
(1, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.99 Safari/537.36', NULL, 1, '2022-01-25 10:31:12'),
(2, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.82 Safari/537.36', NULL, 1, '2022-02-14 14:11:29'),
(3, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.82 Safari/537.36', NULL, 1, '2022-02-14 14:39:04'),
(4, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', NULL, 1, '2022-02-18 07:41:18'),
(5, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', NULL, 1, '2022-02-20 13:47:13'),
(6, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/98.0.4758.102 Safari/537.36', NULL, 1, '2022-02-20 17:22:02'),
(7, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1', NULL, 1, '2022-02-22 05:20:57'),
(8, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-06 15:13:04'),
(9, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-06 22:18:54'),
(10, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-07 01:43:03'),
(11, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-07 03:07:41'),
(12, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-07 08:48:02'),
(13, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-07 18:31:27'),
(14, 2, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-07 18:36:31'),
(15, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', NULL, 1, '2022-03-07 18:45:19'),
(16, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', NULL, 1, '2022-03-08 10:47:18'),
(17, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', NULL, 1, '2022-03-08 12:21:26'),
(18, 2, 1, 'user', 'followed', NULL, NULL, NULL, 0, '2022-03-08 13:49:08'),
(19, 2, 1, 'user', 'followed', NULL, NULL, NULL, 0, '2022-03-08 14:05:30'),
(22, 1, 1, 'comment', 'like', '3', '3', 'Тестовый комментарий!', 1, '2022-03-20 18:24:23'),
(23, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.74 Safari/537.36', NULL, 1, '2022-03-20 18:39:15'),
(24, 2, 1, 'follow', 'confirm', NULL, NULL, NULL, 0, '2022-03-20 19:39:20'),
(25, 1, 0, 'secure', 'sign-in', '127.0.0.1', 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1', NULL, 1, '2022-03-22 14:38:48'),
(26, 1, 0, 'secure', 'sign-in', '128.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36', NULL, 1, '2022-04-15 14:34:06');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'post',
  `category` int(11) NOT NULL DEFAULT '0',
  `archive` tinyint(1) NOT NULL DEFAULT '0',
  `commented` tinyint(1) NOT NULL DEFAULT '1',
  `title` varchar(100) DEFAULT NULL,
  `message` text,
  `image1` varchar(200) DEFAULT NULL,
  `image2` varchar(200) DEFAULT NULL,
  `image3` varchar(200) DEFAULT NULL,
  `language` varchar(2) NOT NULL DEFAULT 'en',
  `date_view` int(11) NOT NULL DEFAULT '0',
  `date_public` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `post_id`, `user_id`, `creator_id`, `views`, `type`, `category`, `archive`, `commented`, `title`, `message`, `image1`, `image2`, `image3`, `language`, `date_view`, `date_public`, `date`) VALUES
(3, 'KNXQkSvp6mRsdgERCSXq6EVDPODPQx', 1, 1, 63, 'post', 0, 0, 0, '', 'Новая публикация с картинками.', 'https://sun.qwaker.net/uploads/xianitt-POST-20220125141257-827456.png', 'https://sun.qwaker.net/uploads/xianitt-POST-20220125141258-246563.png', 'https://sun.qwaker.net/uploads/xianitt-POST-20220125141259-830538.png', 'ru', 1643105576, '2022-01-25 14:12:55', '2022-04-15 17:44:59'),
(4, 'VVqnTmdCK6jyWO3rKGpZLmP7joBLYx', 1, 1, 11, 'post', 0, 0, 1, '', 'Пробная публикация.', '', '', '', 'ут', 1643162442, '2022-01-26 06:00:41', '2022-02-14 11:34:09'),
(5, '2_uYUjkbJeVKooaPmwXA2mWMuLPLhA', 1, 1, 13, 'post', 3, 0, 1, '', 'Публикация с категорией.', '', '', '', 'ru', 1643162669, '2022-01-26 06:04:28', '2022-02-14 12:54:18'),
(6, 'O7dmo8VIuvPK9MytmZpCbf35Qp20jN', 1, 1, 4, 'post', 24, 0, 1, '', 'Тестовая публикация с категорией "Образование".', '', '', '', 'ru', 1644836563, '2022-02-14 15:02:42', '2022-02-16 08:38:57'),
(8, 'dBcLXWuksixUWtbtG05bojK108Rdk9', 1, 1, 9, 'post', 0, 0, 1, '', 'Тестовая публикация с хэштегами.\r\n#тест #qwaker #socialnetwork', '', '', '', 'ru', 1645108380, '2022-02-17 18:32:59', '2022-03-22 05:09:36'),
(9, 'KOysrFfhGixnVyWMWOUqWFg0WJuLOi', 1, 1, 4, 'post', 0, 0, 1, '', 'Тестовая публикация с хэштегам.\r\n#qwaker', '', '', '', 'ru', 1645119742, '2022-02-17 21:42:21', '2022-04-15 16:56:45'),
(10, 'jAN3Gxa7H522r1cq2YxDFmBkD6h1xX', 1, 1, 48, 'post', 0, 0, 1, '', 'Тестовая публикация с хэштегами.\r\n#тест #socialnetwork', '', '', '', 'ru', 1645119770, '2022-02-17 21:42:49', '2022-04-15 16:54:38');

-- --------------------------------------------------------

--
-- Структура таблицы `post_category_favourites`
--

CREATE TABLE IF NOT EXISTS `post_category_favourites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(3) NOT NULL,
  `uid` int(11) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '123411111',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `post_category_favourites`
--

INSERT INTO `post_category_favourites` (`id`, `category`, `uid`, `time`) VALUES
(2, 3, 1, 1647960552);

-- --------------------------------------------------------

--
-- Структура таблицы `post_emotions`
--

CREATE TABLE IF NOT EXISTS `post_emotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'like',
  `date_pub` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `post_emotions`
--

INSERT INTO `post_emotions` (`id`, `pid`, `uid`, `type`, `date_pub`) VALUES
(3, 4, 1, 'dislike', '2022-01-26 06:03:54'),
(4, 5, 1, 'like', '2022-01-26 06:04:40'),
(5, 6, 1, 'like', '2022-02-14 15:03:11'),
(6, 10, 1, 'like', '2022-03-20 18:11:12'),
(7, 10, 1, 'dislike', '2022-03-21 13:57:20');

-- --------------------------------------------------------

--
-- Структура таблицы `post_views`
--

CREATE TABLE IF NOT EXISTS `post_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `time` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `post_views`
--

INSERT INTO `post_views` (`id`, `uid`, `pid`, `time`) VALUES
(6, 1, 3, 1647784952),
(7, 1, 10, 1647856588),
(8, 1, 8, 1647875916),
(9, 1, 9, 1647910917);

-- --------------------------------------------------------

--
-- Структура таблицы `reports_comments`
--

CREATE TABLE IF NOT EXISTS `reports_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) NOT NULL DEFAULT 'spam',
  `date_reported` varchar(40) DEFAULT '1997-01-01 03:00:00',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `comment_id` varchar(11) NOT NULL DEFAULT '0',
  `comment_message` varchar(500) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `reports_post`
--

CREATE TABLE IF NOT EXISTS `reports_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) DEFAULT 'spam',
  `date_reported` varchar(40) DEFAULT '1997-01-01 03:00:00',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `message` varchar(100) DEFAULT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `post_message` varchar(500) DEFAULT NULL,
  `post_image1` varchar(500) DEFAULT NULL,
  `post_image2` varchar(500) DEFAULT NULL,
  `post_image3` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `reports_post`
--

INSERT INTO `reports_post` (`id`, `data`, `date_reported`, `user_id`, `message`, `post_id`, `post_message`, `post_image1`, `post_image2`, `post_image3`) VALUES
(1, 'scam', '1997-01-01 03:00:00', 1, 'Test message', 8, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `reports_user`
--

CREATE TABLE IF NOT EXISTS `reports_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data` varchar(30) DEFAULT 'spam',
  `message` varchar(200) DEFAULT NULL,
  `date_reported` varchar(30) NOT NULL DEFAULT '1997-01-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `reports_user`
--

INSERT INTO `reports_user` (`id`, `rep_id`, `user_id`, `data`, `message`, `date_reported`) VALUES
(1, 2, 1, 'scam', '', '2022-03-07 19:16:10');

-- --------------------------------------------------------

--
-- Структура таблицы `uploaded_files`
--

CREATE TABLE IF NOT EXISTS `uploaded_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `full_url` varchar(700) NOT NULL,
  `short_url` varchar(700) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'post',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Дамп данных таблицы `uploaded_files`
--

INSERT INTO `uploaded_files` (`id`, `uid`, `full_url`, `short_url`, `type`, `time`) VALUES
(4, 1, 'https://sun.qwaker.net/uploads/xianitt-MESSAGE-20220125131651-644339.png', '/uploads/xianitt-MESSAGE-20220125131651-644339.png', 'message_image1', '2022-01-25 09:16:51'),
(9, 1, 'https://sun.qwaker.net/uploads/xianitt-POST-20220125141257-827456.png', '/uploads/xianitt-POST-20220125141257-827456.png', 'post_image1', '2022-01-25 10:12:57'),
(10, 1, 'https://sun.qwaker.net/uploads/xianitt-POST-20220125141258-246563.png', '/uploads/xianitt-POST-20220125141258-246563.png', 'post_image2', '2022-01-25 10:12:58'),
(11, 1, 'https://sun.qwaker.net/uploads/xianitt-POST-20220125141259-830538.png', '/uploads/xianitt-POST-20220125141259-830538.png', 'post_image3', '2022-01-25 10:12:59'),
(21, 2, 'https://sun.qwaker.net/avatars/popis-20220307184422417444.jpg', '/avatars/popis-20220307184422417444.jpg', 'avatar', '2022-03-07 14:44:22'),
(25, 1, 'https://sun.qwaker.net/avatars/elinther-20220323020213819208.jpg', '/avatars/elinther-20220323020213819208.jpg', 'avatar', '2022-03-22 22:02:13');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(50) DEFAULT NULL,
  `interval_m` int(5) NOT NULL DEFAULT '10000',
  `limit_post` int(11) NOT NULL DEFAULT '200',
  `rang` int(2) NOT NULL DEFAULT '1' COMMENT '1 - пользователь, 2 - модератор, 3 - админ, 4 - разработчик',
  `type_auth` varchar(20) NOT NULL DEFAULT 'site',
  `nickname` varchar(40) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `avatar_small` varchar(200) DEFAULT NULL,
  `background` varchar(500) DEFAULT NULL,
  `about` varchar(150) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  `login` varchar(35) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT 'user',
  `password` varchar(200) NOT NULL,
  `url_site` varchar(50) DEFAULT NULL,
  `url_social` varchar(50) DEFAULT NULL,
  `url_phone` varchar(50) DEFAULT NULL,
  `url_email` varchar(50) DEFAULT NULL,
  `banned_mesage` varchar(100) DEFAULT 'Ваш аккаунт был заблокирован.',
  `email` varchar(100) DEFAULT NULL,
  `online` int(11) NOT NULL,
  `favourite_posts` varchar(100) DEFAULT '0, 999',
  `report_posts` tinyint(1) NOT NULL DEFAULT '1',
  `report_comments` tinyint(1) NOT NULL DEFAULT '1',
  `verification_type` varchar(20) NOT NULL DEFAULT 'popular',
  `verification` tinyint(1) NOT NULL DEFAULT '0',
  `email_authorization` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `scam` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `restore_password` tinyint(1) NOT NULL DEFAULT '1',
  `email_password` tinyint(1) NOT NULL DEFAULT '0',
  `find_me` tinyint(1) NOT NULL DEFAULT '1',
  `public_post` tinyint(1) NOT NULL DEFAULT '1',
  `chat_creating` tinyint(1) NOT NULL DEFAULT '1',
  `chat_joined` tinyint(1) NOT NULL DEFAULT '1',
  `chat_read` tinyint(1) NOT NULL DEFAULT '1',
  `chat_invite` tinyint(1) NOT NULL DEFAULT '1',
  `show_online` tinyint(1) NOT NULL DEFAULT '1',
  `show_url` tinyint(1) NOT NULL DEFAULT '0',
  `private_message` tinyint(1) NOT NULL DEFAULT '1',
  `hide_popup_rec` tinyint(1) NOT NULL DEFAULT '0',
  `date_banned` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `date_registration` varchar(30) NOT NULL,
  `date_upd_avatar` int(30) DEFAULT NULL,
  `date_upd_login` int(30) DEFAULT NULL,
  `date_upd_password` int(11) DEFAULT NULL,
  `date_upd_restore_password` int(11) DEFAULT NULL,
  `date_verification` varchar(30) DEFAULT NULL,
  `date_last_extract` int(30) NOT NULL,
  `date_last_send_code` int(30) NOT NULL,
  `date_last_restore_password` int(30) NOT NULL,
  `language` varchar(2) DEFAULT 'en',
  `email_restore_password_code` varchar(70) DEFAULT NULL,
  `email_authorization_code` varchar(70) DEFAULT NULL,
  `token` varchar(150) NOT NULL,
  `token_public` varchar(70) NOT NULL,
  `token_access` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `oauth_id`, `ip`, `interval_m`, `limit_post`, `rang`, `type_auth`, `nickname`, `name`, `avatar`, `avatar_small`, `background`, `about`, `status`, `login`, `password`, `url_site`, `url_social`, `url_phone`, `url_email`, `banned_mesage`, `email`, `online`, `favourite_posts`, `report_posts`, `report_comments`, `verification_type`, `verification`, `email_authorization`, `private`, `scam`, `banned`, `restore_password`, `email_password`, `find_me`, `public_post`, `chat_creating`, `chat_joined`, `chat_read`, `chat_invite`, `show_online`, `show_url`, `private_message`, `hide_popup_rec`, `date_banned`, `date_registration`, `date_upd_avatar`, `date_upd_login`, `date_upd_password`, `date_upd_restore_password`, `date_verification`, `date_last_extract`, `date_last_send_code`, `date_last_restore_password`, `language`, `email_restore_password_code`, `email_authorization_code`, `token`, `token_public`, `token_access`) VALUES
(1, 0, NULL, 10000, 20, 4, 'site', 'elinther', 'Александр Михно', 'https://sun.qwaker.net/avatars/elinther-20220323020213819208.jpg', 'https://sun.qwaker.net/avatars/elinther-20220323020213819208.jpg', NULL, '', 0, 'elinther', 'a854f6256c79595734d5c7799ed7c320', '', '', '', '', 'Ваш аккаунт был заблокирован.', 'steepdoctor@gmail.com', 1650046754, '0, 999', 1, 1, 'popular', 0, 1, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, '2022-03-07 09:51:32', '2022-01-25 10:29:39', 0, 1648458669, NULL, 1646727372, NULL, 1647786965, 1650018810, 1646727372, 'ru', NULL, NULL, 'WgHHdn6B5v3Bx2qbj2lpphikUxf2EgQRTQaM3JZz8Xys6NxMGh1LrxXYfA14HbYqVmJOK2', '4ee2238be52077c5d88d9e402b6f7200', NULL),
(2, 0, NULL, 10000, 20, 1, 'site', 'popis', '', 'https://sun.qwaker.net/avatars/popis-20220307184422417444.jpg', 'https://sun.qwaker.net/avatars/popis-20220307184422417444.jpg', NULL, NULL, 0, 'popis', '25d55ad283aa400af464c76d713c07ad', NULL, NULL, NULL, NULL, 'Ваш аккаунт был заблокирован.', NULL, 1646664259, '0, 999', 1, 1, 'popular', 1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, '1970-01-01 03:00:00', '2022-03-07 18:36:23', 0, 1646663783, NULL, NULL, NULL, 0, 0, 0, 'ru', NULL, NULL, 'L6cD3cGQGTNECJFG2OAsUddUATqPoyTeQyxU10Vkes4pHiJLSw0yhcR4RVvlUDY730Xq0U', '211d70290c19c2c5d1caed8a0dfa91fc', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `user_sessions`
--

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL DEFAULT 'site',
  `sid` varchar(100) NOT NULL,
  `uid` int(11) NOT NULL,
  `utoken` varchar(100) NOT NULL,
  `uagent` varchar(500) NOT NULL,
  `uip` varchar(40) NOT NULL,
  `time` int(30) NOT NULL,
  `lasttime` int(30) NOT NULL,
  `maxtime` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Дамп данных таблицы `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `type`, `sid`, `uid`, `utoken`, `uagent`, `uip`, `time`, `lasttime`, `maxtime`) VALUES
(14, 'site', 'LroJATkKGMoI49uLGLIBfty3Qsd5m1grMZTtpCnt5cs59PVe8ZlVKjky2kj7qyBBTcX1Nh', 2, '211d70290c19c2c5d1caed8a0dfa91fc', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36', '127.0.0.1', 1646663791, 1646664154, 1646979091),
(19, 'site', 'Dh8ihTEKohkdxelKt3gzbrdiPkWDn3PVNnzn93rLAEjKIZ90aV7XXJxZ95cnN6mrixoLx5', 1, '4ee2238be52077c5d88d9e402b6f7200', 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko) Version/10.0 Mobile/14E304 Safari/602.1', '127.0.0.1', 1647945528, 1650018754, 1648260828),
(20, 'site', 'A9Hqw5zKavRPM4DlF5jEfPBujzP0JkQDeuvFAHku7eb24RsitwZwkRMgQYT6kkBASFW3sy', 1, '4ee2238be52077c5d88d9e402b6f7200', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36', '128.0.0.1', 1650018846, 1650045979, 1650334146);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
