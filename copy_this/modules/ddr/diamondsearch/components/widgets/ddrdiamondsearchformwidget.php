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
 * Class DdrDiamondSearchFormWidget.
 * Advanced search form widget.
 */
class DdrDiamondSearchFormWidget extends oxWidget
{

    /**
     * @var string Widget template.
     */
    protected $_sThisTemplate = 'ddrdiamondsearchformwidget.tpl';


    /**
     * Load fields for advance search form.
     * Additionally sort values.
     *
     * @return array
     */
    public function getFormValues()
    {
        /** @var DdrDiamondSearchConfig $oModule */
        $oFieldsConfig = oxRegistry::get( 'DdrDiamondSearchConfig' );
        $aFields       = $oFieldsConfig->getAdvancedSearchFields();

        $aFormValues = array();

        /** @var DdrDiamondSearchFilterValueList $oFilterValueList */
        $oFilterValueList = oxNew( 'DdrDiamondSearchFilterValueList' );

        if ( $oFilterValueList->loadAll() ) {
            foreach ( $oFilterValueList as $oFilterValue ) {
                $sField = $oFilterValue->getField();

                if ( !isset( $aFields[$sField] ) ) {
                    continue;
                }

                $sValue = $oFilterValue->getValue();
                $sLabel = html_entity_decode( $sValue );

                if ( !empty( $sField ) and !isset( $aFormValues[$sField] ) ) {
                    $aFormValues[$sField] = array();
                }

                if ( !empty( $sValue ) ) {
                    $aFormValues[$sField][$sValue] = array(
                        'value' => $sValue,
                        'label' => $sLabel,
                    );
                }
            }
        }

        $aSortedFields       = array_keys( $aFields );
        $aSortedFilterValues = array();

        foreach ( $aSortedFields as $sField ) {
            if ( !empty( $aFormValues[$sField] ) ) {
                $aSortedFilterValues[$sField] = $aFormValues[$sField];
                asort( $aSortedFilterValues[$sField] );
            }
        }

        return $aSortedFilterValues;
    }
}
