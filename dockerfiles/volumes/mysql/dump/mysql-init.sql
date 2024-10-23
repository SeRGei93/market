CREATE DATABASE IF NOT EXISTS `dev`;
CREATE DATABASE IF NOT EXISTS `dev_test`;

CREATE USER IF NOT EXISTS 'dev'@'%' IDENTIFIED BY '12345678';

GRANT ALL PRIVILEGES ON `dev`.* TO 'dev'@'%';
GRANT ALL PRIVILEGES ON `dev_test`.* TO 'dev'@'%';

GRANT SELECT  ON `information\_schema`.* TO 'dev'@'%';
FLUSH PRIVILEGES;

SET GLOBAL time_zone = 'Europe/Minsk';
