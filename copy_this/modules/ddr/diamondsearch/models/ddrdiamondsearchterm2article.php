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
 * @version       0.1.0 beta
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchTerm2Article.
 * A model for saving search terms relations to articles.
 */
class DdrDiamondSearchTerm2Article extends DdrDiamondSearchOxBase
{

    /**
     * Initialize model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init( 'ddrdiamondsearch_term2article' );
    }


    /**
     * Set search term ID (PK of DdrDiamondSearchTerm).
     *
     * @param string $sTermId
     */
    public function setTermId( $sTermId )
    {
        $this->ddrdiamondsearch_term2article__ddrtermid = new oxField( (string) $sTermId );
    }

    /**
     * Get search term ID (PK of DdrDiamondSearchTerm).
     *
     * @return mixed
     */
    public function getTermId()
    {
        return $this->ddrdiamondsearch_term2article__ddrtermid->value;
    }

    /**
     * Set article ID.
     *
     * @param string $sArticleId
     */
    public function setArticleId( $sArticleId )
    {
        $this->ddrdiamondsearch_term2article__ddrarticleid = new oxField( (string) $sArticleId );
    }

    /**
     * Get article ID.
     *
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->ddrdiamondsearch_term2article__ddrarticleid->value;
    }

    /**
     * Set article category ID.
     *
     * @param string $sCategoryId
     */
    public function setCategoryId( $sCategoryId )
    {
        $this->ddrdiamondsearch_term2article__ddrcategoryid = new oxField( (string) $sCategoryId );
    }

    /**
     * Get article category ID.
     *
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->ddrdiamondsearch_term2article__ddrcategoryid->value;
    }

    /**
     * Set article vendor ID.
     *
     * @param string $sVendorId
     */
    public function setVendorId( $sVendorId )
    {
        $this->ddrdiamondsearch_term2article__ddrvendorid = new oxField( (string) $sVendorId );
    }

    /**
     * Get article vendor ID.
     *
     * @return mixed
     */
    public function getVendorId()
    {
        return $this->ddrdiamondsearch_term2article__ddrvendorid->value;
    }

    /**
     * Set article manufacturer ID.
     *
     * @param string $sManufacturerId
     */
    public function setManufacturerId( $sManufacturerId )
    {
        $this->ddrdiamondsearch_term2article__ddrmanufacturerid = new oxField( (string) $sManufacturerId );
    }

    /**
     * Get article manufacturer ID.
     *
     * @return mixed
     */
    public function getManufacturerId()
    {
        return $this->ddrdiamondsearch_term2article__ddrmanufacturerid->value;
    }

    /**
     * Set article title.
     *
     * @param string $sTitle
     */
    public function setTitle( $sTitle )
    {
        $this->ddrdiamondsearch_term2article__ddrtitle = new oxField( (string) $sTitle );
    }

    /**
     * Get article title.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->ddrdiamondsearch_term2article__ddrtitle->value;
    }

    /**
     * Set article title.
     *
     * @param double $fPrice
     */
    public function setPrice( $fPrice )
    {
        $this->ddrdiamondsearch_term2article__ddrprice = new oxField( (double) $fPrice );
    }

    /**
     * Get article title.
     *
     * @return mixed
     */
    public function getPrice()
    {
        return $this->ddrdiamondsearch_term2article__ddrprice->value;
    }

    /**
     * Set term multiplicity parameter for an article.
     *
     * @param integer $iMultiplicity
     */
    public function setMultiplicity( $iMultiplicity )
    {
        $this->ddrdiamondsearch_term2article__ddrmultiplicity = new oxField( (int) $iMultiplicity );
    }

    /**
     * Get term multiplicity parameter for an article.
     *
     * @return mixed
     */
    public function getMultiplicity()
    {
        return $this->ddrdiamondsearch_term2article__ddrmultiplicity->value;
    }

    /**
     * Set term relevance parameter for an article.
     *
     * @param integer $iRelevance
     */
    public function setRelevance( $iRelevance )
    {
        $this->ddrdiamondsearch_term2article__ddrrelevance = new oxField( (int) $iRelevance );
    }

    /**
     * Get term relevance parameter for an article.
     *
     * @return mixed
     */
    public function getRelevance()
    {
        return $this->ddrdiamondsearch_term2article__ddrrelevance->value;
    }

    /**
     * Get date and time, when the article was indexed first time.
     *
     * @return null|string
     */
    public function getFirstIndexedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_term2article__ddrfirstindexedat->value ) and
             ( $this->ddrdiamondsearch_term2article__ddrfirstindexedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_term2article__ddrfirstindexedat->value;
        }

        return $sDateTime;
    }

    /**
     * Get date and time, when the article was indexed last time.
     *
     * @return null|string
     */
    public function getLastIndexedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_term2article__ddrlastindexedat->value ) and
             ( $this->ddrdiamondsearch_term2article__ddrlastindexedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_term2article__ddrlastindexedat->value;
        }

        return $sDateTime;
    }


    /**
     * Overridden parent method.
     * Set current shop ID on save.
     *
     * @return bool|string
     */
    public function save()
    {
        $sDateTime = date( 'Y-m-d H:i:s' );
        $oModule   = oxRegistry::get( 'DdrDiamondSearchModule' );

        $this->ddrdiamondsearch_term2article__ddrshopid = new oxField( $oModule->getShopId() );
        $this->ddrdiamondsearch_term2article__ddrlangid = new oxField( (int) $oModule->getLanguageId() );

        if ( !$this->getId() ) {

            // On first save, set first index date and time
            $this->ddrdiamondsearch_term2article__ddrfirstindexedat = new oxField( $sDateTime );
        }

        // Set last indexed date and time
        $this->ddrdiamondsearch_term2article__ddrlastindexedat = new oxField( $sDateTime );

        return $this->_DdrDiamondSearchTerm2Article_save_parent();
    }


    /**
     * Load relation entry by the unique relation key: DDRTERMID - DDRARTICLEID.
     *
     * @param string $sTermId
     * @param string $sArticleId
     *
     * @return bool
     */
    public function loadRelation( $sTermId, $sArticleId )
    {
        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE %s `DDRTERMID` = %s AND `DDRARTICLEID` = %s LIMIT 1",
            getViewName( 'ddrdiamondsearch_term2article' ),
            $this->getShopAndLanguageSnippet(),
            $this->quote( trim( (string) $sTermId ) ),
            $this->quote( trim( (string) $sArticleId ) )
        );

        return $this->assignRecord( $sQuery );
    }

    /**
     * Delete all relation for an article by article ID.
     * Works in scope of current active shop and language.
     *
     * @param string $sArticleId
     *
     * @return object
     */
    public function deleteByArticleId( $sArticleId )
    {
        $oDb    = oxDb::getDb();
        $sQuery = sprintf(
            "DELETE FROM `%s` WHERE %s `DDRARTICLEID` = %s",
            $this->getShopAndLanguageSnippet(),
            getViewName( 'ddrdiamondsearch_term2article' ),
            $oDb->quote( trim( (string) $sArticleId ) )
        );

        $oDb->execute( $sQuery );

        return $oDb->Affected_Rows();
    }

    /**
     * Find article OXIDs by search terms related to the articles.
     * Additionally search by default clauses, sets sort and pagination.
     *
     * @todo: Split to more private methods: queries building moves as separate methods.
     *
     * @param array  $aTerms
     * @param string $sInitialSearchCat
     * @param string $sInitialSearchVendor
     * @param string $sInitialSearchManufacturer
     * @param string $sSortBy
     * @param int    $iPage
     * @param int    $iLimit
     * @param bool   $blCountOnly
     *
     * @return array|null
     */
    public function search( $aTerms, $sInitialSearchCat = '', $sInitialSearchVendor = '',
                            $sInitialSearchManufacturer = '', $sSortBy = '', $iPage = 0, $iLimit = 10,
                            $blCountOnly = false )
    {
        if ( empty( $aTerms ) or !is_array( $aTerms ) ) {
            return null;
        }

        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $blLikeMatch = (bool) $oModule->getSetting( 'ByPart' );
        $blOrClause  = (bool) $oModule->getSetting( 'FindAll' );

        if ( ( count( $aTerms ) == 1 ) or $blOrClause ) {

            // One search term clause or the case to find article matching at leas one of terms
            $sQuery = sprintf(
                "SELECT DISTINCT `t2a`.`DDRARTICLEID` FROM `%s` AS `t`
                     LEFT JOIN `%s` AS `t2a` ON (`t2a`.`DDRTERMID` = `t`.`OXID`)
                WHERE %s %s `t`.`DDRTERM` IN (%s)%s",
                getViewName( 'ddrdiamondsearch_terms' ),
                getViewName( 'ddrdiamondsearch_term2article' ),
                $this->getShopAndLanguageSnippet( 't2a' ),
                $this->getShopAndLanguageSnippet( 't' ),
                implode( ', ', $this->_quoteTerms( $aTerms ) ),
                $this->_getSearchClauseSnippet( $sInitialSearchCat, $sInitialSearchVendor, $sInitialSearchManufacturer )
            );

            $sMainTableName = 't2a';
        } else {

            // A case when there are mor than one search term and search must find articles matching all the terms
            $aQueries = array();

            foreach ( $aTerms as $sTerm ) {
                $aQueries[] = sprintf(
                    "SELECT `t2a`.`DDRARTICLEID`, `t2a`.`DDRRELEVANCE` FROM `%s` AS `t`
                         LEFT JOIN `%s` AS `t2a` ON (`t2a`.`DDRTERMID` = `t`.`OXID`)
                    WHERE %s %s `t`.`DDRTERM` %s%s",
                    getViewName( 'ddrdiamondsearch_terms' ),
                    getViewName( 'ddrdiamondsearch_term2article' ),
                    $this->getShopAndLanguageSnippet( 't2a' ),
                    $this->getShopAndLanguageSnippet( 't' ),
                    ( $blLikeMatch ? " LIKE " . $this->quote( $sTerm . "%" ) : " = " . $this->quote( $sTerm ) ),
                    $this->_getSearchClauseSnippet(
                         $sInitialSearchCat, $sInitialSearchVendor, $sInitialSearchManufacturer
                    )
                );
            }
            $sQuery = sprintf(
                "SELECT `u`.* FROM ( (%s) ) AS `u` GROUP BY `DDRARTICLEID` HAVING COUNT(*) >= %d",
                implode( ") UNION ALL (", $aQueries ),
                count( $aTerms )
            );

            $sMainTableName = 'u';
        }

        if ( empty( $blCountOnly ) ) {
            $sQuery .= $this->_getOrderByAndLimitSnippet( $sMainTableName, $sSortBy, $iPage, $iLimit );
        }

        return oxDb::getDb()->getArray( $sQuery );
    }

    /**
     * Get how many articles are related to the term.
     *
     * @param string $sTerm
     *
     * @return int
     */
    public function getTimesUsed( $sTerm )
    {
        $oDb = oxDb::getDb( oxDB::FETCH_MODE_ASSOC );

        $sQuery = sprintf(
            "SELECT COUNT(`t2a`.`DDRARTICLEID`) AS `TIMES_USED`
            FROM %s AS `t` LEFT JOIN %s AS `t2a` ON (`t2a`.`DDRTERMID` = `t`.`OXID`)
            WHERE %s %s `t`.`DDRTERM` = %s",
            getViewName( 'ddrdiamondsearch_terms' ),
            getViewName( 'ddrdiamondsearch_term2article' ),
            $this->getShopAndLanguageSnippet( 't2a' ),
            $this->getShopAndLanguageSnippet( 't' ),
            $this->quote( $sTerm )
        );

        return (int) $oDb->getOne( $sQuery );
    }


    /**
     * Compiles search query clauses for category, vendor and manufacturer.
     *
     * @param string $sInitialSearchCat
     * @param string $sInitialSearchVendor
     * @param string $sInitialSearchManufacturer
     *
     * @return string
     */
    protected function _getSearchClauseSnippet( $sInitialSearchCat = '', $sInitialSearchVendor = '',
                                                $sInitialSearchManufacturer = '' )
    {
        $aClauses = array();

        if ( !empty( $sInitialSearchCat ) ) {
            $aClauses[] = sprintf( "`t2a`.`DDRCATEGORYID` = %s", $this->quote( $sInitialSearchCat ) );
        }

        if ( !empty( $sInitialSearchVendor ) ) {
            $aClauses[] = sprintf( "`t2a`.`DDRVENDORID` = %s", $this->quote( $sInitialSearchVendor ) );
        }

        if ( !empty( $sInitialSearchManufacturer ) ) {
            $aClauses[] = sprintf( "`t2a`.`DDRMANUFACTURERID` = %s", $this->quote( $sInitialSearchManufacturer ) );
        }

        return ( !empty( $aClauses ) ? implode( " AND ", $aClauses ) : "" );
    }

    /**
     * Compiles search query order by clause and limit.
     *
     * @param string $sTable
     * @param string $sSortBy
     * @param int    $iPage
     * @param int    $iLimit
     *
     * @return string
     */
    protected function _getOrderByAndLimitSnippet( $sTable, $sSortBy = '', $iPage = 0, $iLimit = 10 )
    {
        return sprintf(
            " ORDER BY %s`%s`.`DDRRELEVANCE` DESC LIMIT %d, %d",
            ( !empty( $sSortBy ) ? $sSortBy . ", " : "" ), // TODO: Sort has some bugs...
            (string) $sTable,
            ( (int) $iPage * (int) $iLimit ),
            (int) $iLimit
        );
    }

    /**
     * Check and quote search terms to use in LIKE clause.
     *
     * @param array $aTerms
     *
     * @return array
     */
    protected function _quoteTerms( $aTerms )
    {
        if ( empty( $aTerms ) or !is_array( $aTerms ) ) {
            return array();
        }

        $oDb = oxDb::getDb();

        foreach ( $aTerms as $iKey => $sTerm ) {
            if ( empty( $sTerm ) or !is_string( $sTerm ) ) {
                unset( $aTerms[$iKey] );
            } else {
                $aTerms[$iKey] = $oDb->quote( trim( $sTerm ) );
            }
        }

        return $aTerms;
    }


    /**
     * Parent `save` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchTerm2Article_save_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::save();
        // @codeCoverageIgnoreEnd
    }
}
