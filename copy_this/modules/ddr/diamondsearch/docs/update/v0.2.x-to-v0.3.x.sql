-- Add an extra field to article-term relation to store parent article ID.
ALTER TABLE `ddrdiamondsearch_term2article` ADD `DDRPARENTID` CHAR( 32 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL AFTER `DDRARTICLEID` ;
