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
 * Class DdrDiamondSearchOxArticle.
 * Extends oxArticle model.
 *
 * @see oxArticle
 */
class DdrDiamondSearchOxArticle extends DdrDiamondSearchOxArticle_parent
{

    /**
     * Parse article fields for search terms.
     *
     * @param null|string $sId
     *
     * @return array Two dimensional array with terms as first key and filter values as second one.
     */
    public function parseArticleTerms( $sId = null )
    {
        if ( !empty( $sId ) and is_string( $sId ) ) {
            $this->load( $sId );
        }

        if ( !$this->getId() ) {
            return array(false, false);
        }

        $aSearchFields = oxRegistry::get( 'DdrDiamondSearchConfig' )->getSearchFields();

        if ( empty( $aSearchFields ) or !is_array( $aSearchFields ) ) {
            return array(false, false);
        }

        // Pre-load related object
        $this->getLongDescription();
        $this->getCategory();
        $this->getAttributes();

        $aTerms       = array();
        $aFilterValue = array();

        foreach ( $aSearchFields as $sFieldName => $aFieldParams ) {
            $sFieldValue = $this->_getFieldValue( $aFieldParams );

            if ( !empty( $sFieldValue ) ) {
                $aTerms = $this->_parseFieldTerms( $sFieldName, $aFieldParams, $sFieldValue, $aTerms );

                if ( !empty( $aFieldParams['filter'] ) ) {
                    $aFilterValue[$sFieldName] = $sFieldValue;
                }
            }
        }

        return array($aTerms, $aFilterValue);
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

            //@nice2have: loadByArticleId implementation
            /* if ( !$oToIndex->load( $mResult ) ) {
                $oToIndex->setArticleId( $mResult );
            } */
            $oToIndex->load( $mResult );
            $oToIndex->setArticleId( $mResult );

            $blIndexNow = (bool) oxRegistry::get( 'DdrDiamondSearchModule' )->getSetting( 'IndexOnChange' );

            if ( !empty( $this->oxarticles__oxactive->value ) ) {
                if ( $blIndexNow ) {

                    // Index the article now
                    $this->_indexNow();
                } else {

                    // If article is active, add it to indexing queue
                    $oToIndex->save();
                }
            } else {

                // If article is not active, remove it from index
                if ( $blIndexNow ) {

                    // Remove article and its variants from search
                    $this->_deleteFromIndex();
                } else {

                    // Just remove from search queue
                    $oToIndex->delete();
                }
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
            $this->_deleteFromIndex();
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
        /** @var DdrDiamondSearchOxArticle|oxArticle $this */

        $sValue = null;
        $sField = '';

        /** @var DdrDiamondSearchParser $oParser */
        $oParser = oxRegistry::get( 'DdrDiamondSearchParser' );

        $sTable = $oParser->getArrayStringField( $aParams, 'table' );
        $sName  = $oParser->getArrayStringField( $aParams, 'field' );
        $sId    = $oParser->getArrayStringField( $aParams, 'id' );

        switch ( $sTable ) {
            case 'oxarticles':
                $oObject = $this;
                break;

            case 'oxartextends':
                $oObject = $this;

                if ( $sName == 'oxtags' ) {
                    $sValue = $oObject->_getArticleTags();
                } elseif ( $sName == 'oxlongdesc' ) {
                    $sField = '_oLongDesc';
                }

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
                $oObject = $this->_getAttributeObject( $sId );
                break;

            default:
                return (string) $sValue;
        }

        if ( is_null( $sValue ) ) {
            $sField = !empty( $sField ) ? $sField : sprintf( '%s__%s', $sTable, $sName );
            $sValue = !empty( $oObject->$sField->value ) ?
                (string) $oObject->$sField->value :
                '';
        }

        return html_entity_decode( $sValue );
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
     * Get article attribute object by attribute ID.
     *
     * @param string $sAttributeId
     *
     * @return null|oxAttribute
     */
    protected function _getAttributeObject( $sAttributeId )
    {
        $oObject         = null;
        $oAttributesList = $this->getAttributes();
        $aAttributesList = !empty( $oAttributesList ) ? $oAttributesList->getArray() : array();

        foreach ( $aAttributesList as $sListId => $oAttribute ) {
            if ( $sListId == $sAttributeId ) {

                // Newer versions case
                $oObject = $oAttribute;
                break;
            } elseif ( isset( $oAttribute->oxattribute__oxattrid->value ) and
                       ( $oAttribute->oxattribute__oxattrid->value == $sAttributeId )
            ) {

                // Case for older 4.7.x version
                $oObject = $oAttribute;
                break;
            }
        }

        return $oObject;
    }

    /**
     * Get article tags.
     *
     * @return string
     */
    protected function _getArticleTags()
    {
        /** @var DdrDiamondSearchOxArticle|oxArticle $this */

        if ( method_exists( $this, 'getTags' ) ) {

            // Tags getter for eShop version 5.1.x/4.8.x or older
            $sTags = (string) $this->getTags();
        } else {

            // Way to get tags for newer shop versions
            $oDb   = oxDb::getDb();
            $sTags = (string) $oDb->getOne(
                sprintf(
                    "SELECT `OXTAGS` FROM `%s` WHERE `OXID` = %s",
                    getViewName( 'oxartextends', $this->getLanguage() ),
                    $oDb->quote( $this->getId() )
                )
            );
        }

        return $sTags;
    }

    /**
     * Index article and its variants now.
     */
    protected function _indexNow()
    {
        /** @var DdrDiamondSearchOxArticle|oxArticle $this */

        $aArticles     = array($this);
        $oVariantsList = $this->getVariants();

        if ( !empty( $oVariantsList ) and ( $oVariantsList instanceof oxList ) ) {
            $aArticles = array_merge( $aArticles, $oVariantsList->getArray() );
        }

        /** @var DdrDiamondSearchIndexer $oIndexer */
        $oIndexer = oxRegistry::get( 'DdrDiamondSearchIndexer' );

        foreach ( $aArticles as $oArticle ) {
            $oIndexer->indexArticle( $oArticle );
        }
    }

    /**
     * Delete article and its variants from search index.
     */
    protected function _deleteFromIndex()
    {
        /** @var DdrDiamondSearchOxArticle|oxArticle $this */

        /** var DdrDiamondSearchToIndex $oToIndex */
        $oToIndex = oxNew( 'DdrDiamondSearchToIndex' );
        $oToIndex->delete( $this->getId() );

        $aRemoveIds = array_merge( array($this->getId()), (array) $this->getVariantIds( false ) );

        /** @var DdrDiamondSearchTerm2Article $oTerm2Article */
        $oTerm2Article = oxNew( 'DdrDiamondSearchTerm2Article' );

        foreach ( $aRemoveIds as $sArticleId ) {
            $oTerm2Article->deleteByArticleId( $sArticleId );
        }
    }


    /**
     * Parent `save` call.
     *
     * @codeCoverageIgnore
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxArticle_save_parent()
    {
        return parent::save();
    }

    /**
     * Parent `delete` call.
     *
     * @codeCoverageIgnore
     *
     * @param null|string $sId
     *
     * @return mixed
     */
    protected function _DdrDiamondSearchOxArticle_delete_parent( $sId = null )
    {
        return parent::delete( $sId );
    }
}
