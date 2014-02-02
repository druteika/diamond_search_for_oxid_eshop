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
 * Class DdrDiamondSearchOxcmpShop.
 * Extended shop component.
 */
class DdrDiamondSearchOxcmpShop extends DdrDiamondSearchOxcmpShop_parent
{

    /**
     * Overridden parent method.
     * On each shop load indexes a bundle of articles.
     *
     * @return mixed
     */
    public function render()
    {
        /** @var DdrDiamondSearchIndexer $oToIndexList */
        $oIndexer = oxNew( 'DdrDiamondSearchIndexer' );
        $oIndexer->run();

        return $this->_DdrDiamondSearchOxcmpShop_render_parent();
    }

    /**
     * Parent `render` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxcmpShop_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
