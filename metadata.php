<?php
/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = [
    'id'          => 'asign_8select',
    'title'       => '8select CSE',
    'description' => '<p>Hier finden Sie die <b>Installationsanleitung für das Plugin: <a href="https://www.8select.com/8select-cse-installationsanleitung-oxid" target="_blank">8select CSE Installationsanleitung</a></b></p>
                      <p>Gerne begleiten wir Sie bei der Installation und stehen auch sonst für alle Fragen rund um die Installation zur Verfügung. Sie erreichen uns bei Fragen unter <b>+49 (0)941 20 609 6-10</b> und per E-Mail unter <b><a href="mailto:onboarding@8select.de">onboarding@8select.de</a></b></p>
                      <p>Ihr 8select-Team</p>',
    'thumbnail'   => '8selectLogo.jpeg',
    'version'     => '2.0.0',
    'author'      => 'A-SIGN GmbH',
    'url'         => 'https://www.a-sign.ch',
    'email'       => 'info@a-sign.ch',
    'extend'      => [
        'oxviewconfig'  => 'asign/8select/application/core/eightselect_oxviewconfig',
        'oxarticle'     => 'asign/8select/application/models/eightselect_oxarticle',
        'oxcmp_basket'  => 'asign/8select/application/components/eightselect_oxcmp_basket',
        'oxwminibasket' => 'asign/8select/application/components/eightselect_oxwminibasket',
        'module_config' => 'asign/8select/application/controllers/admin/eightselect_module_config',
    ],
    'files'       => [
        // Core
        'eightselect_events'       => 'asign/8select/core/eightselect_events.php',
        'eightselect_export'       => 'asign/8select/core/eightselect_export.php',
        'eightselect_attribute'    => 'asign/8select/core/eightselect_attribute.php',

        // Controllers
        'eightselect_products_api' => 'asign/8select/application/controllers/eightselect_products_api.php',

        // Models
        'eightselect_log'          => 'asign/8select/models/eightselect_log.php',
    ],
    'events'      => [
        'onActivate'   => 'eightselect_events::onActivate',
        'onDeactivate' => 'eightselect_events::onDeactivate',
    ],
    'templates'   => [
    ],
    'blocks'      => [
        [
            'template' => 'layout/base.tpl',
            'block'    => 'base_style',
            'file'     => '/application/views/blocks/base_style.tpl',
        ],
        [
            'template' => 'page/details/inc/related_products.tpl',
            'block'    => 'details_relatedproducts_similarproducts',
            'file'     => '/application/views/blocks/page/details/inc/eightselect_sys-psv.tpl',
        ],
        [
            'template' => 'page/checkout/thankyou.tpl',
            'block'    => 'checkout_thankyou_main',
            'file'     => '/application/views/blocks/page/checkout/eightselect_performance-tracking.tpl',
        ],
        [
            'template' => 'module_config.tpl',
            'block'    => 'admin_module_config_var_type_select',
            'file'     => '/application/views/blocks/eightselect_admin_module_config_var_type_select.tpl',
        ],
        [
            'template' => 'module_config.tpl',
            'block'    => 'admin_module_config_form',
            'file'     => '/application/views/blocks/eightselect_admin_module_config_form.tpl',
        ],
    ],
    'settings'    => [
        [
            'group' => 'eightselect_main',
            'name'  => 'blEightSelectActive',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'eightselect_main',
            'name'  => 'blEightSelectPreview',
            'type'  => 'bool',
            'value' => 'false',
        ],
        [
            'group' => 'eightselect_main',
            'name'  => 'sEightSelectApiId',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'eightselect_main',
            'name'  => 'sEightSelectFeedId',
            'type'  => 'str',
            'value' => '',
        ],
        [
            'group' => 'eightselect_widget',
            'name'  => 'blEightSelectWidgetSysPsv',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'eightselect_widget',
            'name'  => 'sArticleSkuField',
            'type'  => 'select',
            'value' => 'OXARTNUM',
        ],
        [
            'group' => 'eightselect_widget',
            'name'  => 'sArticleColorField',
            'type'  => 'select',
            'value' => 'oxvarselect;Farbe',
        ],
        [
            'group' => 'eightselect_feed',
            'name'  => 'sEightSelectExportNrOfFeeds',
            'type'  => 'str',
            'value' => '3',
        ],
    ],
];
