-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-07-09 08:49:15
-- 服务器版本： 10.0.13-MariaDB
-- PHP Version: 5.6.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmail`
--

-- --------------------------------------------------------

--
-- 表的结构 `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL,
  `mail_id` text NOT NULL,
  `attachment_id` text NOT NULL,
  `attachment_name` text NOT NULL COMMENT '附件名称',
  `file_name` text NOT NULL COMMENT '下载下来的附件文件的名称'
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `receiveMail`
--

CREATE TABLE IF NOT EXISTS `receiveMail` (
  `id` int(11) NOT NULL,
  `mail_id` text NOT NULL COMMENT 'email的id',
  `subject` text COMMENT '邮件主题',
  `body` mediumtext COMMENT '邮件主体',
  `fromAddress` varchar(50) NOT NULL,
  `receiveDate` datetime NOT NULL,
  `tags` text COMMENT '分发员给接收邮件打得标签',
  `status` int(11) NOT NULL DEFAULT '0',
  `deadline` datetime DEFAULT NULL,
  `dispatcher_id` int(11) NOT NULL,
  `handler_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `replyMail`
--

CREATE TABLE IF NOT EXISTS `replyMail` (
  `id` int(11) NOT NULL,
  `mail_id` text NOT NULL COMMENT 'email的id',
  `subject` text,
  `body` mediumtext NOT NULL,
  `reply_id` int(11) DEFAULT NULL COMMENT '回复邮件对应原邮件的id，可以为空',
  `toWhom` varchar(50) NOT NULL,
  `replyDate` datetime DEFAULT NULL,
  `assessor_advice` mediumtext,
  `status` int(11) NOT NULL DEFAULT '1',
  `handler_id` int(11) NOT NULL,
  `assessor_id` int(11) DEFAULT NULL COMMENT '为空时在处理人手中，不为空在审核人手中'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内部邮件';

-- --------------------------------------------------------

--
-- 表的结构 `template`
--

CREATE TABLE IF NOT EXISTS `template` (
  `id` int(11) NOT NULL,
  `name` tinytext NOT NULL,
  `handler_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `body` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL COMMENT '自增id',
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '用户密码',
  `role` varchar(50) NOT NULL COMMENT '用户角色',
  `created_at` varchar(13) NOT NULL,
  `default_assessor_id` int(11) DEFAULT NULL COMMENT '只有处理人员该字段有值'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `role`, `created_at`, `default_assessor_id`) VALUES
(1, 'admin', 'admin', 'admin', '1435995522087', NULL),
(9, 'sifangyuan', '123456', 'dispatcher', '1436251087672', NULL),
(10, 'zhengjianglong', '123456', 'handler', '1436251118628', NULL),
(11, 'liupeng', '123456', 'assessor', '1436251143884', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user_receiveMail`
--

CREATE TABLE IF NOT EXISTS `user_receiveMail` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiveMail_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='存储处理员-接收邮件的可查阅关系';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attachment`
--
ALTER TABLE `attachment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receiveMail`
--
ALTER TABLE `receiveMail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replyMail`
--
ALTER TABLE `replyMail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_receiveMail`
--
ALTER TABLE `user_receiveMail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachment`
--
ALTER TABLE `attachment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `receiveMail`
--
ALTER TABLE `receiveMail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `replyMail`
--
ALTER TABLE `replyMail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_receiveMail`
--
ALTER TABLE `user_receiveMail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
