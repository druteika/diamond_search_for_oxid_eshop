-- Diamond Search database tables installation --
-- TODO: After final refactoring of queries, design table indexes for maximum performance!

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
  KEY `DDRSHOPID` (`DDRSHOPID`)
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
  UNIQUE KEY `DDRTERM` (`DDRTERM`),
  KEY `DDRSHOPID` (`DDRSHOPID`),
  KEY `DDRMULTIPLICITY` (`DDRMULTIPLICITY`),
  KEY `DDRTIMESSEARCHED` (`DDRTIMESSEARCHED`),
  KEY `DDRTIMESSEARCHEDAALONE` (`DDRTIMESSEARCHEDAALONE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `ddrdiamondsearch_term2field`
--
CREATE TABLE IF NOT EXISTS `ddrdiamondsearch_term2field` (
  `OXID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRSHOPID` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `DDRLANGID` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DDRTERMID` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `DDRFIELD` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`OXID`),
  UNIQUE KEY `TERM2FIELD` (`DDRTERMID`,`DDRFIELD`),
  KEY `DDRSHOPID` (`DDRSHOPID`)
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
  UNIQUE KEY `TERM2ARTICLE` (`DDRTERMID`,`DDRARTICLEID`),
  KEY (`DDRSHOPID`),
  KEY (`DDRMULTIPLICITY`),
  KEY (`DDRRELEVANCE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- TODO: Add table `ddrdiamondsearch_filtervalues` - field to full value (not split)
