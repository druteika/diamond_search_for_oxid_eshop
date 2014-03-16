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
 * Class DdrDiamondSearchSearch.
 * Extended Search controller.
 *
 * @see Search
 */
class DdrDiamondSearchSearch extends DdrDiamondSearchSearch_parent
{

    /**
     * Overridden parent method.
     * Adding a fix allowing search to pass till filters even with no search query.
     */
    public function init()
    {
        $oConfig = oxRegistry::getConfig();

        $sSearchQuery    = $oConfig->getRequestParameter( 'searchparam', true );
        $sSearchCategory = $oConfig->getRequestParameter( 'searchcnid', true );

        // If search parameters are empty, set category parameter to make parent init pass further.
        if ( empty( $sSearchQuery ) and empty( $sSearchCategory ) ) {
            $_GET['searchcnid'] = ' ';
        }

        $this->_DdrDiamondSearchSearch_init_parent();
    }


    /**
     * Parent `init` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchSearch_init_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::init();
        // @codeCoverageIgnoreEnd
    }
}
