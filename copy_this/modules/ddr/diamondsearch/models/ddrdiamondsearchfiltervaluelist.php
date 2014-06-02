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

/**
 * Class DdrDiamondSearchFilterValueList.
 * A list model for filter values.
 */
class DdrDiamondSearchFilterValueList extends oxList
{

    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = 'DdrDiamondSearchFilterValue';


    /**
     * Load all filter values.
     *
     * @return int Found entries count.
     */
    public function loadAll()
    {
        $sQuery = sprintf(
            "SELECT * FROM `%s` WHERE %s",
            $this->getBaseObject()->getCoreTableName(),
            oxRegistry::get( 'DdrDiamondSearchOxBase' )->getShopAndLanguageSnippet( '', false )
        );

        $this->selectString( $sQuery );

        return $this->count();
    }
}
