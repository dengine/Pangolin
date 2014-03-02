/*!40101 SET NAMES utf8 */;

--
-- База данных: `pangolin_blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `announcement` varchar(250) NOT NULL,
  `created` datetime NOT NULL,
  `meta_key` varchar(250) NOT NULL,
  `meta_des` varchar(250) NOT NULL,
  `author` int(11) unsigned NOT NULL,
  `content` mediumtext NOT NULL,
  `thumbnail` varchar(170) NOT NULL,
  `preview` varchar(170) NOT NULL,
  PRIMARY KEY (`post_id`,`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(70) NOT NULL,
  `hashpass` varchar(250) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
