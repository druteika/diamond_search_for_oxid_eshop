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
 * @version       0.2.2 RC3
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * Class DdrDiamondSearchModule.
 * Diamond Search Module events and static helpers library.
 */
class DdrDiamondSearchModule extends oxModule
{

    /**
     * Initialize module parameters.
     */
    function __construct()
    {
        // @codeCoverageIgnoreStart
        $this->setModuleData(
             array(
                 'id'          => 'ddrdiamondsearch',
                 'title'       => 'Diamond Search',
                 'description' => '',
             )
        );

        $this->load( 'ddrdiamondsearch' );

        oxRegistry::set( 'DdrDiamondSearchModule', $this );

        return;
        // @codeCoverageIgnoreEnd
    }


    /**
     * An alias method to get active shop ID.
     *
     * @return mixed
     */
    public function getShopId()
    {
        // @codeCoverageIgnoreStart
        return oxRegistry::getConfig()->getShopId();
        // @codeCoverageIgnoreEnd
    }

    /**
     * An alias method to get active language ID.
     *
     * @return int
     */
    public function getLanguageId()
    {
        // @codeCoverageIgnoreStart
        return (int) oxRegistry::getLang()->getBaseLanguage();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Translate language string.
     *
     * @param string  $sString
     * @param boolean $blAppendPrefix Use module prefix for the language string.
     *
     * @return string
     */
    public function translate( $sString, $blAppendPrefix = true )
    {
        // @codeCoverageIgnoreStart
        if ( $blAppendPrefix ) {
            $sString = 'DDR_DIAMONDSEARCH_' . $sString;
        }

        return oxRegistry::getLang()->translateString( $sString, oxRegistry::getLang()->getBaseLanguage(), false );
        // @codeCoverageIgnoreEnd
    }

    /**
     * Short alias for `translate` method.
     *
     * @param string $sString
     * @param bool   $blAppendPrefix
     *
     * @return string
     */
    public function _( $sString, $blAppendPrefix = true )
    {
        // @codeCoverageIgnoreStart
        return $this->translate( $sString, $blAppendPrefix );
        // @codeCoverageIgnoreEnd
    }

    /**
     * Get module settings parameter by key.
     *
     * @param string  $sSettingKey    Module setting parameter name without module prefix.
     * @param boolean $blAppendPrefix Use module prefix for the setting key.
     *
     * @return mixed
     */
    public function getSetting( $sSettingKey, $blAppendPrefix = true )
    {
        // @codeCoverageIgnoreStart
        if ( $blAppendPrefix ) {
            $sSettingKey = 'DdrDiamondSearch' . (string) $sSettingKey;
        }

        return oxRegistry::getConfig()->getConfigParam( (string) $sSettingKey );
        // @codeCoverageIgnoreEnd
    }

    /**
     * Get module folder full path.
     *
     * @return string
     */
    public function getPath()
    {
        // @codeCoverageIgnoreStart
        return oxRegistry::getConfig()->getModulesDir() . 'ddr/diamondsearch/';
        // @codeCoverageIgnoreEnd
    }

    /**
     * Module activation event.
     * Installs DB tables, resets cache, add all article to indexing queue.
     */
    public static function onActivate()
    {
        // Install module database tables
        self::installDbTables();

        // Clean cache
        self::deleteCache();

        // Add all article to indexing queue
        self::reIndexAllArticles();
    }

    /**
     * Adds all articles for all languages to indexing queue.
     */
    public static function reIndexAllArticles()
    {

        /** @var DdrDiamondSearchToIndexList $oToIndexList */
        $oToIndexList = oxNew( 'DdrDiamondSearchToIndexList' );

        /** @var oxLang $oLang */
        $oLang      = oxRegistry::getLang();
        $aLanguages = (array) $oLang->getLanguageArray();

        foreach ( $aLanguages as $oLanguage ) {
            if ( is_object( $oLanguage ) and !empty( $oLanguage->active ) and isset( $oLanguage->id ) ) {
                $oToIndexList->addAllArticles( (int) $oLanguage->id );
            }
        }
    }

    /**
     * Get set filter values from session.
     *
     * @return array
     */
    public function getSelectedFilterValues()
    {
        $aFilter = array();

        $oSession = oxRegistry::getSession();

        // Init session
        if ( !$oSession->getId() ) {
            $oSession->start();
        }

        // Get existing filters
        if ( $oSession->getId() and $oSession->hasVariable( 'ddrdiamondsearchfilter' ) ) {
            $aFilter = (array) $oSession->getVariable( 'ddrdiamondsearchfilter' );
        }

        return $aFilter;
    }

    /**
     * Removes all cache from tmp/ and tmp/smarty folders excluding .htaccess file.
     */
    public static function deleteCache()
    {
        defined( 'DS' ) or define( 'DS', '/' );

        $sCacheFolderPath  = oxRegistry::getConfig()->getConfigParam( 'sCompileDir' );
        $sSmartyFolderPath = $sCacheFolderPath . DS . 'smarty';

        // Prepare directories list to delete from and a list of path and files to skip.
        $aCleanFolders = array($sSmartyFolderPath, $sCacheFolderPath);
        $sExcludeItems = array('.', '..', '.htaccess');

        foreach ( $aCleanFolders as $sDirectoryPath ) {
            if ( is_dir( $sDirectoryPath ) and ( $hDirectory = opendir( $sDirectoryPath ) ) ) {

                // If directory is readable, fetch its content and delete files
                while ( $sFile = readdir( $hDirectory ) ) {

                    if ( is_file( $sDirectoryPath . DS . $sFile ) and !in_array( $sFile, $sExcludeItems ) ) {
                        @unlink( $sDirectoryPath . DS . $sFile );
                    }
                }
            }
        }
    }


    /**
     * Install module DB tables.
     * Executes docs/install.sql queries.
     */
    protected static function installDbTables()
    {
        $oDb = oxDb::getDb( oxDb::FETCH_MODE_ASSOC );

        try {
            $sInstallSql = file_get_contents(
                oxRegistry::get( 'DdrDiamondSearchModule' )->getPath() . '/docs/install.sql'
            );
            $aQueries    = explode( ';', $sInstallSql );

            if ( !empty( $aQueries ) and is_array( $aQueries ) ) {
                foreach ( $aQueries as $sQuery ) {
                    if ( !empty( $sQuery ) ) {
                        $oDb->execute( $sQuery );
                    }
                }
            }
        } catch ( Exception $oException ) {
            error_log( 'Diamond Search installation  error: ' . $oException->getMessage() );
        }
    }
}
