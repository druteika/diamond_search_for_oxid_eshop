[{capture append="oxidBlock_content"}]
    [{assign var="template_title" value="DDR_DIAMONDSEARCH_MONITOR_TITLE"|oxmultilangassign }]
    [{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearchmonitor.css')}]
    <h1 id="addressSettingsHeader" class="pageHead">[{$template_title}]</h1>
    [{block name="ddrdiamondsearch_block_monitror"}]
        <div class="diamond-search-monitor">
        <h2>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_INTRO"}]</h2>
        <p><i>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_CEINFO"}]</i></p>
        <table>
            <thead>
                <tr>
                    <th colspan="2">[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_ALLSHOPS"}]</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_QUEUESIZE"}]:</td>
                    <td><strong>[{$oView->getQueueSize()}]&nbsp;</strong></td>
                </tr>
                <tr>
                    <td>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_TERMSCOUNT"}]:</td>
                    <td><strong>[{$oView->getTermsCount()}]&nbsp;</strong></td>
                </tr>
                <tr>
                    <td>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_TOPUSEDTERMS"}]:</td>
                    <td><strong>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_EEPEONLY"}]&nbsp;</strong></td>
                </tr>
                <tr>
                    <td>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_TOPSEARCHEDTERMS"}]:</td>
                    <td><strong>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_EEPEONLY"}]&nbsp;</strong></td>
                </tr>
            </tbody>
            [{*nice2have: Add more stats<thead>
                <tr>
                    <th rowspan="2">[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_CURRENTSHOP"}]</th>
                </tr>
            </thead>*}]
        </table>
        <p>[{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_MORETOCOME"}]</p>
         <button type="submit" class="submitButton largeButton" onclick="location.reload();">
             [{oxmultilang ident="DDR_DIAMONDSEARCH_MONITOR_INDEXNOW"}]
         </button>
        </div><!-- .diamond-search-monitor -->
    [{/block}]
    [{insert name="oxid_tracker" title=$template_title}]
[{/capture}]
[{capture append="oxidBlock_sidebar"}]
    [{include file="page/account/inc/account_menu.tpl" active_link="ddrdiamondsearch_link_monitror"}]
[{/capture}]
[{include file="layout/page.tpl" sidebar="Left"}]