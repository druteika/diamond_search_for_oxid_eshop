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
 * Class DdrDiamondSearchIndexer.
 * Articles indexing methods library.
 */
class DdrDiamondSearchIndexer extends oxSuperCfg
{

    /**
     * Index a bundle of articles in queue.
     *
     * @param null|int $mBundleSize
     */
    public function run( $mBundleSize = null )
    {
        /** @var DdrDiamondSearchToIndexList $oToIndexList */
        $oToIndexList = oxNew( 'DdrDiamondSearchToIndexList' );
        $oToIndexList->loadBundleToIndex( $mBundleSize );

        if ( $oToIndexList->count() ) {
            foreach ( $oToIndexList as $oToIndex ) {

                /** @var DdrDiamondSearchOxArticle $oArticle */
                $oArticle = oxNew( 'DdrDiamondSearchOxArticle' );

                if ( $oToIndex->getArticleId() and $oArticle->load( $oToIndex->getArticleId() ) ) {
                    $this->indexArticle( $oArticle );
                }

                $oToIndex->delete();
            }
        }
    }

    /**
     * Parse article for terms and process it.
     *
     * @param DdrDiamondSearchOxArticle $oArticle
     */
    public function indexArticle( oxArticle $oArticle )
    {
        list( $aTerms, $aFilterValue ) = $oArticle->parseArticleTerms();
        $aUniqueTerms = array();
        $sArticleId   = $oArticle->getId();

        /** @var DdrDiamondSearchParser $oParser */
        $oParser = oxRegistry::get( 'DdrDiamondSearchParser' );

        if ( !empty( $sArticleId ) and !empty( $aTerms ) and is_array( $aTerms ) ) {

            // Flush all previous terms relations for the article
            $this->_flushArticleTerms( $sArticleId );

            foreach ( $aTerms as $aTermInfo ) {
                $oTerm = $this->_setTerm( $oParser->getArrayStringField( $aTermInfo, 'value' ) );

                if ( ( $oTerm instanceof DdrDiamondSearchTerm ) and $oTerm->getId() and $oTerm->getTerm() ) {

                    // Get term and re-calculate multiplicity
                    $sTerm                = $oTerm->getTerm();
                    $aUniqueTerms[$sTerm] = isset( $aUniqueTerms[$sTerm] ) ? ( (int) $aUniqueTerms[$sTerm] + 1 ) : 1;

                    // Set term to field relation
                    $this->_setTerm2Field(
                         $oTerm->getId(), $oParser->getArrayStringField( $aTermInfo, 'field', true, false )
                    );

                    // Set term to article relation
                    $this->_setTerm2Article(
                         $oTerm->getId(),
                         $oArticle,
                         (int) $aUniqueTerms[$sTerm],
                         (int) $oParser->getArrayStringField( $aTermInfo, 'weight' )
                    );
                }
            }
        }

        // Save filter value
        $this->_saveFilterValues( $aFilterValue );
    }

    /**
     * Removes all existing article to term relations.
     *
     * @param $sArticleId
     *
     * @return integer
     */
    protected function _flushArticleTerms( $sArticleId )
    {
        /** @var DdrDiamondSearchTerm2Article $oTerm2Article */
        $oTerm2Article = oxNew( 'DdrDiamondSearchTerm2Article' );

        return $oTerm2Article->deleteByArticleId( $sArticleId );
    }

    /**
     * Try loading existing term or create new.
     * For existing one, increases a number it have ben indexed.
     *
     * @param string $sTerm
     *
     * @return DdrDiamondSearchTerm|null
     */
    protected function _setTerm( $sTerm )
    {
        /** @var DdrDiamondSearchTerm $oTerm */
        $oTerm = oxNew( 'DdrDiamondSearchTerm' );
        $oTerm->loadByTerm( $sTerm );

        if ( $oTerm->getId() ) {

            /** @var DdrDiamondSearchTerm2Article $oTerm2Article */
            $oTerm2Article = oxNew( 'DdrDiamondSearchTerm2Article' );

            $oTerm->addMultiplicity();
            $oTerm->setDiversity( $oTerm2Article->getTimesUsed( $sTerm ) );
        } else {
            $oTerm->setTerm( $sTerm );
            $oTerm->addDiversity();
        }

        return $oTerm->save( false ) ? $oTerm : null;
    }

    /**
     * Load term relation to field.
     * Set new relation if it does not exist.
     *
     * @param string $sTermId
     * @param string $sField
     *
     * @return DdrDiamondSearchTerm2Field
     */
    protected function _setTerm2Field( $sTermId, $sField )
    {
        /** @var DdrDiamondSearchTerm2Field $oTerm2Field */
        $oTerm2Field = oxNew( 'DdrDiamondSearchTerm2Field' );
        $oTerm2Field->loadRelation( $sTermId, $sField );

        if ( !$oTerm2Field->getId() ) {
            $oTerm2Field->setTermId( $sTermId );
            $oTerm2Field->setField( $sField );
            $oTerm2Field->save();
        }

        return $oTerm2Field;
    }

    /**
     * Load term relation to article.
     * Set new relation if it does not exist.
     * Calculate relation parameters for search.
     *
     * @param string    $sTermId
     * @param oxArticle $oArticle
     * @param integer   $iMultiplicity
     * @param integer   $iWeight
     *
     * @return null|DdrDiamondSearchTerm2Article
     */
    protected function _setTerm2Article( $sTermId, oxArticle $oArticle, $iMultiplicity, $iWeight )
    {
        if ( !$oArticle->getId() ) {
            return null;
        }

        /** @var DdrDiamondSearchTerm2Article $oTerm2Article */
        $oTerm2Article = oxNew( 'DdrDiamondSearchTerm2Article' );
        $oTerm2Article->loadRelation( $sTermId, $oArticle->getId() );

        if ( !$oTerm2Article->getId() ) {
            $oTerm2Article->setTermId( $sTermId );
            $oTerm2Article->setArticleId( $oArticle->getId() );
        }

        // Set article field copies
        if ( $oArticle->getCategory() and $oArticle->getCategory()->getId() ) {
            $oTerm2Article->setCategoryId( $oArticle->getCategory()->getId() );
        }

        $oTerm2Article->setVendorId( $oArticle->oxarticles__oxvendorid->value );
        $oTerm2Article->setManufacturerId( $oArticle->oxarticles__oxmanufacturerid->value );
        $oTerm2Article->setTitle( $oArticle->oxarticles__oxtitle->value );
        $oTerm2Article->setPrice( $oArticle->oxarticles__oxprice->value );

        // Set term priority related parameters for the article
        $oTerm2Article->setMultiplicity( (int) $iMultiplicity );
        $oTerm2Article->setRelevance( (int) $iMultiplicity * (int) $iWeight );

        $oTerm2Article->save();

        return $oTerm2Article;
    }

    /**
     * For each filter value, try to load and update existing entry or create new one.
     *
     * @param array $aFilterValue
     */
    protected function _saveFilterValues( $aFilterValue )
    {
        if ( !empty( $aFilterValue ) and is_array( $aFilterValue ) ) {

            /** @var DdrDiamondSearchOxSearch $oSearch */
            $oSearch = oxNew( 'DdrDiamondSearchOxSearch' );

            foreach ( $aFilterValue as $sField => $sValue ) {

                /** @var DdrDiamondSearchFilterValue $oFilterValue */
                $oFilterValue = oxNew( 'DdrDiamondSearchFilterValue' );
                $oFilterValue->loadFilterValue( $sField, $sValue );

                if ( !$oFilterValue->getId() ) {
                    $oFilterValue->setField( $sField );
                    $oFilterValue->setValue( $sValue );
                    $oFilterValue->setMultiplicity( 1 );
                } else {
                    $oFilterValue->setMultiplicity(
                                 $oSearch->getSearchArticleCount( $sValue, false, false, false, false )
                    );
                }

                $oFilterValue->save();
            }
        }
    }
}
