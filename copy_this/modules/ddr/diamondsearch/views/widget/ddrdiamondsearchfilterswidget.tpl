[{assign var="sSearchParam" value=$oView->getSearchParam()}]
[{assign var="aFilterValues" value=$oView->getFilterValues()}]
[{assign var="sRawFilterUrl" value=$oViewConf->getSslSelfLink()|cat:'&cl=ddrdiamondsearchfilter&fnc=filter&searchparam='}]
[{assign var="sRawFilterUrl" value=$sRawFilterUrl|cat:$sSearchParam}]
[{assign var="sFilterUrl" value=$sRawFilterUrl|replace:'&amp;':''}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/smoothness/jquery-ui-1.10.4.custom.min.css')}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/jquery.multiselect.css')}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/jquery.multiselect.filter.css')}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearchfilters.css')}]
[{oxscript include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/js/jquery.multiselect.min.js')}]
[{oxscript include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/js/jquery.multiselect.filter.min.js')}]
<div id="ddrdiamondsearchfilter" class="box">
    <h3>[{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_HEADNG"}]</h3>
    <div>
        <ul>
            <li class="reset reset-top">
                <a href="[{$sFilterUrl}]&reset=1">[{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_RESET"}]</a>
            </li>
            [{foreach from=$aFilterValues key="sField" item="aValues"}]
            <li>
                <label for="filter_id_[{$sField|lower}]">
                    [{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_"|cat:$sField}]
                </label>
                <select id="filter_id_[{$sField|lower}]" class="filter" name="filter_[{$sField|lower}]"
                        multiple="" size="5">
                    [{foreach from=$aValues key="sValue" item="aData"}]
                        <option value="[{$sValue}]"[{if $aData.selected}]selected=""[{/if}]>[{$aData.label}]</option>
                    [{/foreach}]
                </select>
            </li>
            [{/foreach}]
            <li class="reset reset-bottom">
                <a href="[{$sFilterUrl}]&reset=1">[{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_RESET"}]</a>
            </li>
        </ul>
    </div>
</div>
[{oxscript add="$('select.filter').multiselect({
        autoOpen: true,
        header: false,
        minWidth: 167,
        click: function(event, ui){
            var url = '`$sFilterUrl`&value=' + ui.value;
            if (!ui.checked) {
                url = url + '&remove=1';
            }
            location.href=url;
            return false;
        },
        beforeopen: function(event, ui){
            if ( $(this).attr('id') == 'filter_id_ddr_attr_color' ) {
                $('div.ui-multiselect-menu input[name=\"multiselect_filter_id_ddr_attr_color\"]').each(function(){
                    var label = $(this).parent();
                    label.css('background-color', $(this).val());
                    label.css('color', 'white');
                    label.css('text-shadow', '-1px 0 #555555, 0 1px #555555, 1px 0 #555555, 0 -1px #555555');
                });
            }
        },
        beforeclose: function(event, ui) {
            event.preventDefault();
            event.stopPropagation;
            event.stopImmediatePropagation();
            return false;
        }
    });"}]