[{if !$oViewConf}]
    [{assign var="oViewConf" value=$oView->getConfig()}]
    [{/if}]

[{if $oViewConf->isEightSelectActive()}]
    <script type="text/javascript">
        (function (d, s, w) {
            var apiId = '[{ $oViewConf->getEightSelectApiId() }]';

            window.eightlytics || function (w) {
                w.eightlytics = function () {
                    window.eightlytics.queue = window.eightlytics.queue || [];
                    window.eightlytics.queue.push(arguments);
                };
            }(w);
            var script = d.createElement(s);
            script.src = 'https://wgt.8select.io/' + apiId + '/loader.js';
            var entry = d.getElementsByTagName(s)[0];
            entry.parentNode.insertBefore(script, entry);
        })(document, 'script', window);
    </script>

    <script type="text/javascript">
        window._eightselect_config = window._eightselect_config || [];
        window._eightselect_config['sys'] = {
            callback: function (error, sku, widgetUuid) {
                if (error) {
                    return;
                }
                document.querySelector('[data-8select-widget-id=sys-psv]').style.display = 'block';
            }
        };
        window._stoken = "[{$oViewConf->getSessionChallengeToken()}]";
        window._eightselect_shop_plugin = window._eightselect_shop_plugin || {};
        window._eightselect_shop_plugin.addToCart = function(sku, quantity, Promise) {
            var jqueryFail = function(reject) {
                return function(jqXHR, textStatus, errorThrown) {
                    return reject(errorThrown);
                }
            };

            return new Promise(function(resolve, reject) {
                try {
                    jQuery.post('[{$oViewConf->getSelfActionLink()}]', {
                        stoken: window._stoken,
                        cl: 'start',
                        fnc: 'tobasket',
                        sku: sku,
                        am: quantity
                    })
                    .done(resolve)
                    .fail(jqueryFail(reject));
                } catch (error) {
                    reject(error);
                }
            }).then(function() {
                return new Promise(function(resolve, reject) {
                    jQuery.post('[{$oViewConf->getSelfActionLink()}]', {
                        cl: 'oxwMinibasket'
                    })
                    .done(function(data, status) {
                        //ToDo: replace first element of return value with exiting content element
                        resolve();
                    })
                    .fail(jqueryFail(reject));
                });

                // ToDo: add second call for basket count
            });
        };
    </script>
[{/if}]

[{$smarty.block.parent}]
