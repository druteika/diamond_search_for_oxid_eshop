[{assign var="aFormValues" value=$oView->getFormValues()}]
[{assign var="sRawFilterUrl" value=$oViewConf->getSslSelfLink()|cat:'&cl=ddrdiamondsearchfilter&fnc=filter&value='}]
[{assign var="sFilterUrl" value=$sRawFilterUrl|replace:'&amp;':''}]
[{if $aFormValues}]
[{oxstyle include=$oViewConf->getModuleUrl('ddr/diamondsearch', 'out/src/css/ddrdiamondsearchform.css')}]
<div id="ddrdiamondsearchform" class="box">
    <h3>[{oxmultilang ident="DDR_DIAMONDSEARCH_FORM_TITLE"}]</h3>
    <div class="content">
        [{foreach from=$aFormValues key="sField" item="aValues"}]
        <label for="filter_id_[{$sField|lower}]">
            [{oxmultilang ident="DDR_DIAMONDSEARCH_FILTER_"|cat:$sField}]
        </label>
        <select class="ddrdiamondsearchform-filter" id="filter_id_[{$sField|lower}]" name="filter_[{$sField|lower}]">
            <option value="">-</option>
            [{foreach from=$aValues key="sValue" item="aData"}]
            <option value="[{$sValue}]">[{$aData.label}]</option>
            [{/foreach}]
        </select>
        [{/foreach}]
        <label class="center" for="ddrdiamondsearchform_query">
            - [{oxmultilang ident="DDR_DIAMONDSEARCH_FORM_OR"}] -
        </label>
        <input type="text" id="ddrdiamondsearchform_query" name="query"/>
        <button id="ddrdiamondsearchform_go" class="submitButton largeButton">
            [{oxmultilang ident="DDR_DIAMONDSEARCH_FORM_GO"}]
        </button>
        <div class="clear"><!-- --></div>
    </div>
</div>
[{oxscript add="$(document).ready(function () {
        // Advances search filters trigger when all are selected
        var filters = $('select.ddrdiamondsearchform-filter');
        filters.attr('disabled', 'disabled');
        filters.first().removeAttr('disabled');
        filters.change(function () {
            if ($(this).val()) {
                var select = $(this).next().next();
                if (select.hasClass('ddrdiamondsearchform-filter')) {
                    select.removeAttr('disabled');
                } else {
                    var values = '';
                    filters.each(function () {
                        if ($(this).val()) {
                            values = values + $(this).val() + '|';
                        }
                    });
                    location.href = '`$sFilterUrl`' + values;
                    return false;
                }
            }
        });

        // Advanced seach filed action
        $('button#ddrdiamondsearchform_go').click(function(){
            var query = $('input#ddrdiamondsearchform_query').val();
            if (query) {
                $('input#searchParam').val(query);
                $('form[name=\"search\"]').submit();
            }
        });
        $('input#ddrdiamondsearchform_query').keypress(function(e) {
            var query = $('input#ddrdiamondsearchform_query').val();
            if((e.which == 13) && query) {
                $('input#searchParam').val(query);
                $('form[name=\"search\"]').submit();
            }
        });
    });"}]
[{/if}]