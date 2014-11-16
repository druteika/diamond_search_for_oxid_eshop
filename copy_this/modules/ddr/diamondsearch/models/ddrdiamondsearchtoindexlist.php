<?php
/**
 * This file is part of Diamond Search CE module for OXID eShop.
 *
 * The software is allowed to use only with OXID eShop Community Edition
 * and comes with absolutely no warranty - use it for your own risk!
 *
 * For more information please see included LICENCE.txt file.
 *
 * @package       ddrdiamondsearch module
 * @version       0.4.0 CE
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchToIndex.
 * A model for saving articles that need index.
 */
class DdrDiamondSearchToIndexList extends oxList
{

    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = 'DdrDiamondSearchToIndex';

    /**
     * @var int Number of entries to process in each indexing run.
     */
    protected $_iBundleToIndexSize = 0;


    /**
     * Class constructor.
     * Initialize bundle size with module config param value.
     */
    public function __construct()
    {
        $this->_iBundleToIndexSize = (int) oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'BundleSize' );
    }


    /**
     * Load articles to index.
     *
     * @param null|int $mBundleToIndexSize
     *
     * @return int Loaded entries count.
     */
    public function loadBundleToIndex( $mBundleToIndexSize = null )
    {
        $iBundleToIndexSize = !is_null( $mBundleToIndexSize ) ? (int) $mBundleToIndexSize : $this->_iBundleToIndexSize;

        if ( empty( $iBundleToIndexSize ) ) {
            return 0;
        }

        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE %s ORDER BY `DDRTIMESTAMP` ASC LIMIT %d",
            $this->getTable(),
            oxRegistry::get( 'DdrDiamondSearchOxBase' )->getShopAndLanguageSnippet( '', false ),
            (int) $iBundleToIndexSize
        );

        $this->selectString( $sQuery );

        return $this->count();
    }

    /**
     * Add all article to indexing queue.
     *
     * @param int $iLanguageId
     *
     * @return int
     */
    public function addAllArticles( $iLanguageId )
    {
        $oDb     = oxDb::getDb();
        $sShopId = oxRegistry::get( 'DdrDiamondSearchModule' )->getShopId();

        // Remove any articles left from index queue
        $sQuery = sprintf(
            "DELETE FROM `%s` WHERE `DDRSHOPID` = %s AND `DDRLANGID` = %d",
            $this->getTable(),
            $oDb->quote( $sShopId ),
            (int) $iLanguageId
        );

        try {
            $oDb->execute( $sQuery );
        } catch ( oxException $oException ) {
            $oException->debugOut();
        }

        // Add all article to index queue
        $sQuery = sprintf(
            "INSERT INTO `%s` (`OXID`, `DDRSHOPID`, `DDRLANGID`, `DDRARTICLEID`)"
            . " SELECT MD5( CONCAT(`a`.`OXID`, '%d') ) AS `OXID`, `a`.`OXSHOPID`, %d AS `DDRLANGID`,"
            . "  `a`.`OXID` AS `DDRARTICLEID`"
            . " FROM `%s` AS `a`"
            . " WHERE `a`.`OXSHOPID` = %s  AND `a`.`OXACTIVE` = 1",
            $this->getTable(),
            (int) $iLanguageId,
            (int) $iLanguageId,
            'oxarticles',
            $oDb->quote( $sShopId )
        );

        try {
            $oDb->execute( $sQuery );
        } catch ( oxException $oException ) {
            $oException->debugOut();
        }

        return $oDb->Affected_Rows();
    }


    /**
     * Get related model database table name.
     *
     * @return string
     */
    protected function getTable()
    {
        return $this->getBaseObject()->getCoreTableName();
    }
}
