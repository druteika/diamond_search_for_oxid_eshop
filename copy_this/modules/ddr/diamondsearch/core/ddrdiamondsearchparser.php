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
 * Class DdrDiamondSearchParser.
 * String helpers and text parsing methods.
 */
class DdrDiamondSearchParser extends oxSuperCfg
{

    /**
     * Stop words to filter out from search terms.
     *
     * @var null|array
     */
    protected $_aStopWords = null;


    /**
     * Parse string for search terms.
     * Split given text string to words; clean, escape and format each word and return words as array.
     *
     * @param string $sText
     * @param int    $iLimit       Limit parsed search terms count
     * @param bool   $blTotalSplit If true, splits on more punctuation symbols like dashes, etc.
     *
     * @return array
     */
    public function parse( $sText, $iLimit = 0, $blTotalSplit = true )
    {
        $aTerms      = array();
        $aSplitChars = array(',', ':', ';', '-', '.', '|', '/', '\\', "\t", "\r\n", PHP_EOL);

        if ( !empty( $blTotalSplit ) ) {

            // Add more chars to split by
            $aSplitChars = array_merge( $aSplitChars, array('_', '*', '=', '?', '&') );
        }

        // Split text to words
        $sText = str_replace(
            $aSplitChars,
            ' ',
            trim( htmlspecialchars_decode( strip_tags( (string) $sText ), ENT_QUOTES ) )
        );

        $aRawWords = explode( ' ', $sText );

        if ( !empty( $aRawWords ) and is_array( $aRawWords ) ) {
            foreach ( $aRawWords as $sRawWord ) {

                // Get clean, formatted term value
                $sTerm = $this->cleanString( $sRawWord );

                // Stop words filter filtering out
                if ( $this->_isStopWord( $sTerm ) ) {
                    continue;
                }

                if ( !empty( $sTerm ) and !in_array( $sTerm, $aTerms ) ) {
                    $aTerms[] = $sTerm;

                    // Stop parsing if found terms limit is reached
                    if ( !empty( $iLimit ) and ( (int) $iLimit > 0 ) and count( $aTerms ) >= $iLimit ) {
                        break;
                    }
                }
            }
        }

        return $aTerms;
    }

    /**
     * Get clean string value from array by key.
     *
     * @param array $aArray
     * @param mixed $mKey
     * @param bool  $blEscape
     * @param bool  $blLowercase
     *
     * @return string
     */
    public function getArrayStringField( $aArray, $mKey, $blEscape = true, $blLowercase = true )
    {
        if ( empty( $aArray[$mKey] ) or !settype( $aArray[$mKey], 'string' ) ) {
            return '';
        }

        return $this->cleanString( $aArray[$mKey], $blEscape, $blLowercase, 0 );
    }

    /**
     * Clean string value.
     *
     * @nice2have: Use regexps instead of string replaces.
     *
     * @param mixed $mValue
     * @param bool  $blEscape
     * @param bool  $blLowercase
     * @param int   $iLimit
     *
     * @return string
     */
    public function cleanString( $mValue, $blEscape = true, $blLowercase = true, $iLimit = 32 )
    {
        $sValue = trim( (string) $mValue );

        if ( !empty( $blEscape ) ) {
            $sValue = trim(
                filter_var( strip_tags( $sValue ), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW )
            );
            $sValue = str_replace(
                array(
                    '~', '`', '!', '@', '#', '$', '%', '^', '&', '(', ')', '=', '+', '[', '{', '}', ']', '<', '>', '?',
                    "'", '"', '39;', '34;'
                ),
                '',
                $sValue
            );
        }

        if ( !empty( $blLowercase ) ) {
            $sValue = mb_strtolower( $sValue, 'UTF-8' );
        }

        if ( !empty( $iLimit ) and ( (int) $iLimit > 0 ) ) {
            $sValue = mb_strcut( $sValue, 0, $iLimit );
        }

        return $sValue;
    }


    /**
     * Check if a word is one of stop words.
     *
     * @param string $sWord
     *
     * @return bool
     */
    protected function _isStopWord( $sWord )
    {
        if ( is_null( $this->_aStopWords ) ) {

            /** @var DdrDiamondSearchModule $oModule */
            $oModule   = oxNew( 'DdrDiamondSearchModule' );
            $sLanguage = oxRegistry::getLang()->getLanguageAbbr();

            $sDefaultStopWords = $oModule->translate( '_DDR_STOP_WORDS_', false );
            $aCustomStopWords  = (array) $oModule->getSetting( 'StopWords' );
            $sCustomStopWords  = array_key_exists( $sLanguage, $aCustomStopWords ) ? $aCustomStopWords[$sLanguage] : '';

            $this->_aStopWords = explode(
                ',',
                str_replace( ' ', '', ( $sDefaultStopWords . ',' . $sCustomStopWords ) )
            );
        }

        return in_array( $sWord, $this->_aStopWords );
    }
}
