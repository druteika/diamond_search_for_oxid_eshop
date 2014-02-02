<?php

/**
 * Class DdrDiamondSearchOxBase.
 * Additional oxBase layer implementing common reusable Diamond search models features.
 *
 * @todo: Implement common getters and setters and use in models.
 */
class DdrDiamondSearchOxBase extends oxBase
{

    /**
     * Compiles an SQL query where clause snippet for current active shop and language.
     *
     * @param string $sTable
     *
     * @return string
     */
    public function getShopAndLanguageSnippet( $sTable = '' )
    {
        /** @var DdrDiamondSearchModule $oModule */
        $oModule = oxRegistry::get( 'DdrDiamondSearchModule' );

        $oDb = oxDb::getDb();

        $sTable = !empty( $sTable ) ? "`" . $sTable . "`." : "";

        return sprintf(
            " %s`DDRSHOPID` = %s AND %s`DDRLANGID` = %s AND ",
            $sTable,
            $oDb->quote( $oModule->getShopId() ),
            $sTable,
            $oDb->quote( $oModule->getLanguageId() )
        );
    }

    /**
     * Alias for oxDb quote method.
     *
     * @param string $sString
     *
     * @return mixed
     */
    public function quote( $sString )
    {
        // @codeCoverageIgnoreStart
        return oxDb::getDb()->quote( $sString );
        // @codeCoverageIgnoreEnd
    }
}
