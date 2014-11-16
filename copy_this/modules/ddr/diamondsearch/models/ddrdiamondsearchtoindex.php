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
class DdrDiamondSearchToIndex extends oxBase
{

    /**
     * @var null|oxArticle Related article object.
     */
    protected $_oArticle = null;


    /**
     * Initialize model.
     */
    public function __construct()
    {
        parent::__construct();

        $this->init( 'ddrdiamondsearch_toindex' );

    }


    /**
     * Set article ID.
     *
     * @param string $sArticleId
     */
    public function setArticleId( $sArticleId )
    {
        $this->ddrdiamondsearch_toindex__ddrarticleid = new oxField( $sArticleId );
    }

    /**
     * Get articleID.
     *
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->ddrdiamondsearch_toindex__ddrarticleid->value;
    }

    /**
     * Set related article object and model field.
     *
     * @param oxArticle $oArticle
     */
    public function setArticle( oxArticle $oArticle )
    {
        $this->_oArticle = $oArticle;

        $this->setId( $oArticle->getId() );
    }

    /**
     * Set related article object.
     *
     * @return null|oxArticle
     */
    public function getArticle()
    {
        return $this->_oArticle;
    }


    /**
     * Overridden parent method.
     * Set current shop ID on save and automatic date.
     *
     * @return bool|string
     */
    public function save()
    {
        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $this->ddrdiamondsearch_toindex__ddrshopid    = new oxField( $oModule->getShopId() );
        $this->ddrdiamondsearch_toindex__ddrlangid    = new oxField( (int) $oModule->getLanguageId() );
        $this->ddrdiamondsearch_toindex__ddrtimestamp = new oxField( date( 'Y-m-d H:i:s' ) );

        return $this->_DdrDiamondSearchToIndex_save_parent();
    }


    /**
     * Parent `save` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchToIndex_save_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::save();
        // @codeCoverageIgnoreEnd
    }
}
