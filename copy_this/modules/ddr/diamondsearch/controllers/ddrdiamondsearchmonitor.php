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
 * Class DdrDiamondSearchMonitor.
 * Diamond Search dashboard page controller.
 */
class DdrDiamondSearchMonitor extends oxUBase
{

    /**
     * Maximum length of list-type statistics.
     */
    const DDR_STATS_LIST_LENGTH = 100;


    /**
     * Current class template name.
     *
     * @var string
     */
    protected $_sThisTemplate = 'ddrdiamondsearchmonitor.tpl';


    /**
     * Render dashboard page.
     *
     * @return mixed
     */
    public function render()
    {
        $oUser = $this->getUser();

        if ( ( !( $oUser instanceof oxUser ) or !$oUser->getId() or
               ( $oUser->oxuser__oxrights->value !== 'malladmin' ) ) and
             !oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'PublicMon' )
        ) {

            // Only admin may access the page if monitor is not configured for public access
            oxRegistry::getUtils()->redirect(
                sprintf( '%scl=Account&sourcecl=ddrdiamondsearchmonitor', $this->getViewConfig()->getSslSelfLink() )
            );
        }

        return $this->_DdrDiamondSearchMonitor_render_parent();
    }


    /**
     * Check if there is more than one active language.
     *
     * @return bool
     */
    public function areThereManyLanguages()
    {
        /** @var oxLang $oLang */
        $oLang        = oxRegistry::getLang();
        $aLanguages   = (array) $oLang->getLanguageArray();
        $iActiveCount = 0;

        foreach ( $aLanguages as $oLanguage ) {
            if ( is_object( $oLanguage ) and !empty( $oLanguage->active ) and isset( $oLanguage->id ) ) {
                $iActiveCount++;

                if ( $iActiveCount > 1 ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if search statistics in on.
     *
     * @return bool
     */
    public function isSearchStatisticsOn()
    {
        return (bool) oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'SaveStats' );
    }

    /**
     * Get total indexed articles count.
     *
     * @param bool $blAllLanguages
     *
     * @return int
     */
    public function getIndexSize( $blAllLanguages = true )
    {
        return $this->_getCountStats( 'ddrdiamondsearch_term2article', 'DDRARTICLEID', $blAllLanguages );
    }

    /**
     * Get index queue total items count.
     *
     * @param bool $blAllLanguages
     *
     * @return int
     */
    public function getQueueSize( $blAllLanguages = true )
    {
        return $this->_getCountStats( 'ddrdiamondsearch_toindex', 'OXID', $blAllLanguages );
    }

    /**
     * Get total filter values count.
     *
     * @param bool $blAllLanguages
     *
     * @return int
     */
    public function getFilterValuesCount( $blAllLanguages = true )
    {
        return $this->_getCountStats( 'ddrdiamondsearch_filtervalues', 'OXID', $blAllLanguages );
    }

    /**
     * Get total different filters count.
     *
     * @param bool $blAllLanguages
     *
     * @return int
     */
    public function getFiltersCount( $blAllLanguages = true )
    {
        return $this->_getCountStats( 'ddrdiamondsearch_filtervalues', 'DDRFIELD', $blAllLanguages );
    }

    /**
     * Get total search terms count.
     *
     * @param bool $blAllLanguages
     *
     * @return int
     */
    public function getTermsCount( $blAllLanguages = true )
    {
        return $this->_getCountStats( 'ddrdiamondsearch_terms', 'OXID', $blAllLanguages );
    }

    /**
     * Get total count of relations between articles and terms.
     *
     * @param bool $blAllLanguages
     *
     * @return int
     */
    public function getTermsToArticlesRelationsCount( $blAllLanguages = true )
    {
        return $this->_getCountStats( 'ddrdiamondsearch_term2article', 'OXID', $blAllLanguages );
    }

    /**
     * Get a list of most frequently indexed terms.
     *
     * @param bool $blAllLanguages
     *
     * @return array
     */
    public function getMostFrequentTerms( $blAllLanguages = true )
    {
        return $this->_getTermsStats( 'ddrdiamondsearch_terms', 'DDRTERM', 'DDRMULTIPLICITY', $blAllLanguages );
    }

    /**
     * Get a list of most often searched terms.
     *
     * @param bool $blAllLanguages
     *
     * @return array
     */
    public function getMostSearchedTerms( $blAllLanguages = true )
    {
        return $this->_getTermsStats( 'ddrdiamondsearch_terms', 'DDRTERM', 'DDRTIMESSEARCHED', $blAllLanguages );
    }


    /**
     * Get distinct values count for a given field in given table.
     * Looks for it in current sub-shop.
     *
     * @param string $sTable
     * @param string $sField
     * @param bool   $blAllLanguages If false, will look in active language only.
     *
     * @return int
     */
    protected function _getCountStats( $sTable, $sField, $blAllLanguages = true )
    {
        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );
        $oDb     = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );

        return (int) $oDb->getOne(
            sprintf(
                'SELECT COUNT(DISTINCT `%s`) FROM `%s` WHERE `DDRSHOPID` = %s%s',
                mysql_real_escape_string( $sField ),
                mysql_real_escape_string( $sTable ),
                $oDb->quote( $oModule->getShopId() ),
                ( $blAllLanguages ? '' : sprintf( ' AND `DDRLANGID` = %s', $oDb->quote( $oModule->getLanguageId() ) ) )
            )
        );
    }

    /**
     * Get an array of result fields for a database table ordered descending by sort field.
     *
     * @param string $sTable
     * @param string $sResultField
     * @param string $sSortField
     * @param bool   $blAllLanguages
     *
     * @return array
     */
    protected function _getTermsStats( $sTable, $sResultField, $sSortField, $blAllLanguages = true )
    {
        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );
        $oDb     = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );

        $aData = (array) $oDb->getArray(
            sprintf(
                'SELECT CONCAT(`%s`, " (", `%s`, ")") AS `%s` FROM `%s` WHERE `DDRSHOPID` = %s%s
                    ORDER BY `%s` DESC LIMIT %d',
                mysql_real_escape_string( $sResultField ),
                mysql_real_escape_string( $sSortField ),
                mysql_real_escape_string( $sResultField ),
                mysql_real_escape_string( $sTable ),
                $oDb->quote( $oModule->getShopId() ),
                ( $blAllLanguages ? '' : sprintf( ' AND `DDRLANGID` = %s', $oDb->quote( $oModule->getLanguageId() ) ) ),
                mysql_real_escape_string( $sSortField ),
                (int) oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'ListLen' )
            )
        );

        foreach ( $aData as $iKey => $aRow ) {
            if ( !empty( $aRow[$sResultField] ) ) {
                $aData[$iKey] = ucfirst( trim( (string) $aRow[$sResultField] ) );
            } else {
                unset( $aData[$iKey] );
            }
        }

        return $aData;
    }


    /**
     * Parent `render` call.
     *
     * @codeCoverageIgnore
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchMonitor_render_parent()
    {
        return parent::render();
    }
}
