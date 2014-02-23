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
 * You can adjust parameters, add or remove search fields here.
 * NOTE: Be careful when editing - backup file before changing and be sure, You know what You are doing!
 *
 * Filed key - unique field name, UPPERCASE, max length 24 chars.
 *
 * Parameters are:
 *  table  - model identifier - DB table name.
 *  field  - DB field name of corresponding model.
 *  weight - integer value user for ranking calculation - higher value mean bigger priority in search.
 *  flag   - (optional) special flag. Currently supports:
 *              _DDR_NO_SPLIT_ - use it for short, one-word fields, that should not be spit,
 *                               e.g. article number, price, etc.
 */

/**
 * Class DdrDiamondSearchConfig
 * Search fields settings class.
 *
 * @nice2have: Implement fields setup GUI: module settings on monitor page
 */
class DdrDiamondSearchConfig extends oxSuperCfg
{

    /**
     * @var array Fields to search by
     */
    protected $_aSearchFields = array(

        /* Article model fields */
        'DDR_ARTICLE_NUMBER'      => array(
            'table'  => 'oxarticles',
            'field'  => 'OXARTNUM',
            'weight' => 10000,
            'flag'   => '_DDR_NO_SPLIT_',
        ),
        'DDR_ARTICLE_SEARCHKEYS'  => array(
            'table'  => 'oxarticles',
            'field'  => 'OXSEARCHKEYS',
            'weight' => 1000,
        ),
        'DDR_ARTICLE_TITLE'       => array(
            'table'  => 'oxarticles',
            'field'  => 'OXTITLE',
            'weight' => 1000,
        ),
        'DDR_ARTICLE_SELECTION'   => array(
            'table'  => 'oxarticles',
            'field'  => 'OXVARSELECT',
            'weight' => 10000,
        ),
        'DDR_ARTICLE_DESCRIPTION' => array(
            'table'  => 'oxarticles',
            'field'  => 'OXSHORTDESC',
            'weight' => 10,
        ),

        /* ArtExtends model fields */
        'DDR_ARTEXT_DESCRIPTION'  => array(
            'table'  => 'oxartextends',
            'field'  => 'OXLONGDESC',
            'weight' => 1,
        ),
        'DDR_ARTEXT_TAGS'         => array(
            'table'  => 'oxartextends',
            'field'  => 'OXTAGS',
            'weight' => 100,
        ),

        /* Category fields */
        'DDR_CATEGORY_TITLE'      => array(
            'table'  => 'oxcategories',
            'field'  => 'OXTITLE',
            'weight' => 1000,
            'filter' => 10000,
        ),

        /* Vendor fields */
        'DDR_VENDOR_TITLE'        => array(
            'table'  => 'oxvendor',
            'field'  => 'OXTITLE',
            'weight' => 100,
        ),

        /* Manufacturer fields */
        'DDR_MANUFACTURER_TITLE'  => array(
            'table'  => 'oxmanufacturers',
            'field'  => 'OXTITLE',
            'weight' => 100,
            'filter' => 1000,
        ),

        /* Attributes */
        // NOTE: When adding Your custom attributes, please double-check id -
        //  it should be a valid oxAttribute OXID field value.
        'DDR_ATTR_AREA'           => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '8a142c3f14ef22a14.79693851',
            'weight' => 100,
            'filter' => 100,
        ),
        'DDR_ATTR_COLOR'          => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '9438ac75bac3e344628b14bf7ed82c15',
            'weight' => 100,
            'filter' => 500,
        ),
        'DDR_ATT_CUT'             => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '943e7f5d33e9a78d4b71906270e3d0c6',
            'weight' => 100,
            'filter' => 80,
        ),
        'DDR_ATTR_DESIGN'         => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '8a142c3e9cd961518.80299776',
            'weight' => 100,
            'filter' => 70,
        ),
        'DDR_ATTR_DISPLAY'        => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '8a142c3ee0edb75d4.80743302',
            'weight' => 100,
            'filter' => 60,
        ),
        'DDR_ATTR_EUSIZE'         => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '6b6bc9f9ab8b153d9bebc2ad6ca2aa13',
            'weight' => 100,
            'filter' => 250,
        ),
        'DDR_ATTR_INCDELIVERY'    => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '6cf89d2d73e666457d167cebfc3eb492',
            'weight' => 100,
        ),
        'DDR_ATTR_MATERIAL'       => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '8a142c3f0e2cf1a34.78041155',
            'weight' => 100,
            'filter' => 40,
        ),
        'DDR_ATTR_MODEL'          => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '8a142c3f0a792c0c3.93013584',
            'weight' => 100,
            'filter' => 30,
        ),
        'DDR_ATTR_SIZE'           => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '943d32fd45d6eba3e5c8cce511cc0e74',
            'weight' => 100,
        ),
        'DDR_ATTR_TEXTURE'        => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => 'd8842e3b7c5e108c1.63072778',
            'weight' => 100,
            'filter' => 20,
        ),
        'DDR_ATTR_WASHING'        => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '6b6e77de7a04de54f1aa63cfeca2f487',
            'weight' => 100,
        ),
    );

    /**
     * Set fields to search by.
     *
     * @nice2have: Parse and validate when loading from external sources (GUI).
     *
     * @param array $aSearchFields
     *
     * @return array
     */
    public function setSearchFields( $aSearchFields )
    {
        $this->_aSearchFields = $aSearchFields;
    }

    /**
     * Get fields to search by.
     *
     * @return array
     */
    public function getSearchFields()
    {
        return $this->_aSearchFields;
    }

    /**
     * Get fields that have filter flag sorted by filters priority.
     *
     * @return array
     */
    public function getFilterFields()
    {
        $aFilterFields = array();

        $aFields = $this->getSearchFields();

        foreach ( $aFields as $sFieldName => $aFiledParams ) {
            if ( !empty( $aFiledParams['filter'] ) ) {
                $aFilterFields[$sFieldName] = (int) $aFiledParams['filter'];
            }
        }

        arsort( $aFilterFields );

        return $aFilterFields;
    }
}
