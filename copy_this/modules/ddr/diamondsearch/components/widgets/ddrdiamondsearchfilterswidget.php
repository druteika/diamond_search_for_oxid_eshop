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
 * Class DdrDiamondSearchFiltersWidget.
 * Filters widget.
 */
class DdrDiamondSearchFiltersWidget extends oxWidget
{

    /**
     * @var string Widget template.
     */
    protected $_sThisTemplate = 'ddrdiamondsearchfilterswidget.tpl';


    /**
     * Get search query parameter values.
     *
     * @return string
     */
    public function getSearchParam()
    {
        return (string) oxRegistry::getConfig()->getRequestParameter( 'searchparam' );
    }

    /**
     * Load filter values and group by field.
     * Additionally sort values.
     *
     * @todo: Refactor this long method
     *
     * @return array
     */
    public function getFilterValues()
    {
        /** @var DdrDiamondSearchConfig $oModule */
        $oFieldsConfig = oxRegistry::get( 'DdrDiamondSearchConfig' );
        $aFields       = $oFieldsConfig->getFilterFields();

        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $aFilterValues   = array();
        $aSelectedValues = (array) $oModule->getSelectedFilterValues();

        /** @var DdrDiamondSearchFilterValueList $oFilterValueList */
        $oFilterValueList = oxNew( 'DdrDiamondSearchFilterValueList' );

        $blShowHits = (bool) $oModule->getSetting( 'HintHits' );

        if ( $oFilterValueList->loadAll() ) {
            foreach ( $oFilterValueList as $oFilterValue ) {
                $sField = $oFilterValue->getField();

                if ( !isset( $aFields[$sField] ) ) {
                    continue;
                }

                $sValue = $oFilterValue->getValue();
                $sLabel = sprintf(
                    '%s%s',
                    html_entity_decode( $sValue ),
                    ( $blShowHits ? sprintf( ' (%d)', (int) $oFilterValue->getMultiplicity() ) : '' )
                );

                if ( !empty( $sField ) and !isset( $aFilterValues[$sField] ) ) {
                    $aFilterValues[$sField] = array();
                }

                if ( !empty( $sValue ) ) {
                    $aFilterValues[$sField][$sValue] = array(
                        'value'    => $sValue, //rawurlencode( $sValue ), // Encoding done in JS
                        'label'    => $sLabel,
                        'selected' => isset( $aSelectedValues[$sValue] )
                    );

                    if ( isset( $aSelectedValues[$sValue] ) ) {
                        $aFilterValues[$sField]['__selected__'] = true;
                    }
                }
            }
        }

        $aSortedFields       = array_keys( $aFields );
        $aSortedFilterValues = array();

        foreach ( $aSortedFields as $sField ) {
            if ( !empty( $aFilterValues[$sField] ) ) {
                $aSortedFilterValues[$sField] = $aFilterValues[$sField];
                asort( $aSortedFilterValues[$sField] );
            }
        }

        return $aSortedFilterValues;
    }
}
