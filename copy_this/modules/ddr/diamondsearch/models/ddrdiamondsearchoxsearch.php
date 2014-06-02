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
 * @version       0.3.1 CE
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */


/**
 * Class DdrDiamondSearchOxSearch
 * Extended oxSearch model.
 *
 * @see oxSearch
 */
class DdrDiamondSearchOxSearch extends DdrDiamondSearchOxSearch_parent
{

    /**
     * Overridden parent (default) search method.
     * Returns a list of articles according to search parameters.
     *
     * @param mixed $sSearchParamForQuery       Search query.
     * @param mixed $sInitialSearchCat          Initial category to search in.
     * @param mixed $sInitialSearchVendor       Initial vendor to search for.
     * @param mixed $sInitialSearchManufacturer Initial Manufacturer to search for.
     * @param mixed $sSortBy                    Sort by parameter.
     *
     * @return oxArticleList
     */
    public function getSearchArticles( $sSearchParamForQuery = false, $sInitialSearchCat = false,
                                       $sInitialSearchVendor = false, $sInitialSearchManufacturer = false,
                                       $sSortBy = false )
    {
        // Search articles and get found articles IDs
        $aIds = (array) $this->_getSearchArticles(
            $sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor,
            $sInitialSearchManufacturer, $sSortBy
        );

        /** @var oxArticleList $oArtList */
        $oArtList = oxNew( 'oxArticleList' );

        if ( !empty( $aIds ) ) {

            // Load found articles
            $oArtList->loadByIds( $aIds );

            if ( ( $oArtList ) and ( $oArtList->count() > 0 ) ) {
                return $oArtList;
            }
        }

        if ( !oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'Fallback' ) ) {

            // Empty results case
            return $oArtList;
        } else {

            // Fallback to default search
            return $this->_DdrDiamondSearchOxSearch_getSearchArticles_parent(
                $sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor,
                $sInitialSearchManufacturer, $sSortBy
            );
        }
    }

    /**
     * Overridden parent (default) found articles count method.
     * Returns the amount of found articles according to search parameters.
     *
     * @param mixed $sSearchParamForQuery       Search query.
     * @param mixed $sInitialSearchCat          Initial category to search in.
     * @param mixed $sInitialSearchVendor       Initial vendor to search for.
     * @param mixed $sInitialSearchManufacturer Initial Manufacturer to search for.
     * @param bool  $blSearchFromSession        Should the search append search values from session.
     *
     * @return int
     */
    public function getSearchArticleCount( $sSearchParamForQuery = false, $sInitialSearchCat = false,
                                           $sInitialSearchVendor = false, $sInitialSearchManufacturer = false,
                                           $blSearchFromSession = true )
    {
        // Search articles and get found articles count
        $iCnt = (int) $this->_getSearchArticles(
            $sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor,
            $sInitialSearchManufacturer, false, true, $blSearchFromSession
        );

        if ( $iCnt > 0 ) {
            return $iCnt;
        } elseif ( !oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'Fallback' ) ) {

            // Empty results case
            return $iCnt;
        } else {

            // Fallback to default count search
            return $this->_DdrDiamondSearchOxSearch_getSearchArticleCount_parent(
                $sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor, $sInitialSearchManufacturer
            );
        }
    }


    /**
     * Search articles and get fount articles IDs or count of found articles.
     *
     * @param mixed $sSearchParamForQuery
     * @param mixed $sInitialSearchCat
     * @param mixed $sInitialSearchVendor
     * @param mixed $sInitialSearchManufacturer
     * @param mixed $sSortBy
     * @param bool  $blCountOnly
     * @param bool  $blSearchFromSession
     *
     * return mixed
     */
    protected function _getSearchArticles( $sSearchParamForQuery = false, $sInitialSearchCat = false,
                                           $sInitialSearchVendor = false, $sInitialSearchManufacturer = false,
                                           $sSortBy = false, $blCountOnly = false, $blSearchFromSession = true )
    {
        $sSearchParamForQuery = trim( (string) $sSearchParamForQuery );

        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        // Add filter values from session to search query
        $aFilter = (array) $oModule->getSelectedFilterValues();

        if ( !empty( $blSearchFromSession ) and !empty( $aFilter ) ) {
            $sSearchParamForQuery .= ' ' . implode( ' ', $aFilter );
        }

        if ( empty( $sSearchParamForQuery ) ) {
            return null;
        }

        // Load parser helper and find all search terms inside search query string
        /** var DdrDiamondSearchParser $oParser */
        $oParser = oxNew( 'DdrDiamondSearchParser' );
        $aTerms  = (array) $oParser->parse( $sSearchParamForQuery, (int) $oModule->getSetting( 'MaxWords' ), false );

        if ( !empty( $aTerms ) ) {

            // Get pagination and sort parameters
            $oConfig = oxRegistry::getConfig();

            // Get page number and items per page parameters
            $iPage = (int) $oConfig->getRequestParameter( 'pgNr' );
            if ( $iPage < 0 ) {
                $iPage = 0;
            }

            $iLimit = (int) $oConfig->getConfigParam( 'iNrofCatArticles' );
            if ( empty( $iLimit ) or ( $iLimit < 0 ) ) {
                $iLimit = 10;
            }

            // Load terms to article model and search for articles
            /** @var DdrDiamondSearchTerm2Article $oTerm2Article */
            $oTerm2Article = oxNew( 'DdrDiamondSearchTerm2Article' );

            $aIds = $oTerm2Article->search(
                $aTerms, trim( (string) $sInitialSearchCat ), (string) $sInitialSearchVendor,
                (string) $sInitialSearchManufacturer, (string) $this->_mapOrderBy( $sSortBy ),
                $iPage, $iLimit, $blCountOnly
            );

            // Update search terms field for search statistics
            if ( empty( $blCountOnly ) and (bool) $oModule->getSetting( 'SaveStats' ) ) {
                $this->_updateTermsStatistics( $aTerms );
            }
        }

        return $blCountOnly ? count( $aIds ) : $aIds;
    }

    /**
     * Map sort key from default oxArticles table to Diamond Search table.
     *
     * @param string $sSortBy
     *
     * @return string
     */
    protected function _mapOrderBy( $sSortBy )
    {
        $sSortBy = mb_strtoupper( trim( (string) $sSortBy ), 'UTF-8' );
        $aSort   = explode( ' ', $sSortBy );

        if ( empty( $aSort[0] ) ) {
            return '';
        }

        $sSortByMap = array(
            'OXTITLE'       => '`DDRTITLE`',
            'OXPRICE'       => '`DDRPRICE`',
            'OXVARMINPRICE' => '`DDRPRICE`',
        );

        $sSortBy = isset( $sSortByMap[$aSort[0]] ) ? $sSortByMap[$aSort[0]] : '';

        if ( !empty( $sSortBy ) ) {
            $sSortBy .= ( isset( $aSort[1] ) and $aSort[1] == 'DESC' ) ? ' DESC' : ' ASC';
        }

        return $sSortBy;
    }

    /**
     * Update terms search count statistics.
     *
     * @param array $aTerms
     *
     * @return bool
     */
    protected function _updateTermsStatistics( $aTerms )
    {
        if ( empty( $aTerms ) or !is_array( $aTerms ) ) {
            return false;
        }

        $blSearchedByOneTerm = ( count( $aTerms ) === 1 );

        foreach ( $aTerms as $sTerm ) {

            /** @var DdrDiamondSearchTerm $oTerm */
            $oTerm = oxNew( 'DdrDiamondSearchTerm' );

            if ( $oTerm->loadByTerm( $sTerm ) and $oTerm->getId() ) {
                $oTerm->addTimesSearched();

                if ( $blSearchedByOneTerm ) {
                    $oTerm->addTimesSearchedAlone();
                }

                $oTerm->save();
            }
        }

        return true;
    }


    /**
     * Parent `getSearchArticles` call.
     *
     * @codeCoverageIgnore
     *
     * @param mixed $sSearchParamForQuery
     * @param mixed $sInitialSearchCat
     * @param mixed $sInitialSearchVendor
     * @param mixed $sInitialSearchManufacturer
     * @param mixed $sSortBy
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxSearch_getSearchArticles_parent( $sSearchParamForQuery = false,
                                                                           $sInitialSearchCat = false,
                                                                           $sInitialSearchVendor = false,
                                                                           $sInitialSearchManufacturer = false,
                                                                           $sSortBy = false )
    {
        return parent::getSearchArticles(
            $sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor, $sInitialSearchManufacturer,
            $sSortBy
        );
    }

    /**
     * Parent `getSearchArticleCount` call.
     *
     * @codeCoverageIgnore
     *
     * @param mixed $sSearchParamForQuery
     * @param mixed $sInitialSearchCat
     * @param mixed $sInitialSearchVendor
     * @param mixed $sInitialSearchManufacturer
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxSearch_getSearchArticleCount_parent( $sSearchParamForQuery = false,
                                                                               $sInitialSearchCat = false,
                                                                               $sInitialSearchVendor = false,
                                                                               $sInitialSearchManufacturer = false )
    {
        return parent::getSearchArticleCount(
            $sSearchParamForQuery, $sInitialSearchCat, $sInitialSearchVendor, $sInitialSearchManufacturer
        );
    }
}
