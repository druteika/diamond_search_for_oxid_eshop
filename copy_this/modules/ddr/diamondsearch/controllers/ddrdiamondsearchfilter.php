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
 * @version       0.3.1 CE
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchFilter.
 * Filters based search and filters session handling.
 */
class DdrDiamondSearchFilter extends oxUBase
{

    /**
     * Get request parameters to set/unset filters in session.
     */
    public function filter()
    {
        $oConfig = oxRegistry::getConfig();

        $sFilterValue  = (string) $oConfig->getRequestParameter( 'value' );
        $blRemoveValue = (bool) $oConfig->getRequestParameter( 'remove' );
        $blReset       = (bool) $oConfig->getRequestParameter( 'reset' );
        $sSearchParam  = (string) $oConfig->getRequestParameter( 'searchparam' );

        // Get existing set filters from session
        $aFilter = (array) oxRegistry::get( 'DdrDiamondSearchModule' )->getSelectedFilterValues();

        if ( $blReset ) {

            // Reset all filters
            $aFilter = array();
        } elseif ( !empty( $sFilterValue ) ) {
            if ( $blRemoveValue ) {

                // Unset filter value
                unset( $aFilter[$sFilterValue] );
            } elseif ( !isset( $aFilter[$sFilterValue] ) ) {

                // Set filter value
                $aFilter[$sFilterValue] = $sFilterValue;
            }
        }

        oxRegistry::getSession()->setVariable( 'ddrdiamondsearchfilter', $aFilter );

        // Redirect to search page
        oxRegistry::getUtils()->redirect(
            $oConfig->getSslShopUrl() . '?cl=search&searchparam=' . $sSearchParam
        );
    }
}
