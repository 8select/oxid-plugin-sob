[{$smarty.block.parent}]

[{if method_exists($oView, 'showEightSelectReInitSys') && $oView->showEightSelectReInitSys() }]
    [{oxscript add='window._8select.reinitSys("'|cat:$oView->getEightSelectPreviousNr()|cat:'", "'|cat:$oView->getEightSelectCurrentNr()|cat:'");'}]
[{/if}]
