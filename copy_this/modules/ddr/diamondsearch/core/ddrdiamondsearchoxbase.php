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
 * Class DdrDiamondSearchOxBase.
 * Additional oxBase layer implementing common reusable Diamond search models features.
 *
 * @nice2have: Implement common getters and setters and use in models.
 */
class DdrDiamondSearchOxBase extends oxBase
{

    /**
     * Compiles an SQL query where clause snippet for current active shop and language.
     *
     * @param string $sTable
     * @param bool   $blTailingAnd
     *
     * @return string
     */
    public function getShopAndLanguageSnippet( $sTable = '', $blTailingAnd = true )
    {
        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $sTable = !empty( $sTable ) ? "`" . $sTable . "`." : "";

        return sprintf(
            " %s`DDRSHOPID` = %s AND %s`DDRLANGID` = %s%s ",
            $sTable,
            $this->quote( $oModule->getShopId() ),
            $sTable,
            $this->quote( $oModule->getLanguageId() ),
            ( !empty( $blTailingAnd ) ? " AND" : "" )
        );
    }

    /**
     * Execute select type query and fetch results as array.
     * If debug mode is on, outputs the query and its execution time in milliseconds.
     *
     * @param string $sQuery
     *
     * @return array
     */
    public function getArray( $sQuery )
    {
        // Check if debug mode is on
        $blDebug = (bool) oxRegistry::getConfig()->getConfigParam( 'iDebug' );
        $iTime   = $blDebug ? microtime( true ) : 0;

        // Execute select query for data as array
        $aData = $this->_getDb()->getArray( $sQuery );

        if ( $blDebug ) {
            printf(
                'Diamond Search query "%s"<br/>executed in %f ms<hr/>',
                $sQuery,
                ( microtime( true ) - $iTime ) * 1000
            );
        }

        return $aData;
    }

    /**
     * Alias for oxDb quote method.
     *
     * @codeCoverageIgnore
     *
     * @param string $sString
     *
     * @return mixed
     */
    public function quote( $sString )
    {
        return $this->_getDb()->quote( $sString );
    }


    /**
     * Get DB helper instance.
     *
     * @codeCoverageIgnore
     *
     * @return oxLegacyDb
     */
    protected function _getDb()
    {
        return oxDb::getDb( ADODB_FETCH_ASSOC );
    }
}
