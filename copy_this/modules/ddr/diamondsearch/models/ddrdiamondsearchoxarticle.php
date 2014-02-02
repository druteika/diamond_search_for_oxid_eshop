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
 * Extends oxArticle model.
 */
class DdrDiamondSearchOxArticle extends DdrDiamondSearchOxArticle_parent
{

    /**
     * Parse article fields for search terms.
     *
     * @param null|string $sId
     *
     * @return boolean|array
     */
    public function parseArticleTerms( $sId = null )
    {
        if ( !empty( $sId ) and is_string( $sId ) ) {
            $this->load( $sId );
        }

        if ( !$this->getId() ) {
            return false;
        }

        $aSearchFields = oxRegistry::get( 'DdrDiamondSearchConfig' )->getSearchFields();

        if ( empty( $aSearchFields ) or !is_array( $aSearchFields ) ) {
            return false;
        }

        // Pre-load related object
        $this->getCategory();
        $this->getAttributes();

        $aTerms = array();

        foreach ( $aSearchFields as $sFieldName => $aFieldParams ) {
            $sFieldValue = $this->_getFieldValue( $aFieldParams );

            if ( !empty( $sFieldValue ) ) {
                $aTerms = $this->_parseFieldTerms( $sFieldName, $aFieldParams, $sFieldValue, $aTerms );
            }
        }

        return $aTerms;
    }


    /**
     * Overridden parent method.
     * Add/remove article to (re-)indexing queue depending on article status.
     *
     * @return mixed
     */
    public function save()
    {
        $mResult = $this->_DdrDiamondSearchOxArticle_save_parent();

        if ( !empty( $mResult ) ) {

            // Add article to indexing queue by OXID on successful save
            /** var DdrDiamondSearchToIndex $oToIndex */
            $oToIndex = oxNew( 'DdrDiamondSearchToIndex' );

            if ( !$oToIndex->load( $mResult ) ) {
                $oToIndex->setId( $mResult );
            }

            if ( !empty( $this->oxarticles__oxactive->value ) ) {

                // If article is active, add it to indexing queue
                $oToIndex->save();
            } else {

                // If article is not active, remove it from indexing queue
                $oToIndex->delete();
            }
        }

        return $mResult;
    }

    /**
     * Overridden parent method.
     * Remove article from indexing queue and term relations.
     *
     * @param string $sId
     *
     * @return mixed
     */
    public function delete( $sId = null )
    {
        $sDeleteId = !empty( $sId ) ? $sId : $this->getId();

        $mResult = $this->_DdrDiamondSearchOxArticle_delete_parent( $sId );

        if ( !empty( $mResult ) and !empty( $sDeleteId ) ) {

            // Remove article from index queue and article to term relations
            /** var DdrDiamondSearchToIndex $oToIndex */
            $oToIndex = oxNew( 'DdrDiamondSearchToIndex' );
            $oToIndex->delete( $sDeleteId );

            /** var DdrDiamondSearchTerm2Article $oTermToArticle */
            $oTermToArticle = oxNew( 'DdrDiamondSearchTerm2Article' );
            $oTermToArticle->deleteByArticleId( $sDeleteId );
        }

        return $mResult;
    }


    /**
     * Get article-related field value.
     *
     * @param array $aParams
     *
     * @return string
     */
    protected function _getFieldValue( $aParams )
    {
        $sValue = '';

        /** @var DdrDiamondSearchParser $oParser */
        $oParser = oxRegistry::get( 'DdrDiamondSearchParser' );

        $sTable = $oParser->getArrayStringField( $aParams, 'table' );
        $sName  = $oParser->getArrayStringField( $aParams, 'field' );
        $sId    = $oParser->getArrayStringField( $aParams, 'id' );

        switch ( $sTable ) {
            case 'oxarticles':
                $oObject = $this;
                break;

            case 'oxcategories':
                $oObject = $this->getCategory();
                break;

            case 'oxvendor':
                $oObject = $this->getVendor();
                break;

            case 'oxmanufacturers':
                $oObject = $this->getManufacturer();
                break;

            case 'oxattribute':
                $oAttributesList = $this->getAttributes();
                $aAttributesList = !empty( $oAttributesList ) ? $oAttributesList->getArray() : array();
                $oObject         = !empty( $aAttributesList[$sId] ) ? $aAttributesList[$sId] : null;
                break;

            default:
                return $sValue;
        }

        $sField = sprintf( '%s__%s', $sTable, $sName );
        $sValue = !empty( $oObject->$sField->value ) ?
            (string) $oObject->$sField->value :
            '';

        return $sValue;
    }

    /**
     * Extract search terms from a field.
     *
     * @param string $sFieldName
     * @param array  $aFieldParams Field parameters array. Param "weight" is required.
     * @param string $sFieldValue
     * @param array  $aTerms
     *
     * @return array
     */
    protected function _parseFieldTerms( $sFieldName, $aFieldParams,
                                         $sFieldValue, $aTerms = array() )
    {
        if ( empty( $sFieldName ) or !is_string( $sFieldName ) or
             empty( $aFieldParams['weight'] ) or
             !is_integer( $aFieldParams['weight'] )
        ) {
            return $aTerms;
        }

        // Load parser helper
        /** var DdrDiamondSearchParser $oParser */
        $oParser = oxNew( 'DdrDiamondSearchParser' );

        if ( $oParser->getArrayStringField( $aFieldParams, 'flag', false, false ) == '_DDR_NO_SPLIT_' ) {

            // If "no split" isset, just use the field value as it is.
            $aTerms[] = array(
                'field'  => mb_strtoupper( trim( $sFieldName ), 'UTF-8' ),
                'value'  => $oParser->cleanString( $sFieldValue, false ),
                'weight' => (int) $aFieldParams['weight'],
            );

            return $aTerms;
        }

        // find all search terms inside field value.
        $aStrings = $oParser->parse( $sFieldValue );

        if ( !empty( $aStrings ) and is_array( $aStrings ) ) {
            foreach ( $aStrings as $sString ) {
                if ( !empty( $sString ) and is_string( $sString ) )
                    $aTerms[] = array(
                        'field'  => mb_strtoupper( trim( $sFieldName ), 'UTF-8' ),
                        'value'  => $sString,
                        'weight' => (int) $aFieldParams['weight'],
                    );
            }
        }

        return $aTerms;
    }

    /**
     * Parent `save` call.
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxArticle_save_parent()
    {
        //@CodeCoverageIgnoreStart
        return parent::save();
        //@CodeCoverageIgnoreEnd
    }

    /**
     * Parent `delete` call.
     *
     * @param null|string $sId
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxArticle_delete_parent( $sId = null )
    {
        //@CodeCoverageIgnoreStart
        return parent::delete( $sId );
        //@CodeCoverageIgnoreEnd
    }
}
