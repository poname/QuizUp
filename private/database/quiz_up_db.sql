/*
Navicat MySQL Data Transfer

Source Server         : nzri.ir_3306
Source Server Version : 50544
Source Host           : nzri.ir:3306
Source Database       : quizup

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-03-31 05:24:06
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of question_category
-- ----------------------------

-- ----------------------------
-- Table structure for quiz
-- ----------------------------
DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `state` enum('CREATED','PLAYER_1_STARTED','PLAYER_1_FINISHED','PLAYER_2_STARTED','PLAYER_2_FINISHED','FINISHED') NOT NULL DEFAULT 'CREATED',
  `cid` int(11) NOT NULL,
  `question1` int(11) NOT NULL,
  `question2` int(11) NOT NULL,
  `question3` int(11) NOT NULL,
  `question4` int(11) NOT NULL,
  `question5` int(11) NOT NULL,
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  PRIMARY KEY (`qid`),
  KEY `quiz_to_category` (`cid`),
  KEY `quiz_to_first_question` (`question1`),
  KEY `quiz_to_third_question` (`question3`),
  KEY `quit_to_fourth_question` (`question4`),
  KEY `quit_to_fifth_question` (`question5`),
  KEY `quiz_to_second_question` (`question2`) USING BTREE,
  KEY `quiz_to_first_user` (`user_id1`),
  KEY `quiz_to_second_user` (`user_id2`),
  CONSTRAINT `quit_to_fifth_question` FOREIGN KEY (`question5`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quit_to_fourth_question` FOREIGN KEY (`question4`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_category` FOREIGN KEY (`cid`) REFERENCES `question_category` (`cid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_first_question` FOREIGN KEY (`question1`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_first_user` FOREIGN KEY (`user_id1`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_second_question` FOREIGN KEY (`question2`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_second_user` FOREIGN KEY (`user_id2`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `quiz_to_third_question` FOREIGN KEY (`question3`) REFERENCES `question` (`qid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------

