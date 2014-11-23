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
 * @todo: German translations for remaining codes. NOTE: File encoding must be ISO-8859-15.
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
    'DDR_DIAMONDSEARCH_FORM_TITLE'                    => 'Erweiterte Suche',
    'DDR_DIAMONDSEARCH_FORM_OR'                       => 'oder',
    'DDR_DIAMONDSEARCH_FORM_GO'                       => 'Los!',


    /**
     * Filters
     */

    'DDR_DIAMONDSEARCH_FILTER_HEADNG'                 => 'Suche',
    'DDR_DIAMONDSEARCH_FILTER_RESET'                  => 'Filter zurücksetzen',

    'DDR_DIAMONDSEARCH_FILTER_DDR_PRICE_TITLE'        => 'Preisbereich ',
    'DDR_DIAMONDSEARCH_FILTER_DDR_CATEGORY_TITLE'     => 'Kategorie',
    'DDR_DIAMONDSEARCH_FILTER_DDR_VENDOR_TITLE'       => 'Zulieferer',
    'DDR_DIAMONDSEARCH_FILTER_DDR_MANUFACTURER_TITLE' => 'Hersteller',

    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_AREA'          => 'Einsatzbereich',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_COLOR'         => 'Farbe',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_CUT'           => 'Schnitt',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_DESIGN'        => 'Design',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_DISPLAY'       => 'Anzeige',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_EUSIZE'        => 'EU-Grösse',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_INCDELIVERY'   => 'Lieferumfang',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_MATERIAL'      => 'Material',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_MODEL'         => 'Modell',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_SIZE'          => 'Grösse',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_TEXTURE'       => 'Textur',
    'DDR_DIAMONDSEARCH_FILTER_DDR_ATTR_WASHING'       => 'Washing',


    /**
     * Monitor page translation
     */

    // Texts
    'DDR_DIAMONDSEARCH_MONITOR_TITLE'                 => 'Diamond Search - Monitor',
    'DDR_DIAMONDSEARCH_MONITOR_INTRO'                 => 'Willkommen bei Diamond Search Status- und Statistik-Dashboard!',
    'DDR_DIAMONDSEARCH_MONITOR_CEINFO'                => 'Bemerkung: Diamond Search CE hat nur begrenzte Einstellungsmöglichkeiten und Statistiken.',
    'DDR_DIAMONDSEARCH_MONITOR_MORETOCOME'            => 'Weitere Statistiken und Einstellungsmöglichkeiten werden in zukünftigen Versionen integriert!',

    // Table headings
    'DDR_DIAMONDSEARCH_MONITOR_CURRENTLANG'           => 'Statistiken der aktuellen Sprachauswahl',
    'DDR_DIAMONDSEARCH_MONITOR_ALLLANGS'              => 'Alle Sprachstatistiken',
    'DDR_DIAMONDSEARCH_MONITOR_EEPEONLY'              => '(Nur EE/PE Edition)',

    // Table content
    'DDR_DIAMONDSEARCH_MONITOR_INDEXSIZE'             => 'Anzahl indexierter Artikel',
    'DDR_DIAMONDSEARCH_MONITOR_QUEUESIZE'             => 'Nicht indexierte Artikel in der Warteschlange',
    'DDR_DIAMONDSEARCH_MONITOR_FIELDSCOUNT'           => 'Anzahl der Artikelfelder zu suchen nach',
    'DDR_DIAMONDSEARCH_MONITOR_FILTERSVALSCOUNT'      => 'Filter values count in index',
    'DDR_DIAMONDSEARCH_MONITOR_FILTERSCOUNT'          => 'Different filters count in index',
    'DDR_DIAMONDSEARCH_MONITOR_TERMSCOUNT'            => 'Search terms count in index',
    'DDR_DIAMONDSEARCH_MONITOR_TERM2ARTCOUNT'         => 'Search relations count between articles and terms',
    'DDR_DIAMONDSEARCH_MONITOR_TOPUSEDTERMS'          => 'Am häufigsten indexierte Begriffe',
    'DDR_DIAMONDSEARCH_MONITOR_TOPSEARCHEDTERMS'      => 'Beliebteste Begriffe nach denen Kunden gesucht haben',

    // Actions and tools
    'DDR_DIAMONDSEARCH_MONITOR_TOOLS'                 => 'Werkzeuge',
    'DDR_DIAMONDSEARCH_MONITOR_INDEXNOW'              => 'Jetzt indexieren!',
    'DDR_DIAMONDSEARCH_MONITOR_REINDEXALL'            => 'Re-index aller Artikel',
    'DDR_DIAMONDSEARCH_MONITOR_REINDEXHINT'           => 'Um Artikel zu re-indexieren musst du das Modul im Administrationsbereich deaktivieren und erneut aktivieren.',
);
