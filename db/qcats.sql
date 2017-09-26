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

-- Дамп структуры для таблица oleg_bolden.qcats
CREATE TABLE IF NOT EXISTS `qcats` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(50) DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Категории рубрикатора';

-- Дамп данных таблицы oleg_bolden.qcats: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `qcats` DISABLE KEYS */;
INSERT INTO `qcats` (`id`, `cat_name`, `user_id`) VALUES
	(1, 'PHP-1. Строки', 1),
	(2, 'PHP-1. Массивы', 1),
	(3, 'PHP-1. Основы ООП', 1),
	(4, 'JS-2. Строки', 2),
	(5, 'JS-2. Массивы', 2),
	(6, 'JS-2. Основы ООП', 2);
/*!40000 ALTER TABLE `qcats` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
