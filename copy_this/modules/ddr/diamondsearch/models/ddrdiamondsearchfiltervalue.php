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
 * @version       0.2.2 RC3
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchFilterValue.
 * A model for saving search terms relations to search fields.
 */
class DdrDiamondSearchFilterValue extends DdrDiamondSearchOxBase
{

    /**
     * Initialize model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init( 'ddrdiamondsearch_filtervalues' );
    }


    /**
     * Set search field name.
     *
     * @param string $sField
     */
    public function setField( $sField )
    {
        $this->ddrdiamondsearch_filtervalues__ddrfield = new oxField( (string) $sField );
    }

    /**
     * Get search field name.
     *
     * @return mixed
     */
    public function getField()
    {
        return $this->ddrdiamondsearch_filtervalues__ddrfield->value;
    }

    /**
     * Set search field value.
     *
     * @param string $sValue
     */
    public function setValue( $sValue )
    {
        $this->ddrdiamondsearch_filtervalues__ddrvalue = new oxField( (string) $sValue );
    }

    /**
     * Get search field value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->ddrdiamondsearch_filtervalues__ddrvalue->value;
    }

    /**
     * Set how many article use the parameter.
     *
     * @param integer $iMultiplicity
     */
    public function setMultiplicity( $iMultiplicity )
    {
        $this->ddrdiamondsearch_filtervalues__ddrmultiplicity = new oxField( (int) $iMultiplicity );
    }

    /**
     * Get how many article use the parameter.
     *
     * @return mixed
     */
    public function getMultiplicity()
    {
        return $this->ddrdiamondsearch_filtervalues__ddrmultiplicity->value;
    }

    /**
     * Get date and time, when the filter value was indexed first time.
     *
     * @return null|string
     */
    public function getFirstIndexedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_filtervalues__ddrfirstindexedat->value ) and
             ( $this->ddrdiamondsearch_filtervalues__ddrfirstindexedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_filtervalues__ddrfirstindexedat->value;
        }

        return $sDateTime;
    }

    /**
     * Get date and time, when the filter value was indexed last time.
     *
     * @return null|string
     */
    public function getLastIndexedAt()
    {
        $sDateTime = null;

        if ( !empty( $this->ddrdiamondsearch_filtervalues__ddrlastindexedat->value ) and
             ( $this->ddrdiamondsearch_filtervalues__ddrlastindexedat->value != '0000-00-00 00:00:00' )
        ) {
            $sDateTime = $this->ddrdiamondsearch_filtervalues__ddrlastindexedat->value;
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

        if ( !$this->getId() ) {

            /** @var DdrDiamondSearchModule $oModule */
            $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

            // On first save, set first index date and time, shop and language IDs
            $this->ddrdiamondsearch_filtervalues__ddrfirstindexedat = new oxField( $sDateTime );
            $this->ddrdiamondsearch_filtervalues__ddrshopid         = new oxField( $oModule->getShopId() );
            $this->ddrdiamondsearch_filtervalues__ddrlangid         = new oxField( (int) $oModule->getLanguageId() );
        }

        // Set last indexed date and time
        $this->ddrdiamondsearch_filtervalues__ddrlastindexedat = new oxField( $sDateTime );

        return $this->_DdrDiamondSearchFilterValue_save_parent();
    }

    /**
     * Load filter value entry by the unique relation key: DDRFIELD - DDRVALUE.
     *
     * @param string $sField
     * @param string $sValue
     *
     * @return bool
     */
    public function loadFilterValue( $sField, $sValue )
    {
        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE %s `DDRFIELD` = %s AND `DDRVALUE` = %s LIMIT 1",
            $this->getCoreTableName(),
            $this->getShopAndLanguageSnippet(),
            $this->quote( trim( (string) $sField ) ),
            $this->quote( trim( (string) $sValue ) )
        );

        return $this->assignRecord( $sQuery );
    }


    /**
     * Parent `save` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchFilterValue_save_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::save();
        // @codeCoverageIgnoreEnd
    }
}
