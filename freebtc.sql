CREATE TABLE IF NOT EXISTS `freebtc` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `address` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ip` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `date` date NOT NULL,
  `time` int(10) NOT NULL,
  `pricewin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;
