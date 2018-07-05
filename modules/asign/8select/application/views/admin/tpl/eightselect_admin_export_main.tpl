[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign skip_onload="true"}]

<script type="text/javascript">
    if(top)
    {
        top.sMenuItem    = "[{ oxmultilang ident="eightselect_admin_common" }]";
        top.sMenuSubItem = "[{ oxmultilang ident="eightselect_admin_export" }]";
        top.sWorkArea    = "[{$_act}]";
        top.setTitle();
    }
</script>

[{if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="1">
    <input type="hidden" name="cl" value="">
</form>

<table cellspacing="0" cellpadding="0" border="0" width="98%">
    <tr>
        <td valign="top" class="edittext">
            <form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" target="eightselect_admin_export_do" method="post">
                <input type="hidden" name="cl" value="[{$sClassDo}]">
                <input type="hidden" name="fnc" value="start">
                <input type="hidden" name="blExportVars" value="[{$blEightSelectExportVars}]">
                <input type="hidden" name="blExportMainVars" value="[{$blEightSelectExportMainVars}]">
                <input type="hidden" name="sExportMinStock" value="[{$sEightSelectExportMinStock}]">
                [{ $oViewConf->getHiddenSid() }]
                <input type="submit" class="edittext" name="do_full" value="[{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_FULL" }]" [{ $readonly }]>
                <input type="submit" class="edittext" name="do_update" value="[{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_UPDATE" }]" [{ $readonly }]>
            </form>
        </td>
    </tr>
</table>

[{include file="bottomnaviitem.tpl" }]

[{include file="bottomitem.tpl"}]