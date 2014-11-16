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
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'ddrdiamondsearch',
    'title'       => 'Diamond Search CE',
    'description' => 'Diamond Search - Simply brilliant out-of-the-box search engine for OXID eShop!',
    'thumbnail'   => 'out/pictures/ddrdiamondsearch.png',
    'version'     => '0.4.0 CE',
    'author'      => 'Dmitrijus Druteika',
    'url'         => 'http://www.druteika.lt/#diamond_search_for_oxid_eshop',
    'email'       => 'dmitrijus.druteika@gmail.com',
    'extend'      => array(
        'search'        => 'ddr/diamondsearch/controllers/ddrdiamondsearchsearch',
        'oxsession'     => 'ddr/diamondsearch/core/ddrdiamondsearchoxsession',
        'oxarticle'     => 'ddr/diamondsearch/models/ddrdiamondsearchoxarticle',
        'oxarticlelist' => 'ddr/diamondsearch/models/ddrdiamondsearchoxarticlelist',
        'oxsearch'      => 'ddr/diamondsearch/models/ddrdiamondsearchoxsearch',
    ),
    'files'       => array(
        'ddrdiamondsearcharticleswidget'  => 'ddr/diamondsearch/components/widgets/ddrdiamondsearcharticleswidget.php',
        'ddrdiamondsearchfilterswidget'   => 'ddr/diamondsearch/components/widgets/ddrdiamondsearchfilterswidget.php',
        'ddrdiamondsearchformwidget'      => 'ddr/diamondsearch/components/widgets/ddrdiamondsearchformwidget.php',
        'ddrdiamondsearchindexingwidget'  => 'ddr/diamondsearch/components/widgets/ddrdiamondsearchindexingwidget.php',
        'admin_ddrdiamondsearchmonitor'   => 'ddr/diamondsearch/controllers/admin/admin_ddrdiamondsearchmonitor.php',
        'ddrdiamondsearchfilter'          => 'ddr/diamondsearch/controllers/ddrdiamondsearchfilter.php',
        'ddrdiamondsearchfindterms'       => 'ddr/diamondsearch/controllers/ddrdiamondsearchfindterms.php',
        'ddrdiamondsearchmonitor'         => 'ddr/diamondsearch/controllers/ddrdiamondsearchmonitor.php',
        'ddrdiamondsearchindexer'         => 'ddr/diamondsearch/core/ddrdiamondsearchindexer.php',
        'ddrdiamondsearchmodule'          => 'ddr/diamondsearch/core/ddrdiamondsearchmodule.php',
        'ddrdiamondsearchoxbase'          => 'ddr/diamondsearch/core/ddrdiamondsearchoxbase.php',
        'ddrdiamondsearchparser'          => 'ddr/diamondsearch/core/ddrdiamondsearchparser.php',
        'ddrdiamondsearchfiltervalue'     => 'ddr/diamondsearch/models/ddrdiamondsearchfiltervalue.php',
        'ddrdiamondsearchfiltervaluelist' => 'ddr/diamondsearch/models/ddrdiamondsearchfiltervaluelist.php',
        'ddrdiamondsearchterm'            => 'ddr/diamondsearch/models/ddrdiamondsearchterm.php',
        'ddrdiamondsearchtermlist'        => 'ddr/diamondsearch/models/ddrdiamondsearchtermlist.php',
        'ddrdiamondsearchterm2article'    => 'ddr/diamondsearch/models/ddrdiamondsearchterm2article.php',
        'ddrdiamondsearchtoindex'         => 'ddr/diamondsearch/models/ddrdiamondsearchtoindex.php',
        'ddrdiamondsearchtoindexlist'     => 'ddr/diamondsearch/models/ddrdiamondsearchtoindexlist.php',
        'ddrdiamondsearchconfig'          => 'ddr/diamondsearch/config.php',
    ),
    'templates'   => array(
        'ddrdiamondsearchmonitor.tpl'        => 'ddr/diamondsearch/views/page/ddrdiamondsearchmonitor.tpl',
        'ddrdiamondsearcharticleswidget.tpl' => 'ddr/diamondsearch/views/widget/ddrdiamondsearcharticleswidget.tpl',
        'ddrdiamondsearchfilterswidget.tpl'  => 'ddr/diamondsearch/views/widget/ddrdiamondsearchfilterswidget.tpl',
        'ddrdiamondsearchformwidget.tpl'     => 'ddr/diamondsearch/views/widget/ddrdiamondsearchformwidget.tpl',
        'ddrdiamondsearchindexingwidget.tpl' => 'ddr/diamondsearch/views/widget/ddrdiamondsearchindexingwidget.tpl',
    ),
    'blocks'      => array(
        array(
            'template' => 'widget/header/search.tpl',
            'block'    => 'widget_header_search_form',
            'file'     => 'views/blocks/ddrdiamondsearchheaderblock.tpl',
        ),
        array(
            'template' => 'layout/sidebar.tpl',
            'block'    => 'sidebar',
            'file'     => 'views/blocks/ddrdiamondsearchsidebarfilters.tpl',
        ),
        array(
            'template' => 'layout/page.tpl',
            'block'    => 'content_main',
            'file'     => 'views/blocks/ddrdiamondsearchmaincontent.tpl',
        ),
    ),
    'settings'    => array(
        array(
            'group' => 'DdrDiamondSearchIndexing',
            'name'  => 'DdrDiamondSearchBundleSize',
            'type'  => 'str',
            'value' => 3,
        ),
        array(
            'group' => 'DdrDiamondSearchIndexing',
            'name'  => 'DdrDiamondSearchCronSize',
            'type'  => 'str',
            'value' => 100,
        ),
        array(
            'group' => 'DdrDiamondSearchIndexing',
            'name'  => 'DdrDiamondSearchIndexOnChange',
            'type'  => 'bool',
            'value' => true,
        ),
        array(
            'group' => 'DdrDiamondSearchIndexing',
            'name'  => 'DdrDiamondSearchSaveStats',
            'type'  => 'bool',
            'value' => true,
        ),
        array(
            'group' => 'DdrDiamondSearchIndexing',
            'name'  => 'DdrDiamondSearchStopWords',
            'type'  => 'aarr',
            'value' => array(
                'en' => 'a,ahm,an,c,co,com,im,in,incl,let,sle,t,the,true,und,www',
                'de' => 'c,co,com,das,der,in,sle,t,true,www',
            ),
        ),
        array(
            'group' => 'DdrDiamondSearchBehavior',
            'name'  => 'DdrDiamondSearchFallback',
            'type'  => 'bool',
            'value' => false,
        ),
        array(
            'group' => 'DdrDiamondSearchBehavior',
            'name'  => 'DdrDiamondSearchFindAll',
            'type'  => 'bool',
            'value' => false,
        ),
        array(
            'group' => 'DdrDiamondSearchBehavior',
            'name'  => 'DdrDiamondSearchByPart',
            'type'  => 'bool',
            'value' => false,
        ),
        array(
            'group' => 'DdrDiamondSearchBehavior',
            'name'  => 'DdrDiamondSearchMaxWords',
            'type'  => 'str',
            'value' => 12,
        ),
        array(
            'group' => 'DdrDiamondSearchBehavior',
            'name'  => 'DdrDiamondSearchMaxHints',
            'type'  => 'str',
            'value' => 10,
        ),
        array(
            'group' => 'DdrDiamondSearchBehavior',
            'name'  => 'DdrDiamondSearchHintHits',
            'type'  => 'bool',
            'value' => true,
        ),
        array(
            'group' => 'DdrDiamondSearchMonitor',
            'name'  => 'DdrDiamondSearchPublicMon',
            'type'  => 'bool',
            'value' => false,
        ),
        array(
            'group' => 'DdrDiamondSearchMonitor',
            'name'  => 'DdrDiamondSearchListLen',
            'type'  => 'str',
            'value' => 24,
        ),
        array(
            'group' => 'DdrDiamondSearchPromotion',
            'name'  => 'DdrDiamondSearchPromoTitle',
            'type'  => 'str',
            'value' => 'Diamond Search - Promotion Articles - Core GT kites!',
        ),
        array(
            'group' => 'DdrDiamondSearchPromotion',
            'name'  => 'DdrDiamondSearchPromoQuery',
            'type'  => 'str',
            'value' => 'kites core GT',
        ),
    ),
    'events'      => array(
        'onActivate' => 'DdrDiamondSearchModule::onActivate',
    ),
);
