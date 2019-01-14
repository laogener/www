/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : edus

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-01-14 22:51:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for grade
-- ----------------------------
DROP TABLE IF EXISTS `grade`;
CREATE TABLE `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `length` varchar(120) NOT NULL,
  `price` int(10) NOT NULL,
  `status` int(1) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `is_delete` int(1) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grade
-- ----------------------------
INSERT INTO `grade` VALUES ('3', 'PHP开发一班', '4个月', '25000', '1', '1516508582', '1516612217', '1', null);
INSERT INTO `grade` VALUES ('4', 'PHP开发2班', '4个月', '25000', '1', '1516526357', '1516633091', '1', null);
INSERT INTO `grade` VALUES ('5', 'WEB开发一班', '4个月', '20000', '1', '1516526357', '1516549091', '1', null);
INSERT INTO `grade` VALUES ('6', 'Java开发1班', '8个月', '30000', '1', '1516526506', '1516549091', '1', null);
INSERT INTO `grade` VALUES ('7', 'PHP开发三班', '5个月', '25000', '1', '1516613137', '1516613137', '1', null);

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL,
  `name` varchar(120) NOT NULL,
  `sex` int(1) NOT NULL,
  `age` int(2) NOT NULL,
  `tel` varchar(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `start_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `is_delete` int(1) NOT NULL,
  `grade_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('1', '1', '杨过', '0', '19', '18637786883', 'yangguo@qq.com', '1516636800', '1516697048', '1516712247', null, '1', '7');
INSERT INTO `student` VALUES ('2', '1', '小龙女', '1', '19', '18637786887', 'xiaolongnv@qq.com', '1514736000', '1516708363', '1516708363', null, '1', '6');

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `education` int(1) NOT NULL,
  `school` varchar(120) NOT NULL,
  `tel` varchar(11) NOT NULL,
  `hire_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `delete_time` int(11) DEFAULT NULL,
  `is_delete` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `grade_id` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('1', '张老师', '2', '东南大学', '18637786881', '1516528479', '1516685591', '1516528479', null, '1', '1', '7');
INSERT INTO `teacher` VALUES ('2', '杨老师', '1', '北京大学', '18637786881', '1515427200', '1516695728', '1516695666', null, '1', '1', '7');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `name` varchar(255) DEFAULT NULL COMMENT '管理员账号',
  `password` varchar(255) DEFAULT NULL COMMENT '管理员密码',
  `email` varchar(255) DEFAULT NULL COMMENT '管理员邮箱',
  `role` tinyint(2) DEFAULT NULL COMMENT '角色：1，超级管理员；0，管理员',
  `status` int(2) DEFAULT NULL COMMENT '状态：1启用0禁用',
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `login_count` int(11) DEFAULT NULL COMMENT '登录次数',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_delete` int(2) DEFAULT NULL COMMENT '是否删除：1是0否',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'admin@qq.com', '1', '1', '1516712141', '31', '1501493848', '1516712141', null, '1');
INSERT INTO `user` VALUES ('4', 'admin1', 'c56d0e9a7ccec67b4ea131655038d604', 'admin11@qq.com', '1', '1', '1516441530', '5', '1516440262', '1516631009', null, '1');
INSERT INTO `user` VALUES ('5', 'admin2', 'e10adc3949ba59abbe56e057f20f883e', 'admin2@qq.com', '0', '1', null, '0', '1516440332', '1516440332', null, '1');
INSERT INTO `user` VALUES ('7', 'admin3', 'e10adc3949ba59abbe56e057f20f883e', 'admin3@qq.com', '0', '1', null, '0', '1516440455', '1516440455', null, '1');
INSERT INTO `user` VALUES ('8', 'admin4', 'e10adc3949ba59abbe56e057f20f883e', 'admin4@qq.com', '0', '1', '1516712868', '2', '1516440527', '1516712868', null, '1');
SET FOREIGN_KEY_CHECKS=1;
