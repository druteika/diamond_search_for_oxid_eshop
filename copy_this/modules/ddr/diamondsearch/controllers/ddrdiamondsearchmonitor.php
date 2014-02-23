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
 * Class DdrDiamondSearchMonitor.
 * Diamond Search dashboard page controller.
 */
class DdrDiamondSearchMonitor extends Account
{

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

        if ( !( $oUser instanceof oxUser ) or !$oUser->getId() or
             ( $oUser->oxuser__oxrights->value !== 'malladmin' )
        ) {

            // Only admin may access the page
            oxRegistry::getUtils()->redirect( oxRegistry::getConfig()->getShopHomeUrl() );
        }

        return $this->_DdrDiamondSearchMonitor_render_parent();
    }

    /**
     * Get index queue total items count.
     *
     * @return int
     */
    public function getQueueSize()
    {
        return (int) oxDb::getDb( oxDB::FETCH_MODE_ASSOC )
                         ->getOne( 'SELECT COUNT(`OXID`) FROM `ddrdiamondsearch_toindex` WHERE 1' );
    }

    /**
     * Get total search terms count.
     *
     * @return int
     */
    public function getTermsCount()
    {
        return (int) oxDb::getDb( oxDB::FETCH_MODE_ASSOC )
                         ->getOne( 'SELECT COUNT(`OXID`) FROM `ddrdiamondsearch_terms` WHERE 1' );
    }


    /**
     * Parent `render` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchMonitor_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
