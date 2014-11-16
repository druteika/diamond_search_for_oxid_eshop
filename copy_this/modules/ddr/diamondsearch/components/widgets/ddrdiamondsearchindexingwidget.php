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
 * Class DdrDiamondSearchIndexingWidget.
 * Auto-indexing trigger.
 */
class DdrDiamondSearchIndexingWidget extends oxWidget
{

    /**
     * @var string Widget template.
     */
    protected $_sThisTemplate = 'ddrdiamondsearchindexingwidget.tpl';


    /**
     * Trigger auto-indexing run.
     */
    public function render()
    {
        /** @var DdrDiamondSearchIndexer $oIndexer */
        $oIndexer = oxNew( 'DdrDiamondSearchIndexer' );
        $oIndexer->run();

        return $this->_DdrDiamondSearchIndexingWidget_render_parent();
    }


    /**
     * Parent `render` call.
     *
     * @return null
     */
    protected function _DdrDiamondSearchIndexingWidget_render_parent()
    {
        return parent::render();
    }
}
