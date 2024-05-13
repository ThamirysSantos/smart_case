-- create database
CREATE DATABASE IF NOT EXISTS `smart_case`;

-- create local_developer user and grant rights
ALTER USER 'root'@'db' IDENTIFIED BY 'secret';
