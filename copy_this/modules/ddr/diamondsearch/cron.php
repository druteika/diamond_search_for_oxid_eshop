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
 * @version       0.2.1 RC2
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

/**
 * --------------------------------------------------------------------------------------------------------------------
 *
 * This is indexing script for Diamond Search.
 *
 * --------------------------------------------------------------------------------------------------------------------
 *
 * It is build to run from a command line and accepts following arguments:
 *
 *  1. Language  - (optional) Abbreviation of a language to index.
 *                 If not provided, active (default) language is always used.
 *                 Examples: en, de, ...
 *  2. Shop ID   - (optional) ID of a sub-shop to index article in.
 *                 If not provided, active (default) sub-shop ID is used.
 *                 Examples: oxbaseshop, myshop, 1, ...
 *  3. Re-index  - (optional) If this flag is provided, all articles are added for re-indexing queue before the run.
 *                 Examples: 0, 1
 *
 * NOTE: An amount of articles indexed in each run is set in administration backend, Diamond Search module setting.
 *
 * --------------------------------------------------------------------------------------------------------------------
 *
 * Several usage examples:
 *
 *  A. Index a bunch of articles from sub-shop with ID equal 1 in German language:
 *
 *     php cron.php de 1
 *
 *  B. Index English articles bunch from a default shop (Note, that a full path might be needed to provide):
 *
 *     php /full/path/to/cron.php en
 *
 *  C. Index default language  articles bunch from a default shop:
 *
 *     php cron.php
 *
 *  D. Add ALL article to indexing queue and index a bunch of English article from sub-shop with ID "oxbaseshop":
 *
 *     php cron.php en oxbaseshop 1
 *
 * --------------------------------------------------------------------------------------------------------------------
 *
 * Cron task configuration on most linux/unix systems:
 *
 * 1. Open user cron tasks for editing with command:
 *
 *     crontbab -e
 *
 * 2. Add a task to execute the corn script periodically.
 *    Example is:
 */
//     */5 * * * * php /full/path/to/oxid/modules/ddr/diamondsearch/cron.php
/*
 *  In the example above will script will be auto-executed each 5 minutes.
 *
 * -------------------------------------------------------------------------------------------------------------------
 */

/**
 * Bootstrap OXID eShop.
 */
require_once dirname( __FILE__ ) . '../../../../bootstrap.php';


/**
 * Collect arguments and parameters.
 */

// Get language
$oLanguage = oxRegistry::getLang();
$sLanguage = !empty( $argv[1] ) ? mb_strtolower( trim( (string) $argv[1] ), 'UTF-8' ) : $oLanguage->getLanguageAbbr();
$iLanguage = array_search( $sLanguage, $oLanguage->getLanguageIds() );

if ( $iLanguage === false ) {
    exit ( 'Invalid language abbreviation. Available languages are: ' .
           implode( ', ', $oLanguage->getLanguageIds() ) . PHP_EOL );
}

// Get sub-shop ID
$oConfig = oxRegistry::getConfig();
$sShopId = !empty( $argv[2] ) ? trim( (string) $argv[2] ) : $oConfig->getShopId();

if ( !in_array( $sShopId, $oConfig->getShopIds() ) ) {
    exit ( 'Invalid shop ID. Available sub-shops are: ' .
           implode( ', ', $oConfig->getShopIds() ) . PHP_EOL );
}

// Get re-indexing flag
$blReindexAll = !empty( $argv[3] );

// Load Diamond Search module class.
/** @var DdrDiamondSearchModule $oModule */
$oModule = oxRegistry::get( 'DdrDiamondSearchModule' );


/**
 * Set active shop ID and language.
 */
$oConfig->setShopId( $sShopId );
$oLanguage->setBaseLanguage( $iLanguage );


/**
 * Add all articles to indexing queue if the flag is set.
 */
if ( $blReindexAll ) {
    $oModule::reIndexAllArticles();
}


/**
 * Index articles bunch.
 */
/** @var DdrDiamondSearchIndexer $oToIndexList */
$oIndexer = oxNew( 'DdrDiamondSearchIndexer' );
$oIndexer->run( (int) trim( $oModule->getSetting( 'CronSize' ) ) );

exit( 'OK' . PHP_EOL );
