[{if !$oViewConf}]
    [{assign var="oViewConf" value=$oView->getConfig()}]
[{/if}]

[{if $oViewConf->isEightSelectActive()}]
    [{if !$oDetailsProduct}]
        [{assign var="oDetailsProduct" value=$oView->getProduct()}]
    [{/if}]
    <div class="eightselect-widget-container" style="display: none;">
        <div data-sku="[{$oDetailsProduct->getFieldData('oxartnum')}]" data-8select-widget-id="sys-psv"></div>
    </div>
[{else}]
    [{$smarty.block.parent}]
[{/if}]
