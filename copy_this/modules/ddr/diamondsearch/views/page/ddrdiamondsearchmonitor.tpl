[{capture append="oxidBlock_content"}]
    [{assign var="template_title" value="DDR_DIAMONDSEARCH_MONITOR_TITLE"|oxmultilangassign }]
    [{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearchmonitor.css')}]
    [{oxscript add='jQuery(document).ready(function(){
            jQuery("ul.terms-list li").each(function(){
                jQuery(this).click(function(){
                    jQuery("input#searchParam").val(jQuery(this).text().replace(/ \((\d+)\)/, ""));
                    jQuery("form.search").submit();
                });
            });
        });'}]
    <h1 id="addressSettingsHeader" class="pageHead">[{$template_title}]</h1>
    [{block name="ddrdiamondsearch_block_monitror"}]
        [{if $oView->areThereManyLanguages()}]
            [{assign var="iStatsCount" value=2}]
        [{else}]
            [{assign var="iStatsCount" value=1}]
        [{/if}]
        <div class="diamond-search-monitor">
            <h2>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_INTRO"}]</h2>
            <table>
                [{section name=stats start=0 loop=$iStatsCount step=1}]
                    [{assign var="blAllLanguages" value=$smarty.section.stats.index}]
                    [{assign var="aFrequentTerms" value=$oView->getMostFrequentTerms($blAllLanguages)}]
                    <thead>
                    <tr>
                        <th colspan="2">
                            [{if $blAllLanguages}]
                                [{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_ALLLANGS"}]
                            [{else}]
                                [{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_CURRENTLANG"}]
                            [{/if}]
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_INDEXSIZE"}]:</td>
                        <td class="processed"><strong>[{$oView->getIndexSize($blAllLanguages)}]&nbsp;</strong></td>
                    </tr>
                    <tr>
                        <td>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_QUEUESIZE"}]:</td>
                        <td class="queued"><strong>[{$oView->getQueueSize($blAllLanguages)}]&nbsp;</strong></td>
                    </tr>
                    </tbody>
                [{/section}]
            </table>
            <h2>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_TOOLS"}]</h2>
             <button type="submit" class="submitButton largeButton" onclick="location.reload();">
                 [{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_INDEXNOW"}]
             </button>
            <button type="submit" class="submitButton largeButton"
                    onclick="alert('[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_REINDEXHINT"}]');">
                [{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_REINDEXALL"}]
            </button>
            <p class="footer">
                Powered by
                <a href="http://www.druteika.lt/#diamond_search_for_oxid_eshop" target="_blank">Diamond Search</a>
            </p>
        </div><!-- .diamond-search-monitor -->
    [{/block}]
    [{insert name="oxid_tracker" title=$template_title}]
[{/capture}]
[{capture append="oxidBlock_sidebar"}]
    [{include file="page/account/inc/account_menu.tpl" active_link="ddrdiamondsearch_link_monitror"}]
[{/capture}]
[{include file="layout/page.tpl" sidebar="Left"}]