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
 * Class DdrDiamondSearchTermList.
 * A list model for search term objects.
 */
class DdrDiamondSearchTermList extends oxList
{

    /**
     * List Object class name
     *
     * @var string
     */
    protected $_sObjectsInListName = 'DdrDiamondSearchTerm';


    /**
     * Find terms starting with given argument.
     *
     * @param int $iLimit
     *
     * @return int Found entries count.
     */
    public function search( $sTermLike, $iLimit = 0 )
    {
        $sQuery = sprintf(
            "SELECT * FROM `%s`
            WHERE %s `DDRTERM` LIKE %s
            ORDER BY `DDRDIVERSITY` DESC, `DDRTIMESSEARCHEDAALONE` DESC, `DDRTIMESSEARCHED` DESC, `DDRTERM` ASC
            %s",
            $this->getBaseObject()->getCoreTableName(),
            oxRegistry::get( 'DdrDiamondSearchOxBase' )->getShopAndLanguageSnippet(),
            oxDb::getDb()->quote( $sTermLike . '%' ),
            ( !empty( $iLimit ) ? "LIMIT " . (int) $iLimit : "" )
        );

        $this->selectString( $sQuery );

        return $this->count();
    }
}
