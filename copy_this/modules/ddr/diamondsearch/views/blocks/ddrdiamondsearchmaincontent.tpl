[{if !$smarty.get or !$smarty.get.cl or $smarty.get.cl eq 'start'}]
[{oxid_include_widget cl="DdrDiamondSearchArticlesWidget"}]
[{/if}]
[{$smarty.block.parent}]