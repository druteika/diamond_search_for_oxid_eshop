[{if !$smarty.get or !$smarty.get.cl or $smarty.get.cl eq 'start'}]
[{oxid_include_widget cl="DdrDiamondSearchFormWidget"}]
[{elseif $smarty.get.cl eq 'search' or $smarty.get.cl eq 'alist'}]
[{oxid_include_widget cl="DdrDiamondSearchFiltersWidget"}]
[{/if}]
[{$smarty.block.parent}]