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
 * @version       0.3.1 CE
 * @link          http://www.druteika.lt/#diamond_search_for_oxid_eshop
 * @author        Dmitrijus Druteika <dmitrijus.druteika@gmail.com>
 * @copyright (C) Dmitrijus Druteika 2014
 */

$sLangName = "English";

$aLang = array(
    'charset'                                    => 'utf-8',

    /**
     * Module menus translations
     */
    'ddrdiamondsearch'                           => 'Diamond Search',
    'ddrdiamondsearchmonitor'                    => 'Monitor',

    /**
     * Module setting translations
     */
    // Sections (groups)
    'SHOP_MODULE_GROUP_DdrDiamondSearchIndexing' => 'Indexing Settings',
    'SHOP_MODULE_GROUP_DdrDiamondSearchBehavior' => 'Search Behaviour Settings',
    'SHOP_MODULE_GROUP_DdrDiamondSearchMonitor'  => 'Statistics Monitor Settings',

    // Settings
    'SHOP_MODULE_DdrDiamondSearchBundleSize'     => 'Max articles count for each auto-indexing run. The more it is the faster article will automatically re-index. But notice, that for big values shop might work slow!',
    'SHOP_MODULE_DdrDiamondSearchCronSize'       => 'Max articles count for each cron script indexing run. The more it is the faster article will re-index. But notice, that for big values might cause server timeouts!',
    'SHOP_MODULE_DdrDiamondSearchIndexOnChange'  => 'Index articles immediately on create or change. If not checked, articles will be only added to indexing queue on create/change.',
    'SHOP_MODULE_DdrDiamondSearchSaveStats'      => 'Collect statistics during search. It provides extra features, but makes search a bit slower.',

    'SHOP_MODULE_DdrDiamondSearchFallback'       => 'Should the search fallback to default search on no results or not. Select it in cases of re-indexing huge amounts of articles as temporary alternative.',
    'SHOP_MODULE_DdrDiamondSearchOnlyParent'     => 'Do not show variants in search results - only parent articles will be shown.',
    'SHOP_MODULE_DdrDiamondSearchFindAll'        => 'Search by at least one matching term - shows more results, but does not narrow search when more search terms entered.',
    'SHOP_MODULE_DdrDiamondSearchByPart'         => 'Search not only by full match, by also by word beginnings. NOTE: Search will work slower and it works only for more than one term is entered!',
    'SHOP_MODULE_DdrDiamondSearchMaxWords'       => 'Max number of words to search by in one query. NOTE: Search will work slower on too many terms!',
    'SHOP_MODULE_DdrDiamondSearchMaxHints'       => 'Max number of suggested hint to show in search field auto-complete list.',
    'SHOP_MODULE_DdrDiamondSearchUserTerms'      => 'Max number of search history hints in search field auto-complete list. Set zero to turn off the feature.',
    'SHOP_MODULE_DdrDiamondSearchHintHits'       => 'Show approximate number of matching articles in auto-complete terms list.',

    'SHOP_MODULE_DdrDiamondSearchPublicMon'      => 'Make Diamond Search Monitor page available for public access.',
    'SHOP_MODULE_DdrDiamondSearchListLen'        => 'Number of items to show in statistics lists.',
);
