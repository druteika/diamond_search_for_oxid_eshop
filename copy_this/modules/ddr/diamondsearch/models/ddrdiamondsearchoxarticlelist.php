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
 * Class DdrDiamondSearchOxArticle.
 * Extends oxArticleList model.
 */
class DdrDiamondSearchOxArticleList extends DdrDiamondSearchOxArticleList_parent
{

    /**
     * Load articles by given array of article OXIDs.
     *
     * @param array $aIds
     *
     * @return mixed
     */
    public function loadByIds( $aIds )
    {
        if ( empty( $aIds ) or !is_array( $aIds ) ) {
            return null;
        }

        $oDb = oxDb::getDb();

        foreach ( $aIds as $iKey => $sId ) {
            $sId = is_array( $sId ) ? reset( $sId ) : $sId;

            if ( empty( $sId ) or !is_string( $sId ) ) {
                unset( $aIds[$iKey] );
            } else {
                $aIds[$iKey] = $oDb->quote( trim( $sId ) );
            }
        }

        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE `OXID` IN (%s)",
            getViewName( 'oxarticles' ),
            implode( ', ', $aIds )
        );

        $this->selectString( $sQuery );
    }
}
