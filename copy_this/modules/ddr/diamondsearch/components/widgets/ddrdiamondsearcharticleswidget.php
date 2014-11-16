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
 * Class DdrDiamondSearchArticlesWidget.
 * Promotion articles list widget.
 *
 * Usage
 *  - Default list based on module configuration in eShop back end:
 *      [{oxid_include_widget cl="DdrDiamondSearchArticlesWidget"}]
 *
 *  - Custom widget with based on given search request and title
 *      [{oxid_include_widget cl="DdrDiamondSearchArticlesWidget" query="My search query" title="MY_TRANSLATION"}]
 *
 *   -- query: It is just a search query, test it in eShop search field.
 *             If not present, default values from module settings is used.
 *             If empty, widget will not be shown.
 *   -- title: It is a translation string for box heading.
 *             If not present, default values from module settings is used.
 *             If empty, title is just no shown.
 */
class DdrDiamondSearchArticlesWidget extends oxWidget
{

    /**
     * @var string Widget template.
     */
    protected $_sThisTemplate = 'ddrdiamondsearcharticleswidget.tpl';


    /**
     * Get widget box title.
     *
     * @return string
     */
    public function getBoxTitle()
    {
        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $mTitle = $this->getViewParam( 'title' );

        if ( is_null( $mTitle ) ) {
            $mTitle = (string) $oModule->getSetting( 'PromoTitle' );
        } else {
            $mTitle = (string) $oModule->translate( $mTitle, false );
        }

        return $mTitle;
    }

    /**
     * Get articles filtered by a query from widget parameters or a value in settings.
     *
     * @return oxArticleList|DdrDiamondSearchOxArticleList|null
     */
    public function getArticles()
    {
        $mQuery = $this->getViewParam( 'query' );

        if ( is_null( $mQuery ) ) {
            /** @var DdrDiamondSearchModule $oModule */
            $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );
            $mQuery  = (string) $oModule->getSetting( 'PromoQuery' );
        }

        if ( empty( $mQuery ) ) {
            return null;
        }

        /** @var DdrDiamondSearchOxSearch $oSearch */
        $oSearch      = oxNew( 'DdrDiamondSearchOxSearch' );
        $oArticleList = $oSearch->getArticlesByQuery( $mQuery );

        return $oArticleList;
    }


    /**
     * Get widget parameter passes as the widget tag attribute value.
     *
     * @param string $sKey
     *
     * @return string|null
     */
    protected function getViewParam( $sKey )
    {
        return array_key_exists( $sKey, $this->_aViewParams ) ? (string) $this->_aViewParams[$sKey] : null;
    }
}
