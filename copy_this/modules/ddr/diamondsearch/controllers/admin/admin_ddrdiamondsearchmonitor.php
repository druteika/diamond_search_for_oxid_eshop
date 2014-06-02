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
 * Class Admin_DdrDiamondSearchMonitor.
 */
class Admin_DdrDiamondSearchMonitor extends oxAdminView
{

    /**
     * Redirect to the Diamond Search monitor page on front-end.
     *
     * @return null
     */
    public function render()
    {
        printf(
            '<script type="text/javascript">window.top.location.href = "%s";</script>',
            sprintf( '%s?cl=ddrdiamondsearchmonitor', $this->getConfig()->getCurrentShopUrl( false ) )
        );

        exit();
    }
}
