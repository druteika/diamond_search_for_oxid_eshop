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

        $aFilterValue  = (array) $this->_parseFilterValues( (string) $oConfig->getRequestParameter( 'value' ) );
        $blRemoveValue = (bool) $oConfig->getRequestParameter( 'remove' );
        $blReset       = (bool) $oConfig->getRequestParameter( 'reset' );
        $sSearchParam  = (string) $oConfig->getRequestParameter( 'searchparam' );

        // Get existing set filters from session
        $aFilter = (array) oxRegistry::get( 'DdrDiamondSearchModule' )->getSelectedFilterValues();

        if ( $blReset ) {

            // Reset all filters
            $aFilter = array();
        } elseif ( !empty( $aFilterValue ) ) {
            if ( $blRemoveValue ) {

                // Unset filter value(s)
                $aFilter = $this->_unsetFilterValues( $aFilter, $aFilterValue );
            } else {

                // Set filter value(s)
                $aFilter = $this->_setFilterValues( $aFilter, $aFilterValue );
            }
        }

        oxRegistry::getSession()->setVariable( 'ddrdiamondsearchfilter', $aFilter );

        // Redirect to search page
        oxRegistry::getUtils()->redirect(
            $oConfig->getSslShopUrl() . '?cl=search&searchparam=' . $sSearchParam
        );
    }


    /**
     * Parse filters values string separated with pipe "|" into an array of clean non-empty value.
     *
     * @param string $sFilterValue
     *
     * @return array
     */
    protected function _parseFilterValues( $sFilterValue )
    {
        $sFilterValue = rawurldecode( $sFilterValue );
        $aValues      = explode( '|', $sFilterValue );

        foreach ( $aValues as $mKey => $sValue ) {
            $sValue = trim( (string) $sValue );

            if ( empty( $sValue ) ) {
                unset( $aValues[$mKey] );
                continue;
            }

            $aValues[$mKey] = $sValue;
        }

        return $aValues;
    }

    /**
     * Unset filter values.
     *
     * @param array $aFilter
     * @param array $aValues
     *
     * @return array
     */
    protected function _unsetFilterValues( array $aFilter, array $aValues )
    {
        foreach ( $aValues as $sValue ) {
            if ( array_key_exists( $sValue, $aFilter ) ) {
                unset( $aFilter[$sValue] );
            }
        }

        return $aFilter;
    }

    /**
     * Unset filter values.
     *
     * @param array $aFilter
     * @param array $aValues
     *
     * @return array
     */
    protected function _setFilterValues( array $aFilter, array $aValues )
    {
        if ( count( $aValues ) > 1 ) {
            $aFilter = array();
        }

        foreach ( $aValues as $sValue ) {
            if ( !array_key_exists( $sValue, $aFilter ) ) {
                $aFilter[$sValue] = $sValue;
            }
        }

        return $aFilter;
    }
}
