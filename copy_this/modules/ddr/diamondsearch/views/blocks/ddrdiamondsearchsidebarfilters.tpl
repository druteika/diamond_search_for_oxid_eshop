[{if $smarty.get.cl eq 'search' or $smarty.get.cl eq 'alist'}]
[{oxid_include_widget cl="DdrDiamondSearchFiltersWidget"}]
[{/if}]
[{$smarty.block.parent}]