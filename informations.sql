CREATE TABLE IF NOT EXISTS `informations` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `payments` int(10) NOT NULL,
  `pricewins` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;
