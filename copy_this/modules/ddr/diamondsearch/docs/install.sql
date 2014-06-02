-- Diamond Search database tables installation --

--
-- Table structure for table `ddrdiamondsearch_toindex`
--
CREATE TABLE IF NOT EXISTS `ddrdiamondsearch_toindex` (
  `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'Article OXID',
  `DDRSHOPID` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `DDRLANGID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DDRARTICLEID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRTIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`OXID`),
  KEY `DDRSHOPIDANDLANGUAGE` (`DDRSHOPID`, `DDRLANGID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ddrdiamondsearch_terms`
--
CREATE TABLE IF NOT EXISTS `ddrdiamondsearch_terms` (
  `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRSHOPID` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `DDRLANGID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DDRTERM` varchar(32) NOT NULL,
  `DDRMULTIPLICITY` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT 'How many times indexed',
  `DDRDIVERSITY` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT 'How many times indexed in different articles',
  `DDRFIRSTINDEXEDAT` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DDRLASTINDEXEDAT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DDRTIMESSEARCHED` int(10) unsigned NOT NULL DEFAULT '0',
  `DDRTIMESSEARCHEDAALONE` int(10) unsigned NOT NULL DEFAULT '0',
  `DDRLASTSEARCHEDAT` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`OXID`),
  UNIQUE KEY `DDRTERM` (`DDRSHOPID`,`DDRLANGID`,`DDRTERM`),
  KEY `DDRTERMSORDER` (`DDRDIVERSITY`,`DDRTIMESSEARCHEDAALONE`,`DDRTIMESSEARCHED`,`DDRTERM`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ddrdiamondsearch_term2article`
--
CREATE TABLE IF NOT EXISTS `ddrdiamondsearch_term2article` (
  `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRSHOPID` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `DDRLANGID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DDRTERMID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRARTICLEID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRCATEGORYID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRVENDORID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRMANUFACTURERID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRTITLE` varchar(255) NOT NULL DEFAULT '',
  `DDRPRICE` double NOT NULL DEFAULT '0',
  `DDRMULTIPLICITY` tinyint(3) unsigned NOT NULL COMMENT 'How many times term is used in the article',
  `DDRRELEVANCE` int(10) unsigned NOT NULL COMMENT 'Calculated relevance value of the term for the article',
  `DDRFIRSTINDEXEDAT` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DDRLASTINDEXEDAT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`OXID`),
  UNIQUE KEY `DDRTERM2ARTICLE` (`DDRSHOPID`,`DDRLANGID`,`DDRTERMID`,`DDRPRICE`,`DDRARTICLEID`),
  KEY `DDRORDER` (`DDRPRICE`,`DDRRELEVANCE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ddrdiamondsearch_filtervalues`
--
CREATE TABLE IF NOT EXISTS `ddrdiamondsearch_filtervalues` (
  `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRSHOPID` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `DDRLANGID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DDRFIELD` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRVALUE` varchar(128) NOT NULL DEFAULT '',
  `DDRMULTIPLICITY` mediumint(8) unsigned NOT NULL DEFAULT '1' COMMENT 'How many times articles have the value',
  `DDRFIRSTINDEXEDAT` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `DDRLASTINDEXEDAT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`OXID`),
  UNIQUE KEY `DDRFILTERVALUE` (`DDRSHOPID`,`DDRLANGID`,`DDRFIELD`,`DDRVALUE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
