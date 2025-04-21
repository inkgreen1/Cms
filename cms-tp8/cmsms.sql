# Host: localhost  (Version: 5.7.26)
# Date: 2024-09-22 23:57:11
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ms_admin"
#

DROP TABLE IF EXISTS `ms_admin`;
CREATE TABLE `ms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `nickname` varchar(20) DEFAULT '' COMMENT '用户名',
  `phone` varchar(11) DEFAULT '' COMMENT '手机号',
  `avatar` varchar(255) DEFAULT '' COMMENT '头像',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限组id',
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `updatetime` bigint(16) DEFAULT NULL COMMENT '更新时间',
  `lastlogintime` bigint(16) DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='管理员用户';

#
# Data for table "ms_admin"
#

/*!40000 ALTER TABLE `ms_admin` DISABLE KEYS */;
INSERT INTO `ms_admin` VALUES (1,'admin','$2y$10$nHPIpw6MDpkFH139lPlRze/9fEC2qAddhKWcJtT0VMNmFYUpJmhoq','猫叔maoshu','13730925241','http://127.0.0.1:8000/storage\\default/20240903\\38c6cd228e298f1563d12d0dd9696d15.png',1,NULL,1725523375,1724220622),(5,'maoshu111','','maoshu111','','',1,1724508334,1724508334,NULL),(6,'admin3','$2y$10$EDpC/WiB62hQYLRmUgKVFOSVgV2WirGshef61KBlgKaQhuVMC0S4K','编辑人员','','',5,1724508423,1725867756,NULL),(7,'admin2','$2y$10$wl8rkUSi7DHnMwCS1O6/vO095YOJ4W3mikoab.VlPaiziqpTPA8T2','二级管理','','',2,1724508428,1725867687,NULL),(9,'admin21','$2y$10$kREkAuWtZQ0Vx9Es9aLrSeya6pgCM.uo4yJRlpRgy.bMGaWclUkTK','分类管理员','','',3,1725348222,1725867747,NULL);
/*!40000 ALTER TABLE `ms_admin` ENABLE KEYS */;

#
# Structure for table "ms_adminlog"
#

DROP TABLE IF EXISTS `ms_adminlog`;
CREATE TABLE `ms_adminlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id',
  `url` varchar(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '操作Url',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '日志标题',
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '请求数据',
  `ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'IP',
  `useragent` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT 'UA',
  `createtime` bigint(16) unsigned DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "ms_adminlog"
#

/*!40000 ALTER TABLE `ms_adminlog` DISABLE KEYS */;
INSERT INTO `ms_adminlog` VALUES (1,0,'/admin/adminuser/list','title','[]','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727018789),(2,1,'/admin/adminuser/list','title','{\"filter\":[],\"page\":1,\"limit\":15}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727018790),(3,1,'/admin/adminuser/list','title','{\"filter\":[],\"page\":1,\"limit\":15}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727018843),(4,1,'/admin/content/del','title','{\"id\":8}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727018934),(5,1,'/admin/content/edit','title','{\"title\":\"\\u6d4b\\u8bd5\\u6807\\u989823\",\"subtitle\":\"\\u6d4b\\u8bd5\\u6807\\u989823\\u6d4b\\u8bd5\\u6807\\u989823\\u6d4b\\u8bd5\\u6807\\u989823\",\"coverimage\":\"http:\\/\\/127.0.0.1:8000\\/storage\\\\coverimage\\/20240916\\\\5d698e42eba0d0953a4de6cbf2cc4114.png\",\"category_id\":2,\"tag\":[\"\\u6d4b\\u8bd5\",\"php\"],\"author\":\"\",\"desc\":\"\",\"content\":\"\",\"status\":1,\"id\":12}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727019279),(6,1,'/admin/content/edit','内容管理 - 修改','{\"title\":\"\\u6d4b\\u8bd5\\u6807\\u989823\",\"subtitle\":\"\\u6d4b\\u8bd5\\u6807\\u989823\\u6d4b\\u8bd5\\u6807\\u989823\\u6d4b\\u8bd5\\u6807\\u989823\",\"coverimage\":\"http:\\/\\/127.0.0.1:8000\\/storage\\\\coverimage\\/20240916\\\\5d698e42eba0d0953a4de6cbf2cc4114.png\",\"category_id\":2,\"tag\":[\"\\u6d4b\\u8bd5\",\"php\"],\"author\":\"\",\"desc\":\"\",\"content\":\"\",\"status\":1,\"id\":12}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727019384),(7,1,'/admin/content/del','内容管理 - 删除','{\"id\":2}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727019396),(8,1,'/admin/content/changeaudit','内容管理 - 审核','{\"id\":10,\"audit\":2,\"reason\":\"\\u6d4b\\u8bd5\"}','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727019408);
/*!40000 ALTER TABLE `ms_adminlog` ENABLE KEYS */;

#
# Structure for table "ms_category"
#

DROP TABLE IF EXISTS `ms_category`;
CREATE TABLE `ms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `updatetime` bigint(16) DEFAULT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父分类',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `desc` varchar(255) DEFAULT '' COMMENT '分类描述',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员用户';

#
# Data for table "ms_category"
#

/*!40000 ALTER TABLE `ms_category` DISABLE KEYS */;
INSERT INTO `ms_category` VALUES (1,NULL,NULL,0,'php','php相关知识'),(2,NULL,NULL,0,'python','python知识'),(3,NULL,NULL,0,'js','js相关知识'),(4,NULL,1724219649,1,'think','tp8'),(13,1724220622,1725868605,3,'vue','1112'),(14,1724220633,1724220633,3,'node',''),(39,1725897662,1725897662,0,'java','111');
/*!40000 ALTER TABLE `ms_category` ENABLE KEYS */;

#
# Structure for table "ms_content"
#

DROP TABLE IF EXISTS `ms_content`;
CREATE TABLE `ms_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `updatetime` bigint(16) DEFAULT NULL COMMENT '更新时间',
  `deletetime` bigint(16) DEFAULT NULL COMMENT '删除时间',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '内容标题',
  `subtitle` varchar(50) DEFAULT '' COMMENT '副标题',
  `coverimage` varchar(100) DEFAULT '' COMMENT '缩略图',
  `category_id` int(11) DEFAULT NULL COMMENT '分类id',
  `tag` varchar(255) DEFAULT '' COMMENT '标签',
  `author` varchar(20) DEFAULT '' COMMENT '作者',
  `clicknum` int(11) NOT NULL DEFAULT '0' COMMENT '点击量',
  `desc` varchar(255) DEFAULT '' COMMENT '描述',
  `content` text COMMENT '内容',
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '状态：1=展示，0=隐藏',
  `audit` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '审核：2=已拒绝，1=已审核，0=待审核',
  `admin_id` int(11) DEFAULT NULL COMMENT '发布者',
  `reason` varchar(100) DEFAULT NULL COMMENT '拒绝原因',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员用户';

#
# Data for table "ms_content"
#

/*!40000 ALTER TABLE `ms_content` DISABLE KEYS */;
INSERT INTO `ms_content` VALUES (1,1726484293,1726451349,NULL,'测试猫叔1111测试猫叔','1231212121测试猫叔测试猫叔测试猫叔','http://127.0.0.1:8000/storage\\coverimage/20240916\\aeeeab6ed50cb8b128fc248505658266.png',3,'编程,php,js','maoshu',100,'测试描述','# 大标题\n## 测试标题2\n### 测试标题3\n#### 测试标题4\n\n![猫鼻子.png](http://127.0.0.1:8000/storage\\default/20240829\\081ab46a562b9f52976d824534c0a473.png)![猫眼睛.png](http://127.0.0.1:8000/storage\\default/20240829\\aea67fe5f05908b43283e3f811dca324.png)','1','1',NULL,NULL),(2,1725444293,1727019396,1727019396,'1111112222','222222222222222222222','',2,'ceshi1,test2,maoshu3','32',0,'231','12121','0','2',NULL,'12121'),(3,1726644293,1726447595,NULL,'测试标题2223','测试测试测试测试33333测试测试测试测试33333测试测试测试测试33333','http://127.0.0.1:8000/storage\\coverimage/20240916\\33ea6aa9bf807f1d47ba1ce63ce07318.png',4,'thinkphp','121',10,'2121','猫叔66621212121212121','1','1',NULL,NULL),(4,1726144293,1724767819,NULL,'测试12121','测试12121测试12121','',4,'','121',20,'2121','212121','1','0',NULL,NULL),(5,1724768287,1724768287,NULL,'d1212121','2121d1212121d1212121','',1,'','',30,'',NULL,'1','0',NULL,NULL),(6,1726344293,1724768356,NULL,'ceshi 12121','ceshi 12121ceshi 12121ceshi 12121','',2,'','',1,'','12121','1','0',1,NULL),(7,1725772672,1724772672,NULL,'标题标题标题标题','标题标题标题标题标题标题标题标题标题标题标题标题','http://127.0.0.1:8000/storage\\coverimage/20240827\\4b5bda49fa0c8693bb0533de7922bad7.png',3,'js1,vue','',3,'2121','2121\n## 212121','1','0',1,NULL),(8,1725944293,1727018934,1727018934,'测试标题1','测试标题1测试标题1测试标题1测试标题1','',2,'','',0,'',NULL,'1','0',1,NULL),(9,1726414293,1724932423,NULL,'测试标题2','测试标题2测试标题2测试标题2测试标题2','',2,'11','232',0,'',NULL,'1','0',1,NULL),(10,1726424293,1724932436,NULL,'212测试标题21','1212测试标题21测试标题2测试标题2','',2,'','',0,'',NULL,'1','2',1,'测试'),(11,1726734293,1726447560,NULL,'测试标题22','测试标题22测试标题22测试标题22测试标题22','http://127.0.0.1:8000/storage\\coverimage/20240916\\c0b72a97521b1b4e538d09d7ef0b42a5.png',2,'python3','',0,'','','1','0',1,NULL),(12,1726761293,1726447551,NULL,'测试标题23','测试标题23测试标题23测试标题23','http://127.0.0.1:8000/storage\\coverimage/20240916\\5d698e42eba0d0953a4de6cbf2cc4114.png',2,'测试,php','',0,'','','1','0',1,NULL),(13,1726440293,1724932473,NULL,'测试标题24','测试标题24测试标题24测试标题24','',2,'','',0,'测试标题24',NULL,'1','0',1,NULL),(14,1726514293,1726447604,NULL,'测试标题25111','测试标题25测试标题25测试标题24测试标题24测试标题24','http://127.0.0.1:8000/storage\\coverimage/20240916\\f961c19647ec6500a3d28b773b47f586.png',1,'js','',0,'','','1','0',1,NULL),(15,1726482393,1724932500,NULL,'测试标题26','测试标题26测试标题26测试标题26','',2,'','',0,'','测试标题26测试标题26','1','0',1,NULL),(16,1726714293,1726447577,NULL,'测试标题27','测试标题2777测试标题26测试标题26','http://127.0.0.1:8000/storage\\coverimage/20240916\\420391309dca5e97d55afc46cc0a591b.png',2,'绿色,草地','',0,'','12121','1','0',1,NULL),(17,1726414193,1725021059,1725021059,'测试标题28','测试标题28测试标题28测试标题28测试标题28','',1,'','',0,'','测试标题28测试标题28','1','0',1,NULL);
/*!40000 ALTER TABLE `ms_content` ENABLE KEYS */;

#
# Structure for table "ms_files"
#

DROP TABLE IF EXISTS `ms_files`;
CREATE TABLE `ms_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `category` varchar(10) DEFAULT NULL COMMENT '分类',
  `admin_id` int(11) DEFAULT NULL COMMENT '上传者id',
  `url` varchar(255) DEFAULT NULL COMMENT '图片网址',
  `mimetype` varchar(30) DEFAULT NULL COMMENT '文件类型',
  `storage` varchar(10) DEFAULT NULL COMMENT '存储位置',
  `sha1` varchar(40) DEFAULT NULL COMMENT 'sha1',
  `name` varchar(30) DEFAULT NULL COMMENT '文件名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='文件管理';

#
# Data for table "ms_files"
#

/*!40000 ALTER TABLE `ms_files` DISABLE KEYS */;
INSERT INTO `ms_files` VALUES (3,1724772656,'coverimage',1,'/storage\\coverimage/20240827\\4b5bda49fa0c8693bb0533de7922bad7.png','image/png','local','3c936ea328292ea31494c18ae7723f1dfa96f4fe',NULL),(9,1724920706,'default',1,'/storage\\default/20240829\\14447b6725175a95f03a1787ff9fce6d.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(10,1724920706,'default',1,'/storage\\default/20240829\\56347978b9cebe8f940f201d9ff7d4e8.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(12,1724920751,'default',1,'/storage\\default/20240829\\5de696abf6cda4821453b89bca8aa06e.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(13,1724920763,'default',1,'/storage\\default/20240829\\d6b1f8fab6076e4c9bd83be64dbdcfe5.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(14,1724920763,'default',1,'/storage\\default/20240829\\c8b905858c7a1f52356c925ef4dd16ad.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(15,1724922059,'default',1,'/storage\\default/20240829\\76b21d7eb45c7eacb1786525faf568ab.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(16,1724922059,'default',1,'/storage\\default/20240829\\c046c85d26aa9935a658b8d9a0e46c64.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(18,1724922104,'default',1,'/storage\\default/20240829\\52e4309f8663383300bc9e082b6c445b.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(19,1724922129,'default',1,'/storage\\default/20240829\\cdb457cbd22ff758c14f0f66e982f04b.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(20,1724922129,'default',1,'/storage\\default/20240829\\6142fc3be7a53717c982f70bf52512ec.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(21,1724925419,'default',1,'/storage\\default/20240829\\2d76f595e8570bcd10ff76d083c1ac7f.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(22,1724925419,'default',1,'/storage\\default/20240829\\1af11b9771e55144d8011cf0c53389c1.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(23,1724925431,'default',1,'/storage\\default/20240829\\e292bf8e596e98c200531f5fda0ec3eb.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(24,1724925431,'default',1,'/storage\\default/20240829\\df757c4ce8f42e7a590ddfda7e8b9349.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(25,1724925543,'default',1,'/storage\\default/20240829\\d541b8c64c82f0b158b8d9ebfd3e5682.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(26,1724925543,'default',1,'/storage\\default/20240829\\0bf95172a4d9450ad74b05de58570e14.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(27,1724925592,'default',1,'/storage\\default/20240829\\12d5444edac259baa4c2bde9c96108fd.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(28,1724925592,'default',1,'/storage\\default/20240829\\7f869f6b2e818a1f9efb25a712d645df.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(29,1724925978,'default',1,'/storage\\default/20240829\\6a6e5930a3f036c2b56b7c982e885a8c.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(30,1724926025,'default',1,'/storage\\default/20240829\\ffb6ac92b94fc64f0ea567b0878c50b3.png','image/png','local','d00edfd76637e9afcb812ef5ca16b01004300ccd',NULL),(31,1724926061,'default',1,'/storage\\default/20240829\\0496e0e95fddf9454428329146e4131b.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd',NULL),(32,1724926061,'default',1,'/storage\\default/20240829\\07b27cd8a62134ec49c2ef057aa252cc.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd',NULL),(33,1724929048,'default',1,'/storage\\default/20240829\\fa7593f5d94d35811c0256f3a66dbe42.png','image/png','local','11ce3dc4d039836adf01aecb50800e1b7392436d','image.png'),(34,1724929408,'default',1,'/storage\\default/20240829\\081ab46a562b9f52976d824534c0a473.png','image/png','local','0a7f9a44f35a366450e2507975fbc51f7cc60cbd','猫鼻子.png'),(35,1724929408,'default',1,'/storage\\default/20240829\\aea67fe5f05908b43283e3f811dca324.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd','猫眼睛.png'),(40,1725335898,'default',1,'/storage\\default/20240903\\38c6cd228e298f1563d12d0dd9696d15.png','image/png','local','c5770d27221ac7f8efa619796f77e9fd944a257d','图片.png'),(47,1726207705,'default',1,'/storage\\default/20240913\\73a12a2dc00e04975fab438c2861b446.png','image/png','local','fbae56733a374a58eb7b463bc089c9bbc1a94ffd','猫眼睛.png'),(48,1726447114,'coverimage',1,'/storage\\coverimage/20240916\\5d698e42eba0d0953a4de6cbf2cc4114.png','image/png','local','17da24cfe78fca2c559be4bbf1c07fb6ff3e7baf','图片.png'),(49,1726447456,'coverimage',1,'/storage\\coverimage/20240916\\c0b72a97521b1b4e538d09d7ef0b42a5.png','image/png','local','3cc7748e2d775e440aa1f84b7e2974dd67dffadb','图片.png'),(50,1726447468,'coverimage',1,'/storage\\coverimage/20240916\\420391309dca5e97d55afc46cc0a591b.png','image/png','local','339d757927cf2be8ad2180fba20b41cf91b89405','图片.png'),(51,1726447482,'coverimage',1,'/storage\\coverimage/20240916\\33ea6aa9bf807f1d47ba1ce63ce07318.png','image/png','local','2d239f887fdeb6ffc340a0db531066c7d0522e87','图片.png'),(52,1726447497,'coverimage',1,'/storage\\coverimage/20240916\\f961c19647ec6500a3d28b773b47f586.png','image/png','local','b93a1ec74ae41a6922dcea94a18d6defa3ca703f','图片.png'),(53,1726447510,'coverimage',1,'/storage\\coverimage/20240916\\aeeeab6ed50cb8b128fc248505658266.png','image/png','local','900ddf3e745438a0ec8af086fee2cac3a5c7f64b','图片.png');
/*!40000 ALTER TABLE `ms_files` ENABLE KEYS */;

#
# Structure for table "ms_loginlog"
#

DROP TABLE IF EXISTS `ms_loginlog`;
CREATE TABLE `ms_loginlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operate` varchar(20) NOT NULL DEFAULT '' COMMENT '操作',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ip地址',
  `ua` varchar(255) DEFAULT NULL COMMENT 'UA',
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作者',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='登录日志';

#
# Data for table "ms_loginlog"
#

/*!40000 ALTER TABLE `ms_loginlog` DISABLE KEYS */;
INSERT INTO `ms_loginlog` VALUES (1,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725515093,1),(5,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725515093,1),(6,'退出','127.0.0.1','ua测试',1725513093,1),(7,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725515093,2),(8,'退出','127.0.0.1','ua测试',1725515093,2),(9,'退出','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725516656,2),(10,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725516687,1),(11,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725522815,1),(12,'退出','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725523058,1),(13,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725523959,1),(14,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725589934,1),(15,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725609687,1),(16,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725850923,1),(17,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0',1725856714,1),(18,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1725864419,1),(19,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1725867778,7),(20,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1725867823,6),(21,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36',1725869179,9),(22,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1725894991,1),(23,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1725895889,7),(24,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1725895932,6),(25,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36',1725895984,9),(26,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726103650,1),(27,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726189088,1),(28,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726206006,1),(29,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726217113,1),(30,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726442890,1),(31,'退出','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726442944,1),(32,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726444240,1),(33,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726451280,1),(34,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726458160,1),(35,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726475312,1),(36,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726670951,1),(37,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726672296,1),(39,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1726991108,1),(40,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727008110,1),(41,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727012049,1),(42,'登录','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36 Edg/123.0.0.0',1727016576,1);
/*!40000 ALTER TABLE `ms_loginlog` ENABLE KEYS */;

#
# Structure for table "ms_role"
#

DROP TABLE IF EXISTS `ms_role`;
CREATE TABLE `ms_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  `updatetime` bigint(16) DEFAULT NULL COMMENT '更新时间',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父分类',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '分类名称',
  `rules` text COMMENT '权限列表',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='角色组管理';

#
# Data for table "ms_role"
#

/*!40000 ALTER TABLE `ms_role` DISABLE KEYS */;
INSERT INTO `ms_role` VALUES (1,1725611819,1725611819,0,'超级管理员',NULL),(2,1725611969,1725897832,1,'二级管理员组','/content,/content/list,/content/add,/content/edit,/content/del,/content/changeaudit,/content/changestatus,/adminuser,/adminuser/list,/adminuser/add,/adminuser/edit,/adminuser/del,/cate/list,/cate/add,/cate/edit,/cate/del,/system/site'),(3,1725612016,1725897673,1,'分类管理组','/cate/list,/cate/add,/cate/edit,/cate/pidlist'),(4,1725612039,1725612039,21,'第4层角色','/content/add,/content/edit,/role,/role/add,/role/edit,/role/del'),(5,1725612039,1725897837,2,'三级编辑组','/content/list,/content/edit,/content/del,/content/changestatus,/adminuser/list,/adminuser/edit');
/*!40000 ALTER TABLE `ms_role` ENABLE KEYS */;

#
# Structure for table "ms_site"
#

DROP TABLE IF EXISTS `ms_site`;
CREATE TABLE `ms_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '站点名称',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '首页标题',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `desc` varchar(255) DEFAULT NULL COMMENT '站点描述',
  `record` varchar(20) DEFAULT NULL COMMENT '备案号',
  `psrecord` varchar(20) DEFAULT NULL COMMENT '公安备案号',
  `forbidip` varchar(255) DEFAULT NULL COMMENT '禁止ip',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '站点状态',
  `favicon` varchar(255) DEFAULT NULL COMMENT '站点图标',
  `logo` varchar(255) DEFAULT NULL COMMENT '站点logo',
  `createtime` bigint(16) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='站点管理';

#
# Data for table "ms_site"
#

/*!40000 ALTER TABLE `ms_site` DISABLE KEYS */;
INSERT INTO `ms_site` VALUES (1,'测试站点2121','测试站点标题','猫叔,php,js,vue1','测试描述sss2121111121212121',NULL,NULL,NULL,'1',NULL,NULL,NULL);
/*!40000 ALTER TABLE `ms_site` ENABLE KEYS */;
