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
 * @version       0.1.0 beta
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
 * @todo: Implement fields setup GUI: module settings on monitor page
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

        /* Category fields */
        'DDR_CATEGORY_TITLE'      => array(
            'table'  => 'oxcategories',
            'field'  => 'OXTITLE',
            'weight' => 1000,
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
        ),

        /* Attributes */
        // NOTE: When adding Your custom attributes, please double-check id -
        //  it should be a valid oxAttribute OXID field value.
        'DDR_ATTR_COLOR'          => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '9438ac75bac3e344628b14bf7ed82c15',
            'weight' => 100,
        ),
        'DDR_ATTR_MODEL'          => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '8a142c3f0a792c0c3.93013584',
            'weight' => 100,
        ),
        'DDR_ATTR_SIZE'           => array(
            'table'  => 'oxattribute',
            'field'  => 'OXVALUE',
            'id'     => '943d32fd45d6eba3e5c8cce511cc0e74',
            'weight' => 100,
        ),
    );

    /**
     * Set fields to search by.
     *
     * @todo: Parse and validate when loading from external sources (GUI).
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
}
