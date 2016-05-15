/*
Navicat MySQL Data Transfer

Source Server         : nzri.ir_3306
Source Server Version : 50544
Source Host           : nzri.ir:3306
Source Database       : quizup

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-05-15 20:08:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for country
-- ----------------------------
DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of country
-- ----------------------------
INSERT INTO `country` VALUES ('1', 'Iran');
INSERT INTO `country` VALUES ('2', 'United States');

-- ----------------------------
-- Table structure for question
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `description` text NOT NULL,
  `ans1` text NOT NULL,
  `ans2` text NOT NULL,
  `ans3` text NOT NULL,
  `ans4` text NOT NULL,
  `correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`qid`),
  KEY `question_to_category` (`cid`),
  CONSTRAINT `question_to_category` FOREIGN KEY (`cid`) REFERENCES `question_category` (`cid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('1', '1', 'جواب درست این سوال 1 است', '1', '2', '3', '4', '1');
INSERT INTO `question` VALUES ('2', '1', 'جواب درست این سوال 2 است', '1', '2', '3', '4', '2');
INSERT INTO `question` VALUES ('3', '1', 'جواب درست این سوال 3 است', '1', '2', '4', '3', '3');
INSERT INTO `question` VALUES ('4', '1', 'جواب درست این سوال 4 است', '4', '1', '3', '2', '4');
INSERT INTO `question` VALUES ('5', '1', 'جواب درست این سوال 5 است', '1', '4', '2', '3', '1');

-- ----------------------------
-- Table structure for question_category
-- ----------------------------
DROP TABLE IF EXISTS `question_category`;
CREATE TABLE `question_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `question_category_to_user` (`user_id`),
  CONSTRAINT `question_category_to_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question_category
-- ----------------------------
INSERT INTO `question_category` VALUES ('1', 'اسلام', '2');
INSERT INTO `question_category` VALUES ('2', 'ادبیات', '2');
INSERT INTO `question_category` VALUES ('3', 'هنر', '2');
INSERT INTO `question_category` VALUES ('4', 'تجربه', '2');

-- ----------------------------
-- Table structure for quiz
-- ----------------------------
DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `question1` int(11) NOT NULL,
  `question2` int(11) NOT NULL,
  `question3` int(11) NOT NULL,
  `question4` int(11) NOT NULL,
  `question5` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `user1_state` enum('CREATED','QUESTION_1','QUESTION_2','QUESTION_3','QUESTION_4','QUESTION_5','FINISHED') NOT NULL DEFAULT 'CREATED',
  `user2_state` enum('CREATED','QUESTION_1','QUESTION_2','QUESTION_3','QUESTION_4','QUESTION_5','FINISHED') NOT NULL DEFAULT 'CREATED',
  `user1_correct_answers_count` tinyint(2) NOT NULL DEFAULT '0',
  `user2_correct_answers_count` tinyint(2) NOT NULL DEFAULT '0',
  `user1_earned_points` int(11) NOT NULL DEFAULT '0',
  `user2_earned_points` int(11) NOT NULL DEFAULT '0',
  `user1_step_last_update` datetime NOT NULL,
  `user2_step_last_update` datetime NOT NULL,
  PRIMARY KEY (`qid`),
  KEY `quiz_to_category` (`cid`),
  KEY `quiz_to_first_question` (`question1`),
  KEY `quiz_to_third_question` (`question3`),
  KEY `quit_to_fourth_question` (`question4`),
  KEY `quit_to_fifth_question` (`question5`),
  KEY `quiz_to_second_question` (`question2`) USING BTREE,
  KEY `quiz_to_first_user` (`user1_id`),
  KEY `quiz_to_second_user` (`user2_id`),
  CONSTRAINT `quit_to_fifth_question` FOREIGN KEY (`question5`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quit_to_fourth_question` FOREIGN KEY (`question4`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_category` FOREIGN KEY (`cid`) REFERENCES `question_category` (`cid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_first_question` FOREIGN KEY (`question1`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_second_question` FOREIGN KEY (`question2`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_third_question` FOREIGN KEY (`question3`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quiz
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `family` varchar(255) NOT NULL,
  `gender` enum('MALE','FEMALE') NOT NULL DEFAULT 'MALE',
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `verification_code` char(64) DEFAULT NULL,
  `cid` int(11) NOT NULL,
  `points` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_emails` (`email`) USING HASH,
  KEY `user_to_country` (`cid`),
  CONSTRAINT `user_to_country` FOREIGN KEY (`cid`) REFERENCES `country` (`cid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'mohammad.nazari92@gmail.com', 'محمد', 'نظری', 'MALE', '123456', '1', null, '1', '74');
INSERT INTO `user` VALUES ('3', 'ch1cksh1ck7@gmail.com', 'ممد', 'نظر', 'MALE', '123456', '1', null, '1', '68');
INSERT INTO `user` VALUES ('4', 'maxsan2010@gmail.com', 'dani', 'kh', 'MALE', '123456', '1', 'btoche', '1', '25');
INSERT INTO `user` VALUES ('5', 'peymanzeynali@yahoo.com', 'پیمان', 'زینلی', 'MALE', '1234567', '1', '6e019568971056eb79324d38538d9eb4', '1', '0');
INSERT INTO `user` VALUES ('6', 'farzad.11173@yahoo.com', 'فری', 'مستر :دی', 'MALE', '123456', '1', '9194696d06edd962af9392bf9ee2792e', '2', '6');
INSERT INTO `user` VALUES ('7', 'm.j.izadi@gmail.com', 'mj', 'izadi', 'MALE', '123456', '1', '1', '1', '13');
INSERT INTO `user` VALUES ('9', 'sobhanganji@gmail.com', 'Sobhan', 'Ganji', 'MALE', '1s1s1s1s', '0', '35c2430a59a8acce8519aa341b0cc2fe', '1', '0');
