--
-- Table structure for table `hd_form`
--

CREATE TABLE `hd_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config` longtext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `customer_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf16 COLLATE=utf16_czech_ci AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Table structure for table `hd_message`
--

CREATE TABLE `hd_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` datetime NOT NULL,
  `message` text NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `flag` tinyint(4) NOT NULL DEFAULT '0',
  `replied` tinyint(4) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `form_id` int(11) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `hd_user`
--

CREATE TABLE `hd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hd_form`
--
ALTER TABLE `hd_form`
  ADD CONSTRAINT `hd_form_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `hd_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
