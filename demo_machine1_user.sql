-- Adminer 4.3.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `demo_machine1_user`;
CREATE TABLE `demo_machine1_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `phone` varchar(11) NOT NULL COMMENT '手机号码',
  `sex` int(11) NOT NULL COMMENT '性别 1男2女3其他',
  `pass` varchar(32) NOT NULL COMMENT '密码 md5(salt+md5(pass)_phone)',
  `add_time` datetime NOT NULL COMMENT '添加时间',
  `login_time` datetime NOT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2018-02-27 13:22:54
