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
 * Class DdrDiamondSearchTerm2Field.
 * A model for saving search terms relations to search fields.
 *
 * NOTE: Now only stores relation data.
 *
 * @todo: Implement more functions later, etc. for facet filters.
 */
class DdrDiamondSearchTerm2Field extends DdrDiamondSearchOxBase
{

    /**
     * Initialize model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init( 'ddrdiamondsearch_term2field' );
    }


    /**
     * Set search term ID (PK of DdrDiamondSearchTerm).
     *
     * @param string $sTermId
     */
    public function setTermId( $sTermId )
    {
        $this->ddrdiamondsearch_term2field__ddrtermid = new oxField( (string) $sTermId );
    }

    /**
     * Get search term ID (PK of DdrDiamondSearchTerm).
     *
     * @return mixed
     */
    public function getTermId()
    {
        return $this->ddrdiamondsearch_term2field__ddrtermid->value;
    }

    /**
     * Set search field name.
     *
     * @param string $sField
     */
    public function setField( $sField )
    {
        $this->ddrdiamondsearch_term2field__ddrfield = new oxField( (string) $sField );
    }

    /**
     * Get search field name.
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->ddrdiamondsearch_term2field__ddrfield->value;
    }


    /**
     * Overridden parent method.
     * Set current shop ID on save.
     *
     * @return bool|string
     */
    public function save()
    {
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $this->ddrdiamondsearch_term2field__ddrshopid = new oxField( $oModule->getShopId() );
        $this->ddrdiamondsearch_term2field__ddrlangid = new oxField( (int) $oModule->getLanguageId() );

        return $this->_DdrDiamondSearchTerm2Field_save_parent();
    }

    /**
     * Load relation entry by the unique relation key: DDRTERMID - DDRFIELD.
     *
     * @param string $sTermId
     * @param string $sField
     *
     * @return bool
     */
    public function loadRelation( $sTermId, $sField )
    {
        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE %s `DDRTERMID` = %s AND `DDRFIELD` = %s LIMIT 1",
            getViewName( 'ddrdiamondsearch_term2field' ),
            $this->getShopAndLanguageSnippet(),
            $this->quote( trim( (string) $sTermId ) ),
            $this->quote( trim( (string) $sField ) )
        );

        return $this->assignRecord( $sQuery );
    }


    /**
     * Parent `save` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchTerm2Field_save_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::save();
        // @codeCoverageIgnoreEnd
    }
}
