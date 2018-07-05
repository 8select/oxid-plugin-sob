[{include file="headitem.tpl" box="export "
    title="GENERAL_ADMIN_TITLE"|oxmultilangassign
    meta_refresh_sec=$refresh
    meta_refresh_url=$oViewConf->getSelfLink()|cat:"&cl=`$sClassDo`&iStart=`$iStart`&fnc=run&`$sType`=true"
}]

[{ oxmultilang ident="eightselect_admin_common" }] - [{ oxmultilang ident="eightselect_admin_export" }] -

[{if !isset($refresh)}]
    [{if !isset($iError) }]
         [{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_EXPORTNOTSTARTED" }]
    [{else}]
        [{if $iError}]
            [{if $iError == -2}]
                [{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_EXPORTEND" }]
            <b>[{ assign var='oxDownloadFile' value=$sDownloadFile }][{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_SUCCESS" args=$oxDownloadFile }]</b><br>
                [{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_LINK" }]<em>[{$sDownloadFile}]</em>
            [{/if}]

            [{if $iError == -1}][{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_UNKNOWNERROR" }][{/if}]
            [{if $iError == 1 }][{ assign var='oxOutputFile' value=$sOutputFile }][{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_DO_EXPORTFILE" args=$oxOutputFile}][{/if}]
        [{/if}]
    [{/if}]
[{else}]
  [{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_EXPRUNNING" }] [{ oxmultilang ident="EIGHTSELECT_ADMIN_EXPORT_EXPORTEDITEMS" }] [{$iExpItems|default:0}]
[{/if}]

[{include file="bottomitem.tpl"}]
