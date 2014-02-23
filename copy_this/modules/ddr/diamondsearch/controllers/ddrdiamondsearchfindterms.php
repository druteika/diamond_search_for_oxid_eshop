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
 * Class DdrDiamondSearchFindTerms.
 * JSON type controller for terms search.
 */
class DdrDiamondSearchFindTerms extends oxUBase
{

    /**
     * Render JSON response for found terms.
     * Useful fro search field auto-complete.
     *
     * @return mixed
     */
    public function render()
    {
        $aData = array();

        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $blShowHits   = (bool) $oModule->getSetting( 'HintHits' );
        $sSearchQuery = oxRegistry::getConfig()->getRequestParameter( 'term' );

        if ( empty( $sSearchQuery ) ) {
            return $this->_jsonResponse();
        }

        /** @var DdrDiamondSearchTermList $oTerm */
        $oTerms = oxNew( 'DdrDiamondSearchTermList' );
        $oTerms->search( $sSearchQuery, (int) $oModule->getSetting( 'MaxHints' ) );
        $aTerms = $oTerms->getArray();

        if ( !empty( $aTerms ) and is_array( $aTerms ) ) {
            foreach ( $aTerms as $oTerm ) {
                $sTerm = (string) $oTerm->getTerm();

                if ( !empty( $sTerm ) ) {
                    $aData[] = $blShowHits ?
                        array(
                            'label' => sprintf( '%s (%d)', $sTerm, (int) $oTerm->getDiversity() ),
                            'value' => $sTerm,
                        ) :
                        $sTerm;
                }
            }
        }

        return $this->_jsonResponse( $aData );
    }


    /**
     * Print out JSON data and exit.
     *
     * @param array $aData
     */
    protected function _jsonResponse( $aData = array() )
    {
        print json_encode( $aData );
        exit;
    }
}
