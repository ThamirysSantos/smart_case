--  create databases
CREATE DATABASE IF NOT EXISTS `smart_case`;

-- create local_developer user and grant rights
CREATE USER 'dev'@'db' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON *.* TO 'dev'@'%';
FLUSH PRIVILEGES;
