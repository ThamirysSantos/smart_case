-- create database
CREATE DATABASE IF NOT EXISTS `smart_case`;

-- create local_developer user and grant rights
CREATE USER 'dev'@'db' IDENTIFIED WITH mysql_native_password BY 'secret';
GRANT ALL PRIVILEGES ON .* TO 'dev'@'%';
