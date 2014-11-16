[{$smarty.block.parent}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearchautocomplete.css')}]
[{assign var="sRawTermsSearchUrl" value=$oViewConf->getSslSelfLink()|cat:'&cl=ddrdiamondsearchfindterms'}]
[{assign var="sTermsSearchUrl" value=$sRawTermsSearchUrl|replace:'&amp;':''}]
[{oxscript add="$('input#searchParam, input#ddrdiamondsearchform_query').autocomplete({
        delay: 250,
        minLength: 2,
        source: '`$sTermsSearchUrl`',
        select: function( event, ui ) {
            $(this).val( ui.item['value'] );
            if ( $(this).attr('id') == 'ddrdiamondsearchform_query' ) {
                // Advanced search form case
                $('input#searchParam').val(ui.item['value']);
            }
            $('form[name=\"search\"]').submit();
        }
    });"}]
[{oxid_include_widget cl="DdrDiamondSearchIndexingWidget"}]