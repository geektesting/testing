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

-- Дамп структуры для таблица testing.quizes
CREATE TABLE IF NOT EXISTS `quizes` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `cat` int(4) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `hidden` varchar(10) DEFAULT NULL,
  `settings` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='Таблица тестов';

-- Дамп данных таблицы testing.quizes: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `quizes` DISABLE KEYS */;
INSERT INTO `quizes` (`id`, `user_id`, `name`, `description`, `cat`, `status`, `hidden`, `settings`) VALUES
	(10, 1, 'Простой уровень', 'Тарам пам', 11, 0, '4785b3da7a', _binary 0x613A353A7B733A383A22697352616E646F6D223B693A303B733A393A227061737353636F7265223B643A37303B733A343A2274696D65223B693A33303B733A373A2274696D65476170223B693A323B733A393A227175657374696F6E73223B613A313A7B693A333B733A323A223330223B7D7D),
	(11, 1, 'Средний уровень', 'Уровень средней сложности', 11, 1, 'ff3cc54249', _binary 0x613A353A7B733A383A22697352616E646F6D223B693A303B733A393A227061737353636F7265223B643A35303B733A343A2274696D65223B693A31303B733A373A2274696D65476170223B693A353B733A393A227175657374696F6E73223B613A323A7B693A353B733A323A223330223B693A333B733A333A22313030223B7D7D);
/*!40000 ALTER TABLE `quizes` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
