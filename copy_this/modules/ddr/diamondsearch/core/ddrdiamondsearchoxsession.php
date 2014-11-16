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
 * Class DdrDiamondSearchOxSession overloads oxSession
 *
 * @see oxSession
 */
class DdrDiamondSearchOxSession extends DdrDiamondSearchOxSession_parent
{

    /**
     * Overloaded parent method.
     * Force session start for Diamond Search filters on older shops.
     *
     * @inheritDoc
     */
    protected function _forceSessionStart()
    {
        return !oxRegistry::getUtils()->isSearchEngine();
    }
}
