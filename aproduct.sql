/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100413
 Source Host           : localhost:3306
 Source Schema         : paserpast

 Target Server Type    : MySQL
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 30/08/2020 05:36:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aproduct
-- ----------------------------
DROP TABLE IF EXISTS `aproduct`;
CREATE TABLE `aproduct`  (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `endtime` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `imgurl` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `siteurl` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `bidprice` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `casktype` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `region` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `strength` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `condition` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `filllevel` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
