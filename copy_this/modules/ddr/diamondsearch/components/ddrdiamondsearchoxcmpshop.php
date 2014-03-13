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
 * @version       0.2.1 RC2
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchOxcmpShop.
 * Extended shop component.
 *
 * @see oxcmp_shop
 */
class DdrDiamondSearchOxcmpShop extends DdrDiamondSearchOxcmpShop_parent
{

    /**
     * Overridden parent method.
     * On each shop load indexes a bundle of articles.
     *
     * @return mixed
     */
    public function init()
    {
        /** @var DdrDiamondSearchIndexer $oIndexer */
        $oIndexer = oxNew( 'DdrDiamondSearchIndexer' );
        $oIndexer->run();

        // Force session start
        oxRegistry::getConfig()->setConfigParam( 'blForceSessionStart', true );

        return $this->_DdrDiamondSearchOxcmpShop_init_parent();
    }

    /**
     * Parent `render` call.
     *
     * @codeCoverageIgnore
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxcmpShop_init_parent()
    {
        parent::init();
    }
}
