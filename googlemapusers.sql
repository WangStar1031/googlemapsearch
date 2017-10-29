# Host: localhost  (Version 5.5.5-10.1.19-MariaDB)
# Date: 2017-10-28 10:08:14
# Generator: MySQL-Front 6.0  (Build 1.121)


#
# Structure for table "userinfo"
#

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Lat` float DEFAULT NULL,
  `Lang` float DEFAULT NULL,
  `UpdatedTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "userinfo"
#

INSERT INTO `userinfo` VALUES (1,'test1','test1@gmail.com','password',-33.8698,151.226,'2017-10-28 07:48:20'),(2,'test2','test2@gmail.com','password2',-34,-152,'2017-10-28 09:44:58'),(3,'test3','test3@gmail.com','password3',NULL,NULL,NULL);
