[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearchautocomplete.css')}]
[{assign var="sRawTermsSearchUrl" value=$oViewConf->getSslSelfLink()|cat:'&cl=ddrdiamondsearchfindterms'}]
[{assign var="sTermsSearchUrl" value=$sRawTermsSearchUrl|replace:'&amp;':''}]
[{oxscript add="$('input#searchParam').autocomplete({
        delay: 250,
        minLength: 2,
        source: '`$sTermsSearchUrl`',
        select: function( event, ui ) {
            $(this).val( ui.item['value'] );
            $(this).parent('div.searchBox').parent('form.search').submit();
        }
    });"}]