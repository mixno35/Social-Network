-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 07 2021 г., 00:20
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oauth_id` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(50) DEFAULT NULL,
  `interval_m` int(5) NOT NULL DEFAULT '10000',
  `limit_post` int(11) NOT NULL DEFAULT '20',
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
  `find_me` tinyint(1) NOT NULL DEFAULT '1',
  `public_post` tinyint(1) NOT NULL DEFAULT '1',
  `chat_creating` tinyint(1) NOT NULL DEFAULT '1',
  `chat_joined` tinyint(1) NOT NULL DEFAULT '1',
  `chat_read` tinyint(1) NOT NULL DEFAULT '1',
  `show_online` tinyint(1) NOT NULL DEFAULT '1',
  `show_url` tinyint(1) NOT NULL DEFAULT '0',
  `private_message` tinyint(1) NOT NULL DEFAULT '1',
  `date_banned` varchar(30) NOT NULL DEFAULT '1970-01-01 03:00:00',
  `date_registration` varchar(30) NOT NULL,
  `date_upd_avatar` int(30) DEFAULT NULL,
  `date_upd_login` int(30) DEFAULT NULL,
  `date_upd_password` int(11) DEFAULT NULL,
  `date_upd_restore_password` int(11) DEFAULT NULL,
  `date_verification` varchar(30) DEFAULT NULL,
  `language` varchar(2) DEFAULT 'en',
  `email_restore_password_code` varchar(70) DEFAULT NULL,
  `email_authorization_code` varchar(70) DEFAULT NULL,
  `token` varchar(150) NOT NULL,
  `token_public` varchar(70) NOT NULL,
  `token_access` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `time` int(11) NOT NULL,
  `lasttime` int(11) NOT NULL,
  `maxtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
