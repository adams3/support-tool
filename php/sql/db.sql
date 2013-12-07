
CREATE TABLE `hd_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` datetime NOT NULL,
  `message` text NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `replied` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;