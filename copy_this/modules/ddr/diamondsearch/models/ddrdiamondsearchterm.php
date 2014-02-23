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
 * @version       0.2.0 RC1
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchTerm.
 * A model for saving search terms index.
 */
class DdrDiamondSearchTerm extends DdrDiamondSearchOxBase
{

    /**
     * Initialize model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init( 'ddrdiamondsearch_terms' );
    }


    /**
     * Set search term value.
     *
     * @param string $sTerm
     */
    public function setTerm( $sTerm )
    {
        $this->ddrdiamondsearch_terms__ddrterm = new oxField( $sTerm );
    }

    /**
     * Get search term value.
     *
     * @return mixed
     */
    public function getTerm()
    {
        return $this->ddrdiamondsearch_terms__ddrterm->value;
    }

    /**
     * Get how many times term was indexed.
     *
     * @return int
     */
    public function getMultiplicity()
    {
        return (int) $this->ddrdiamondsearch_terms__ddrmultiplicity->value;
    }

    /**
     * Set multiplicity increased by one.
     */
    public function addMultiplicity()
    {
        $iMultiplicity = (int) $this->getMultiplicity();

        if ( !empty( $iMultiplicity ) ) {
            $this->ddrdiamondsearch_terms__ddrmultiplicity = new oxField( ++$iMultiplicity );
        }
    }

    /**
     * Get how many times term was indexed (used) in different articles.
     *
     * @return int
     */
    public function getDiversity()
    {
        return (int) $this->ddrdiamondsearch_terms__ddrdiversity->value;
    }

    /**
     * Set how many times term was indexed (used) in different articles.
     *
     * @param (int) $iDiversity
     */
    public function setDiversity( $iDiversity )
    {
        $this->ddrdiamondsearch_terms__ddrdiversity = new oxField( (int) $iDiversity );
    }

    /**
     * Set diversity increased by one.
     */
    public function addDiversity()
    {
        $iDiversity = (int) $this->getDiversity();

        if ( !empty( $iDiversity ) ) {
            $this->ddrdiamondsearch_terms__ddrdiversity = new oxField( ++$iDiversity );
        }
    }

    /**
     * Get date and time, when the term was indexed first time.
     *
     * @return null|string
     */
    public function getFirstIndexedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_terms__ddrfirstindexedat->value ) and
             ( $this->ddrdiamondsearch_terms__ddrfirstindexedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_terms__ddrfirstindexedat->value;
        }

        return $sDateTime;
    }

    /**
     * Get date and time, when the term was indexed/updated last time.
     *
     * @return null|string
     */
    public function getLastIndexedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_terms__ddrlastindexedat->value ) and
             ( $this->ddrdiamondsearch_terms__ddrlastindexedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_terms__ddrlastindexedat->value;
        }

        return $sDateTime;
    }

    /**
     * Get how many times term was searched for.
     *
     * @return int
     */
    public function getTimesSearched()
    {
        return (int) $this->ddrdiamondsearch_terms__ddrtimessearched->value;
    }

    /**
     * Set times searched value increased by one.
     */
    public function addTimesSearched()
    {
        $iTimesSearched = (int) $this->getTimesSearched();

        $this->ddrdiamondsearch_terms__ddrtimessearched = new oxField( ++$iTimesSearched );
    }

    /**
     * Get how many times term was searched for alone (with only this one term in search query).
     *
     * @return int
     */
    public function getTimesSearchedAlone()
    {
        return (int) $this->ddrdiamondsearch_terms__ddrtimessearchedaalone->value;
    }

    /**
     * Set times searched alone value increased by one.
     */
    public function addTimesSearchedAlone()
    {
        $iTimesSearchedAlone = (int) $this->getTimesSearchedAlone();

        $this->ddrdiamondsearch_terms__ddrtimessearchedaalone = new oxField( ++$iTimesSearchedAlone );
    }

    /**
     * Get date and time, when the term was last searched for.
     *
     * @return null|string
     */
    public function getLastSearchedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_terms__ddrlastsearchedat->value ) and
             ( $this->ddrdiamondsearch_terms__ddrlastsearchedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_terms__ddrlastsearchedat->value;
        }

        return $sDateTime;
    }


    /**
     * Overridden parent method.
     * Set current shop ID and automatic dates on save.
     *
     * @return bool|string
     */
    public function save( $blSearchUpdate = true )
    {
        $sDateTime = date( 'Y-m-d H:i:s' );

        if ( $this->getId() ) {
            if ( !empty( $blSearchUpdate ) ) {

                // For update on searching for the term, set last searched date and time
                $this->ddrdiamondsearch_terms__ddrlastsearchedat = new oxField( $sDateTime );
            } else {

                // For other (indexing, modifying) update, set last indexed date and time
                $this->ddrdiamondsearch_terms__ddrlastindexedat = new oxField( $sDateTime );
            }
        } else {

            /** @var DdrDiamondSearchModule $oModule */
            $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

            // On first save, set first index date and time, language and shop IDs
            $this->ddrdiamondsearch_terms__ddrfirstindexedat = new oxField( $sDateTime );
            $this->ddrdiamondsearch_terms__ddrshopid         = new oxField( $oModule->getShopId() );
            $this->ddrdiamondsearch_terms__ddrlangid         = new oxField( (int) $oModule->getLanguageId() );
        }

        return $this->_DdrDiamondSearchTerm_save_parent();
    }


    /**
     * Load term object by the unique search term value.
     *
     * @param string $sTerm
     *
     * @return bool
     */
    public function loadByTerm( $sTerm )
    {
        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE %s `DDRTERM` = %s LIMIT 1",
            $this->getCoreTableName(),
            $this->getShopAndLanguageSnippet(),
            oxDb::getDb()->quote( trim( (string) $sTerm ) )
        );

        return $this->assignRecord( $sQuery );
    }


    /**
     * Parent `save` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchTerm_save_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::save();
        // @codeCoverageIgnoreEnd
    }
}
