-- create database
CREATE DATABASE IF NOT EXISTS `smart_case`;

-- create local_developer user and grant rights
CREATE USER 'smart_case'@'db' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON *.* TO 'smart_case'@'%';
