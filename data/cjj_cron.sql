/*
Navicat MySQL Data Transfer

Source Server         : 192.168.2.253内网开发--cjj
Source Server Version : 50549
Source Host           : 192.168.2.253:3306
Source Database       : cjj

Target Server Type    : MYSQL
Target Server Version : 50549
File Encoding         : 65001

Date: 2016-08-18 11:26:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cjj_cron`
-- ----------------------------
DROP TABLE IF EXISTS `cjj_cron`;
CREATE TABLE `cjj_cron` (
  `pk_cr` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '计划任务ID',
  `cr_type` tinyint(2) DEFAULT '0' COMMENT '计划任务类型',
  `cr_subject` varchar(50) NOT NULL DEFAULT '' COMMENT '计划任务名称',
  `cr_loop_type` varchar(10) NOT NULL DEFAULT '' COMMENT '循环类型month/week/day/hour/now',
  `cr_loop_daytime` varchar(50) NOT NULL DEFAULT '' COMMENT '循环类型时间（日-时-分）',
  `cr_file` varchar(50) NOT NULL DEFAULT '' COMMENT '计划任务执行文件',
  `cr_isopen` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否开启 0 否，1是，2系统任务',
  `cr_modified_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '计划任务上次执行结束时间',
  `cr_next_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下一次执行时间',
  `cr_data` text COMMENT '数据',
  PRIMARY KEY (`pk_cr`),
  KEY `idx_next_time` (`cr_next_time`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='计划任务表';

-- ----------------------------
-- Records of cjj_cron
-- ----------------------------
INSERT INTO `cjj_cron` VALUES ('2', '0', '学习记录统计计划任务', 'now', '0-0-5', 'RecordRankingTask', '1', '1468731816', '1468732080', '');
INSERT INTO `cjj_cron` VALUES ('4', '0', '学习记录进度', 'now', '0-0-5', 'LearningRecordTask', '1', '1468731816', '1468732080', '');
INSERT INTO `cjj_cron` VALUES ('6', '0', '视频转码后', 'now', '0-0-5', 'VideoTranscodeTask', '1', '1468731991', '1468732260', '');
INSERT INTO `cjj_cron` VALUES ('8', '0', 'scapi', 'now', '0-0-1', 'ScApiTask', '0', '1409556901', '1409556960', null);
INSERT INTO `cjj_cron` VALUES ('9', '0', '学校资料导入', 'now', '0-0-1', 'AgencyDataImportTask', '1', '1468731991', '1468732020', null);
INSERT INTO `cjj_cron` VALUES ('12', '0', 'agapi', 'now', '0-0-5', 'AgApiTask', '1', '1468731816', '1468732080', null);

-- ----------------------------
-- Table structure for `cjj_cron_log`
-- ----------------------------
DROP TABLE IF EXISTS `cjj_cron_log`;
CREATE TABLE `cjj_cron_log` (
  `pk_crlog` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '计划任务日志ID',
  `cr_id` int(10) NOT NULL COMMENT '计划任务ID',
  `cr_file` varchar(50) NOT NULL COMMENT '计划任务执行文件',
  `crlog_message` text NOT NULL COMMENT '执行内容',
  `crlog_add_time` int(10) NOT NULL COMMENT '执行时间',
  PRIMARY KEY (`pk_crlog`)
) ENGINE=MyISAM AUTO_INCREMENT=769370 DEFAULT CHARSET=utf8 COMMENT='计划任务日志表';

-- ----------------------------
-- Records of cjj_cron_log
-- ----------------------------
