[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign skip_onload="true"}]

<div class="export">
    [{ oxmultilang ident="EIGHTSELECT_ADMIN_ATTRIBUTE_TITLE" }]
</div>

<p>&nbsp;</p>

[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<style type="text/css">
    #myedit th {
        color: #fff;
        background-color: #6a6c6f;
    }
    #myedit th,
    #myedit td{
        padding: 10px;
        text-align: left;
    }
    #myedit tr:nth-child(even) {
        background: #E9EFF5;
    }
</style>

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="oxid" value="1">
    <input type="hidden" name="cl" value="">
</form>

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cl" value="eightselect_admin_attribute_main">
    <input type="hidden" name="fnc" value="save">

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <thead>
            <tr>
                <th width="30%">[{ oxmultilang ident="EIGHTSELECT_ADMIN_ATTRIBUTE_TABLE_NAME" }]</th>
                <th width="40%">[{ oxmultilang ident="EIGHTSELECT_ADMIN_ATTRIBUTE_TABLE_DESC" }]</th>
                <th width="30%">[{ oxmultilang ident="EIGHTSELECT_ADMIN_ATTRIBUTE_TABLE_OXID" }]</th>
            </tr>
        </thead>
        <tbody>
            [{foreach from=$aAttributes item=oAttribute}]
                <tr>
                    <td valign="top" class="edittext" align="left">
                        [{ $oAttribute->eightselect_attributes__oxname->value }]
                        [{* ToDo change name to title *}]
                    </td>
                    <td class="edittext">
                        [{ $oAttribute->eightselect_attributes__oxdescription->value }]
                    </td>
                    <td class="edittext">
                        [{* ToDo join merge table information *}]
                    </td>
                </tr>
            [{/foreach}]
        </tbody>
    </table>

    <table cellspacing="0" cellpadding="0" border="0" width="98%">
        <tr>
            <td valign="top" class="edittext">
                <input type="submit" class="edittext" style="width: 210px;" name="save" value="[{ oxmultilang ident="GENERAL_SAVE" }]" [{ $readonly }]>
            </td>
        </tr>
    </table>
</form>

[{include file="bottomnaviitem.tpl" }]

[{include file="bottomitem.tpl"}]