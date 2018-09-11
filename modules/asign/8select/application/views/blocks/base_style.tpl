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
                    window.eightlytics.queue.push(arguments)
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
                    return
                }
                document.querySelector('[data-8select-widget-id=sys-psv]').style.display = 'block'
            }
        };
        window._stoken = "[{$oViewConf->getSessionChallengeToken()}]";
        window._eightselect_shop_plugin = window._eightselect_shop_plugin || {};
        window._eightselect_shop_plugin.addToCart = function (sku, quantity, Promise) {
            var reject = function (jqXHR, textStatus, errorThrown) {
                return Promise.reject(errorThrown);
            };

            var updateMinibasket = function(){
                jQuery.getJSON("[{$oViewConf->getSelfActionLink()}]", {
                    stoken: window._stoken,
                    cl: "start",
                    fnc: "getAjaxBasket",
                    returntype: 'json',
                })
                .done(function(data, status){
                    try {
                        if (data.basket_ajax) {
                            $(".minibasket-menu").replaceWith( data.basket_ajax );
                            $(".shopping-bag-text").html( data.count_ajax );
                        }
                        if (data.stoken_ajax) {
                            $("input[name=stoken]").val( data.stoken_ajax );
                            window._stoken = data.stoken_ajax;
                        }
                    } catch (error) {
                        console.log(error)
                    }
                    return Promise.resolve();
                })
                .fail(reject);
            };

            try {
                jQuery.post(
                    '[{$oViewConf->getSelfActionLink()}]',
                    {
                        stoken: window._stoken,
                        cl: "start",
                        fnc: "tobasket",
                        sku: sku,
                        am: quantity
                    }
                )
                .done(updateMinibasket)
                .fail(reject);
            } catch (error) {
                return Promise.reject(error);
            }
        };
    </script>
    [{/if}]

[{$smarty.block.parent}]
