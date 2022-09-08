/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 5.0.51b-community-nt-log : Database - _receipt_vat
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`_receipt_vat` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `_receipt_vat`;

/*Table structure for table `receipt_other` */

DROP TABLE IF EXISTS `receipt_other`;

CREATE TABLE `receipt_other` (
  `id` int(11) NOT NULL auto_increment,
  `id_upload_type` int(11) default NULL,
  `fullname` varchar(255) default NULL,
  `position` varchar(255) default NULL,
  `id_card` varchar(13) default NULL,
  `amount` varchar(255) default NULL,
  `vat` varchar(255) default NULL,
  `total` varchar(255) default NULL,
  `name_bank` varchar(255) default NULL,
  `acc_num` varchar(255) default NULL,
  `pay_date` date default NULL,
  `imp_date` timestamp NULL default CURRENT_TIMESTAMP,
  `MED_UPLOAD` varchar(255) default NULL,
  `date_update` timestamp NULL default NULL,
  `MED_UPDATE` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29171 DEFAULT CHARSET=utf8;

/*Table structure for table `sarary` */

DROP TABLE IF EXISTS `sarary`;

CREATE TABLE `sarary` (
  `id` mediumint(9) NOT NULL auto_increment,
  `date_imp` date NOT NULL COMMENT 'วันที่เพิ่มรายการ',
  `id_card` varchar(13) NOT NULL COMMENT 'เลขบัตรประชาชน',
  `sarary` varchar(50) NOT NULL COMMENT 'เงินเดือน',
  `col` varchar(50) NOT NULL COMMENT 'ค่าครองชีพ',
  `sumPlus` varchar(50) NOT NULL COMMENT 'รวมรายรับ',
  `vat` varchar(50) NOT NULL COMMENT 'ภาษี',
  `social_secure` varchar(50) NOT NULL COMMENT 'ประกันสังคม',
  `provident_fund` varchar(50) NOT NULL COMMENT 'กองทุนสำรองฯ',
  `sloan_fund` varchar(50) NOT NULL COMMENT 'กยศ./กรอ.',
  `cooperative` varchar(50) NOT NULL COMMENT 'สหกรณ์',
  `net` varchar(50) NOT NULL COMMENT 'รายรับสุทธิ',
  `acc_num` varchar(50) NOT NULL COMMENT 'เลขที่บัญชี',
  `name_bank` varchar(50) NOT NULL COMMENT 'ธนาคาร',
  `date_Pay` date default NULL COMMENT 'วันที่จ่ายเงิน',
  `date_update` datetime default NULL COMMENT 'วันอัพเดตข้อมูล',
  `MED_UPDATE` varchar(255) default NULL COMMENT 'ผู้อัพเดตข้อมูล',
  `MED_UPLOAD` varchar(255) default NULL COMMENT 'ผู้อัพโหลดเริ่มต้น',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10251 DEFAULT CHARSET=utf8;

/*Table structure for table `upload_type` */

DROP TABLE IF EXISTS `upload_type`;

CREATE TABLE `upload_type` (
  `id_upload_type` int(11) NOT NULL auto_increment,
  `topic` varchar(255) default NULL,
  PRIMARY KEY  (`id_upload_type`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
