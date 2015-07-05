-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-07-05 17:04:11
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
-- 表的结构 `receiveMail`
--

CREATE TABLE IF NOT EXISTS `receiveMail` (
  `id` int(11) NOT NULL,
  `subject` varchar(100) DEFAULT NULL COMMENT '邮件主题',
  `body` varchar(3000) NOT NULL COMMENT '邮件主体',
  `fromAddress` varchar(50) NOT NULL,
  `receiveDate` varchar(50) NOT NULL,
  `isAnswered` int(11) NOT NULL DEFAULT '0',
  `isSeen` int(11) NOT NULL DEFAULT '0',
  `dispatcher_id` int(11) NOT NULL,
  `isDispatched` int(11) NOT NULL DEFAULT '0',
  `handler_id` int(11) DEFAULT NULL,
  `isHandled` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(200) DEFAULT NULL COMMENT '分发员给接收邮件打得标签'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `receiveMail`
--

INSERT INTO `receiveMail` (`id`, `subject`, `body`, `fromAddress`, `receiveDate`, `isAnswered`, `isSeen`, `dispatcher_id`, `isDispatched`, `handler_id`, `isHandled`, `tags`) VALUES
(1, '第一封邮件', '第一封邮件', 'softpioneers@163.com', '2015-07-04 08:41:03', 0, 0, 2, 1, 7, 0, 'dfsd|df'),
(2, '第二封邮件', '第二封邮件', 'softpioneers@163.com', '2015-07-04 10:37:26', 0, 0, 6, 1, 4, 0, 'a'),
(3, '第三封邮件', '第三封邮件', 'softpioneers@163.com', '2015-07-04 10:38:37', 0, 0, 6, 1, 7, 0, 'liupeng'),
(4, '第四封邮件', '第四封邮件', 'softpioneers@163.com', '2015-07-04 10:45:00', 0, 0, 2, 0, 0, 0, ''),
(5, '第五封邮件', '第五封邮件', 'softpioneers@163.com', '2015-07-04 10:47:39', 0, 0, 6, 0, NULL, 0, NULL),
(6, '第六封邮件', '第六封邮件', 'softpioneers@163.com', '2015-07-04 10:51:41', 0, 0, 6, 0, NULL, 0, NULL),
(7, '第七封邮件', '第七封邮件', 'softpioneers@163.com', '2015-07-04 10:53:07', 0, 0, 2, 0, NULL, 0, NULL),
(8, '一张图片', '<div style="line-height:1.7;color:#000000;font-size:14px;font-family:Arial"><img src="http://mimg.163.com/jy3style/lib/htmlEditor/portrait/face/preview/face0.gif"></div><br><br><span title="neteasefooter"><span id="netease_mail_footer"></span></span>\r\n', 'softpioneers@163.com', '2015-07-05 07:43:05', 0, 0, 2, 1, 7, 0, ''),
(9, 'telegram', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=gbk" />\r\n<title>网易邮箱</title>\r\n\r\n</head>\r\n<body>\r\n<div style="line-height:1.7;color:#000000;font-size:14px;font-family:Arial"><img data-image="1" orgheight="300" orgwidth="300" src="cid:565510dd$1$14e5d36cbd3$Coremail$softpioneers$163.com" style="width: 300px; height: 300px;"></div><br><br><span title="neteasefooter"><span id="netease_mail_footer"></span></span>\r\n\r\n<style type="text/css">\r\n.netease-attDown{ width:430px;height:auto;background-color:#F6F9FC;border:#C5D2DA 1px solid;padding:12px;line-height:160%;font-size:12px;white-space:nowrap;font-family:Verdana}\r\n.netease-attDown-tit{ color:#A0A0A0 }\r\n.netease-attDown-tit strong{ color:#008000 }\r\n.netease-attDown a{ color:#0669B2}\r\n.netease-attDown dl,\r\n.netease-attDown dt,\r\n.netease-attDown dd{ margin:0;padding:0;width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}\r\n.netease-attDown dt{ font-weight:bold;color:#333;margin-top:8px}\r\n.netease-attDown dt .info{ color:#999;font-weight:normal}\r\n.netease-notice{padding-bottom:5px; white-space:normal}\r\n</style>\r\n\r\n<div class="netease-attDown">\r\n	<div class="netease-notice"><img src="http://mimg.127.net/xm/all/attpreview/img/ico_notice.gif" alt="提示图标" style="vertical-align:middle" /> 邮件带有附件预览链接，若您转发或回复此邮件时不希望对方预览附件，建议您手动删除链接。</div>\r\n	<div class="netease-attDown-tit">共有 <strong>1</strong> 个附件</div>\r\n	\r\n		<dl>\r\n			<dt title="telegram.png">telegram.png<span class="info">(30K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=telegram.png&mid=xtbBLwYukVUL28VRPQAAs6&part=3&sign=84873fb79536e72027615def0cff521d&time=1436086629&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=xtbBLwYukVUL28VRPQAAs6&part=3&sign=84873fb79536e72027615def0cff521d&time=1436086629&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n</div>\r\n</body>\r\n</html>\r\n', 'softpioneers@163.com', '2015-07-05 07:55:49', 0, 0, 2, 0, NULL, 0, NULL),
(10, '多图片及附件', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=gbk" />\r\n<title>网易邮箱</title>\r\n\r\n</head>\r\n<body>\r\n<div style="line-height:1.7;color:#000000;font-size:14px;font-family:Arial"><div><img data-image="1" orgheight="493" orgwidth="500" src="cid:20950454$3$14e5d89f571$Coremail$softpioneers$163.com" style="width: 500px; height: 493px;"><br>上面是第一张图<br><img data-image="1" orgheight="300" orgwidth="300" src="cid:174f3782$4$14e5d89f571$Coremail$softpioneers$163.com" style="width: 300px; height: 300px;"><br>上面是第二张图<br></div></div><br><br><span title="neteasefooter"><span id="netease_mail_footer"></span></span>\r\n<style type="text/css">\r\n.netease-attDown{ width:430px;height:auto;background-color:#F6F9FC;border:#C5D2DA 1px solid;padding:12px;line-height:160%;font-size:12px;white-space:nowrap;font-family:Verdana}\r\n.netease-attDown-tit{ color:#A0A0A0 }\r\n.netease-attDown-tit strong{ color:#008000 }\r\n.netease-attDown a{ color:#0669B2}\r\n.netease-attDown dl,\r\n.netease-attDown dt,\r\n.netease-attDown dd{ margin:0;padding:0;width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}\r\n.netease-attDown dt{ font-weight:bold;color:#333;margin-top:8px}\r\n.netease-attDown dt .info{ color:#999;font-weight:normal}\r\n.netease-notice{padding-bottom:5px; white-space:normal}\r\n</style>\r\n\r\n<div class="netease-attDown">\r\n	<div class="netease-notice"><img src="http://mimg.127.net/xm/all/attpreview/img/ico_notice.gif" alt="提示图标" style="vertical-align:middle" /> 邮件带有附件预览链接，若您转发或回复此邮件时不希望对方预览附件，建议您手动删除链接。</div>\r\n	<div class="netease-attDown-tit">共有 <strong>2</strong> 个附件</div>\r\n	\r\n		<dl>\r\n			<dt title="s5830i相机静音.txt">s5830i相机静音.txt<span class="info">(1K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=s5830i%E7%9B%B8%E6%9C%BA%E9%9D%99%E9%9F%B3.txt&mid=1tbitBAukVSIJn7CzQAAsQ&part=5&sign=63adcc1040cc2467206da27eb4d53dee&time=1436088427&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=1tbitBAukVSIJn7CzQAAsQ&part=5&sign=63adcc1040cc2467206da27eb4d53dee&time=1436088427&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n		<dl>\r\n			<dt title="windows开启wifi.txt">windows开启wifi.txt<span class="info">(2K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=windows%E5%BC%80%E5%90%AFwifi.txt&mid=1tbitBAukVSIJn7CzQAAsQ&part=6&sign=63adcc1040cc2467206da27eb4d53dee&time=1436088427&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=1tbitBAukVSIJn7CzQAAsQ&part=6&sign=63adcc1040cc2467206da27eb4d53dee&time=1436088427&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n</div>\r\n</body>\r\n</html>\r\n', 'softpioneers@163.com', '2015-07-05 09:26:39', 0, 0, 6, 0, NULL, 0, NULL),
(11, '多图片', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=gbk" />\r\n<title>网易邮箱</title>\r\n\r\n</head>\r\n<body>\r\n<div style="line-height:1.7;color:#000000;font-size:14px;font-family:Arial"><div><img data-image="1" orgheight="300" orgwidth="300" src="cid:106cfcdd$1$14e5d8ef9bb$Coremail$softpioneers$163.com" style="width: 300px; height: 300px;"><br>上面是第一张图<br><img data-image="1" orgheight="493" orgwidth="500" src="cid:634d1997$2$14e5d8ef9bb$Coremail$softpioneers$163.com" style="width: 500px; height: 493px;"><br>上面是第二张图</div></div><br><br><span title="neteasefooter"><span id="netease_mail_footer"></span></span>\r\n<style type="text/css">\r\n.netease-attDown{ width:430px;height:auto;background-color:#F6F9FC;border:#C5D2DA 1px solid;padding:12px;line-height:160%;font-size:12px;white-space:nowrap;font-family:Verdana}\r\n.netease-attDown-tit{ color:#A0A0A0 }\r\n.netease-attDown-tit strong{ color:#008000 }\r\n.netease-attDown a{ color:#0669B2}\r\n.netease-attDown dl,\r\n.netease-attDown dt,\r\n.netease-attDown dd{ margin:0;padding:0;width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}\r\n.netease-attDown dt{ font-weight:bold;color:#333;margin-top:8px}\r\n.netease-attDown dt .info{ color:#999;font-weight:normal}\r\n.netease-notice{padding-bottom:5px; white-space:normal}\r\n</style>\r\n\r\n<div class="netease-attDown">\r\n	<div class="netease-notice"><img src="http://mimg.127.net/xm/all/attpreview/img/ico_notice.gif" alt="提示图标" style="vertical-align:middle" /> 邮件带有附件预览链接，若您转发或回复此邮件时不希望对方预览附件，建议您手动删除链接。</div>\r\n	<div class="netease-attDown-tit">共有 <strong>2</strong> 个附件</div>\r\n	\r\n		<dl>\r\n			<dt title="telegram.png">telegram.png<span class="info">(30K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=telegram.png&mid=1tbiTxkukVWBN88LhgAAsI&part=3&sign=16ef3b51fb48ce9b6031e79b85b70b71&time=1436088837&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=1tbiTxkukVWBN88LhgAAsI&part=3&sign=16ef3b51fb48ce9b6031e79b85b70b71&time=1436088837&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n		<dl>\r\n			<dt title="圈圈.jpg">圈圈.jpg<span class="info">(23K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=%E5%9C%88%E5%9C%88.jpg&mid=1tbiTxkukVWBN88LhgAAsI&part=4&sign=16ef3b51fb48ce9b6031e79b85b70b71&time=1436088837&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=1tbiTxkukVWBN88LhgAAsI&part=4&sign=16ef3b51fb48ce9b6031e79b85b70b71&time=1436088837&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n</div>\r\n</body>\r\n</html>\r\n', 'softpioneers@163.com', '2015-07-05 09:32:07', 0, 0, 6, 0, NULL, 0, NULL),
(12, '多图片及附件', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n<meta http-equiv="Content-Type" content="text/html; charset=gbk" />\r\n<title>网易邮箱</title>\r\n\r\n</head>\r\n<body>\r\n<div style="line-height:1.7;color:#000000;font-size:14px;font-family:Arial"><div><img data-image="1" orgheight="493" orgwidth="500" src="cid:20950454$3$14e5d89f571$Coremail$softpioneers$163.com" style="width: 500px; height: 493px;"><br>上面是第一张图<br><img data-image="1" orgheight="300" orgwidth="300" src="cid:174f3782$4$14e5d89f571$Coremail$softpioneers$163.com" style="width: 300px; height: 300px;"><br>上面是第二张图<br></div></div><br><br><span title="neteasefooter"><span id="netease_mail_footer"></span></span>\r\n<style type="text/css">\r\n.netease-attDown{ width:430px;height:auto;background-color:#F6F9FC;border:#C5D2DA 1px solid;padding:12px;line-height:160%;font-size:12px;white-space:nowrap;font-family:Verdana}\r\n.netease-attDown-tit{ color:#A0A0A0 }\r\n.netease-attDown-tit strong{ color:#008000 }\r\n.netease-attDown a{ color:#0669B2}\r\n.netease-attDown dl,\r\n.netease-attDown dt,\r\n.netease-attDown dd{ margin:0;padding:0;width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}\r\n.netease-attDown dt{ font-weight:bold;color:#333;margin-top:8px}\r\n.netease-attDown dt .info{ color:#999;font-weight:normal}\r\n.netease-notice{padding-bottom:5px; white-space:normal}\r\n</style>\r\n\r\n<div class="netease-attDown">\r\n	<div class="netease-notice"><img src="http://mimg.127.net/xm/all/attpreview/img/ico_notice.gif" alt="提示图标" style="vertical-align:middle" /> 邮件带有附件预览链接，若您转发或回复此邮件时不希望对方预览附件，建议您手动删除链接。</div>\r\n	<div class="netease-attDown-tit">共有 <strong>2</strong> 个附件</div>\r\n	\r\n		<dl>\r\n			<dt title="s5830i相机静音.txt">s5830i相机静音.txt<span class="info">(1K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=s5830i%E7%9B%B8%E6%9C%BA%E9%9D%99%E9%9F%B3.txt&mid=1tbitBAukVSIJn7CzQAAsQ&part=5&sign=d265571fa2d5c6231a85be1e1b70b0d7&time=1436088898&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=1tbitBAukVSIJn7CzQAAsQ&part=5&sign=d265571fa2d5c6231a85be1e1b70b0d7&time=1436088898&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n		<dl>\r\n			<dt title="windows开启wifi.txt">windows开启wifi.txt<span class="info">(2K)</span></dt>\r\n			<dd>\r\n				<a href="http://preview.mail.163.com/xdownload?filename=windows%E5%BC%80%E5%90%AFwifi.txt&mid=1tbitBAukVSIJn7CzQAAsQ&part=6&sign=d265571fa2d5c6231a85be1e1b70b0d7&time=1436088898&uid=softpioneers%40163.com" target="_blank">极速下载</a>\r\n				<a href="http://preview.mail.163.com/preview?mid=1tbitBAukVSIJn7CzQAAsQ&part=6&sign=d265571fa2d5c6231a85be1e1b70b0d7&time=1436088898&uid=softpioneers%40163.com" target="_blank">在线预览</a>\r\n			</dd>\r\n		</dl>\r\n	\r\n</div>\r\n</body>\r\n</html>\r\n', 'softpioneers@163.com', '2015-07-05 09:26:39', 0, 0, 2, 0, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `replyMail`
--

CREATE TABLE IF NOT EXISTS `replyMail` (
  `id` int(11) NOT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `body` varchar(1000) NOT NULL,
  `reply_id` int(11) NOT NULL COMMENT 'receivemail的id，为0表示新邮件',
  `toWhom` varchar(50) NOT NULL,
  `replyDate` varchar(50) NOT NULL,
  `handler_id` int(11) NOT NULL,
  `isSend` int(11) NOT NULL DEFAULT '0',
  `assessor_id` int(11) DEFAULT NULL COMMENT '为空时在处理人手中，不为空在审核人手中',
  `isAssessed` int(11) NOT NULL DEFAULT '0',
  `assessor_advice` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='内部邮件';

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL COMMENT '自增id',
  `name` varchar(50) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL COMMENT '用户密码',
  `role` varchar(50) NOT NULL COMMENT '用户角色',
  `created_at` varchar(13) NOT NULL,
  `default_assessor_id` int(11) DEFAULT NULL COMMENT '只有处理人员该字段有值'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `role`, `created_at`, `default_assessor_id`) VALUES
(1, 'pioneers', 'pioneers', 'admin', '1435995522087', NULL),
(2, 'sify', 'softbuaa', 'dispatcher', '1435995522097', NULL),
(3, 'zst', 'zstzstzst', 'handler', '1435996059208', NULL),
(4, 'zj', 'zjzjzjzj', 'handler', '1435997171150', NULL),
(5, 'lp', 'lplplplp', 'handler', '1435997215618', NULL),
(6, 'zhengjianglong', '123456', 'dispatcher', '1436013045406', NULL),
(7, 'liupeng', '123456', 'handler', '1436059610852', NULL),
(8, 'sifyuan', 'sifyuan', 'assessor', '1436075215513', NULL),
(9, 'sifangyuan', 'sifangyuan', 'assessor', '1436075391226', NULL);

--
-- Indexes for dumped tables
--

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `receiveMail`
--
ALTER TABLE `receiveMail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `replyMail`
--
ALTER TABLE `replyMail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
