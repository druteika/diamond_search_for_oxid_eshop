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
            <li[{if $aValues.__selected__}] class="selected"[{/if}]>
                <label for="filter_id_[{$sField|lower}]">
                    [{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_"|cat:$sField}]
                </label>

                [{if $aValues.__selected__}]
                    [{foreach from=$aValues key="sValue" item="aData"}]
                        [{if $aData.selected}]
                            <div class="ui-state-hover">
                                [{$aData.label}]&nbsp;
                                <span class="reset"
                                      onclick="var value=encodeURIComponent('[{$sValue}]');
                                               location.href='[{$sFilterUrl}]&value=' + value + '&remove=1'">x</span>
                            </div>
                        [{/if}]
                    [{/foreach}]
                [{else}]

                <select id="filter_id_[{$sField|lower}]"
                        class="filter [{if $aValues.__selected__}]selected-filter[{else}]normal-filter[{/if}]"
                        name="filter_[{$sField|lower}]" multiple="" size="5">
                    [{foreach from=$aValues key="sValue" item="aData"}]
                        [{if $aValues.__selected__}]
                            [{if $aData.selected}]
                            <option value="[{$sValue}]" selected="">[{$aData.label}]</option>
                            [{/if}]
                        [{else}]
                            <option value="[{$sValue}]"[{if $aData.selected}]selected=""[{/if}]>[{$aData.label}]</option>
                        [{/if}]
                    [{/foreach}]
                </select>

                [{/if}]
            </li>
            [{/foreach}]
            <li class="reset reset-bottom">
                <a href="[{$sFilterUrl}]&reset=1">[{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_RESET"}]</a>
            </li>
        </ul>
    </div>
</div>
[{oxscript add="
    // Value sets filters
    $('select.normal-filter').multiselect({
        autoOpen: true,
        header: false,
        height: 175,
        minWidth: 167,
        click: function(event, ui){
            var url = '`$sFilterUrl`&value=' + encodeURIComponent(ui.value);
            if (!ui.checked) {
                url = url + '&remove=1';
            }
            location.href = url;
            return false;
        },
        beforeopen: function(event, ui){
            if ( $(this).attr('id') == 'filter_id_ddr_attr_color' ) {
                $('div.ui-multiselect-menu input[name=\"multiselect_filter_id_ddr_attr_color\"]').each(function(){
                    var label = $(this).parent();
                    label.addClass('colored');
                    label.addClass('color-' + $(this).val().toLowerCase().replace(' ', '-'));
                });
            }
        },
        beforeclose: function(event, ui) {
            event.preventDefault();
            event.stopPropagation;
            event.stopImmediatePropagation();
            return false;
        }
    });
	$('select.selected-filter').multiselect({
        autoOpen: true,
        header: false,
        height: 35,
        minWidth: 167,
        click: function(event, ui){
            var url = '`$sFilterUrl`&value=' + encodeURIComponent(ui.value);
            if (!ui.checked) {
                url = url + '&remove=1';
            }
            location.href = url;
            return false;
        },
        beforeopen: function(event, ui){
            if ( $(this).attr('id') == 'filter_id_ddr_attr_color' ) {
                $('div.ui-multiselect-menu input[name=\"multiselect_filter_id_ddr_attr_color\"]').each(function(){
                    var label = $(this).parent();
                    label.addClass('colored');
                    label.addClass('color-' + $(this).val().toLowerCase().replace(' ', '-'));
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