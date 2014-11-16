[{assign var="oArtiles" value=$oView->getArticles()}]
[{if $oArtiles and $oArtiles->count()}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearcharticles.css')}]
<div id="ddrdiamondsearcharticles">
[{include file="widget/product/list.tpl" type=$oViewConf->getViewThemeParam('sStartPageListDisplayType')
          head=$oView->getBoxTitle() listId="newItems" products=$oArtiles showMainLink=true}]
</div>
[{/if}]