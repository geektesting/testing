-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.1.25-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win32
-- HeidiSQL Версия:              9.4.0.5174
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица oleg_bolden.cats
CREATE TABLE IF NOT EXISTS `cats` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) DEFAULT NULL,
  `parent` int(3) DEFAULT NULL,
  `description` text,
  `level` int(3) NOT NULL DEFAULT '0',
  `access` int(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `approved` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='Категории рубрикатора';

-- Дамп данных таблицы oleg_bolden.cats: ~15 rows (приблизительно)
/*!40000 ALTER TABLE `cats` DISABLE KEYS */;
INSERT INTO `cats` (`id`, `cat_name`, `parent`, `description`, `level`, `access`, `user_id`, `approved`) VALUES
	(1, 'Частные категории', 0, NULL, 0, 1, 1, 1),
	(2, 'Химия', 0, NULL, 0, 1, 1, 1),
	(3, 'PHP', 8, NULL, 1, 1, 1, 1),
	(4, 'Laravel', 11, NULL, 3, 0, 2, 1),
	(5, 'GeekBrains', 1, NULL, 1, 1, 2, 1),
	(6, 'Неорганическая', 2, NULL, 1, 1, 1, 1),
	(7, 'Аналитическая', 2, NULL, 1, 1, 1, 1),
	(8, 'Программирование', 0, NULL, 0, 1, 1, 1),
	(9, 'Java', 5, NULL, 2, 1, 2, 1),
	(10, 'JavaScript', 5, NULL, 2, 1, 2, 1),
	(11, 'PHP', 5, NULL, 2, 1, 2, 1),
	(12, 'Органическая', 2, NULL, 1, 1, 1, 1),
	(13, 'Шурум-бурум', 5, NULL, 2, 1, 2, -1),
	(14, 'JavaScript', 8, NULL, 1, 1, 1, 1),
	(15, 'Yii2', 11, NULL, 3, 0, 2, 1);
/*!40000 ALTER TABLE `cats` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
