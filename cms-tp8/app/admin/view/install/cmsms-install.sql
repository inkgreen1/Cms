# Host: localhost  (Version: 5.7.26)
# Date: 2024-09-26 08:16:46
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员用户';

#
# Data for table "ms_admin"
#

/*!40000 ALTER TABLE `ms_admin` DISABLE KEYS */;
INSERT INTO `ms_admin` VALUES (1,'admin','$2y$10$nHPIpw6MDpkFH139lPlRze/9fEC2qAddhKWcJtT0VMNmFYUpJmhoq','猫叔maoshu','13730925241','http://127.0.0.1:8000/storage\\default/20240903\\38c6cd228e298f1563d12d0dd9696d15.png',1,NULL,1725523375,1724220622);
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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

#
# Data for table "ms_adminlog"
#

/*!40000 ALTER TABLE `ms_adminlog` DISABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='管理员用户';

#
# Data for table "ms_category"
#

/*!40000 ALTER TABLE `ms_category` DISABLE KEYS */;
INSERT INTO `ms_category` VALUES (1,NULL,NULL,0,'php','php相关知识'),(2,NULL,NULL,0,'python','python知识'),(3,NULL,NULL,0,'js','js相关知识');
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
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COMMENT='登录日志';

#
# Data for table "ms_loginlog"
#

/*!40000 ALTER TABLE `ms_loginlog` DISABLE KEYS */;
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
