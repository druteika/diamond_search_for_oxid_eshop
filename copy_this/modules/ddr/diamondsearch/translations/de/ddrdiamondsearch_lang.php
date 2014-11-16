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
 * @todo: German translations. NOTE: File encoding must be ISO-8859-15.
 */

$sLangName = "Deutsch";

$aLang = array(
    'charset'                                         => 'ISO-8859-15',

    /**
     * Settings
     */
    '_DDR_STOP_WORDS_'                                => 'aber,als,am,an,auch,auf,aus,bei,bin,bis,bist,da,dadurch,daher,darum,das,daß,dass,dein,deine,dem,den,der,des,dessen,deshalb,die,dies,dieser,dieses,doch,dort,du,durch,ein,eine,einem,einen,einer,eines,er,es,euer,eure,für,hatte,hatten,hattest,hattet,hier,hinter,ich,ihr,ihre,im,in,ist,ja,jede,jedem,jeden,jeder,jedes,jener,jenes,jetzt,kann,kannst,können,könnt,machen,mein,meine,mit,muß,mußt,musst,müssen,müßt,nach,nachdem,nein,nicht,nun,oder,seid,sein,seine,sich,sie,sind,soll,sollen,sollst,sollt,sonst,soweit,sowie,und,unser,unsere,unter,vom,von,vor,wann,warum,was,weiter,weitere,wenn,wer,werde,werden,werdet,weshalb,wie,wieder,wieso,wir,wird,wirst,wo,woher,wohin,zu,zum,zur,über',


    /**
     * Advanced search form
     */
    'DDR_DIAMONDSEARCH_FORM_TITLE'                    => 'Advanced search',
    'DDR_DIAMONDSEARCH_FORM_OR'                       => 'or',
    'DDR_DIAMONDSEARCH_FORM_GO'                       => 'Go!',


    /**
     * Filters
     */

    'DDR_DIAMONDSEARCH_FILTER_HEADNG'                 => 'Search',
    'DDR_DIAMONDSEARCH_FILTER_RESET'                  => 'Reset filters',

    'DDR_DIAMONDSEARCH_FILTER_DDR_PRICE_TITLE'        => 'Price Range',
    'DDR_DIAMONDSEARCH_FILTER_DDR_CATEGORY_TITLE'     => 'Category',
    'DDR_DIAMONDSEARCH_FILTER_DDR_VENDOR_TITLE'       => 'Vendor',
    'DDR_DIAMONDSEARCH_FILTER_DDR_MANUFACTURER_TITLE' => 'Manufacturer',

    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_AREA'          => 'Area of application',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_COLOR'         => 'Color',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_CUT'           => 'Cut',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_DESIGN'        => 'Design',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_DISPLAY'       => 'Display',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_EUSIZE'        => 'EU-Size',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_INCDELIVERY'   => 'Includes',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_MATERIAL'      => 'Material',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_MODEL'         => 'Model',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_SIZE'          => 'Size',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_TEXTURE'       => 'Texture',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_WASHING'       => 'Washing',


    /**
     * Monitor page translation
     */

    // Texts
    'DDR_DIAMONDSEARCH_MONITOR_TITLE'                 => 'Diamond Search - Monitor',
    'DDR_DIAMONDSEARCH_MONITOR_INTRO'                 => 'Welcome to Diamond Search engine status and statistics dashboard!',
    'DDR_DIAMONDSEARCH_MONITOR_CEINFO'                => 'NOTE: Diamond Search CE has only very limited setting and statistics.',
    'DDR_DIAMONDSEARCH_MONITOR_MORETOCOME'            => 'More statistics and parameters to come in next releases!',

    // Table headings
    'DDR_DIAMONDSEARCH_MONITOR_CURRENTLANG'           => 'Current language statistics',
    'DDR_DIAMONDSEARCH_MONITOR_ALLLANGS'              => 'All languages statistics',
    'DDR_DIAMONDSEARCH_MONITOR_EEPEONLY'              => '(EE/PE Editions Only)',

    // Table content
    'DDR_DIAMONDSEARCH_MONITOR_INDEXSIZE'             => 'Indexed articles count',
    'DDR_DIAMONDSEARCH_MONITOR_QUEUESIZE'             => 'Not indexed articles waiting in queue',
    'DDR_DIAMONDSEARCH_MONITOR_FIELDSCOUNT'           => 'Number of article fields to search by',
    'DDR_DIAMONDSEARCH_MONITOR_FILTERSVALSCOUNT'      => 'Filter values count in index',
    'DDR_DIAMONDSEARCH_MONITOR_FILTERSCOUNT'          => 'Different filters count in index',
    'DDR_DIAMONDSEARCH_MONITOR_TERMSCOUNT'            => 'Search terms count in index',
    'DDR_DIAMONDSEARCH_MONITOR_TERM2ARTCOUNT'         => 'Search relations count between articles and terms',
    'DDR_DIAMONDSEARCH_MONITOR_TOPUSEDTERMS'          => 'Most frequently indexed terms',
    'DDR_DIAMONDSEARCH_MONITOR_TOPSEARCHEDTERMS'      => 'Most popular terms users search for',

    // Actions and tools
    'DDR_DIAMONDSEARCH_MONITOR_TOOLS'                 => 'Tools',
    'DDR_DIAMONDSEARCH_MONITOR_INDEXNOW'              => 'Index now!',
    'DDR_DIAMONDSEARCH_MONITOR_REINDEXALL'            => 'Re-index all articles',
    'DDR_DIAMONDSEARCH_MONITOR_REINDEXHINT'           => 'To re-index articles, please deactivate and activate the module again in administration area.',
);
