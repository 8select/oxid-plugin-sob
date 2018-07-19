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
    'version'     => '1.0.0',
    'author'      => 'A-SIGN GmbH',
    'url'         => 'https://www.a-sign.ch',
    'email'       => 'info@a-sign.ch',
    'extend'      => [
        'oxviewconfig' => 'asign/8select/application/core/eightselect_oxviewconfig',
    ],
    'files'       => [
        // Core
        'eightselect_dispatcher'           => 'asign/8select/core/eightselect_dispatcher.php',
        'eightselect_events'               => 'asign/8select/core/eightselect_events.php',
        'eightselect_request'              => 'asign/8select/core/eightselect_request.php',

        // Controllers
        'eightselect_admin_attribute'      => 'asign/8select/application/controllers/admin/eightselect_admin_attribute.php',
        'eightselect_admin_attribute_main' => 'asign/8select/application/controllers/admin/eightselect_admin_attribute_main.php',
        'eightselect_admin_export'         => 'asign/8select/application/controllers/admin/eightselect_admin_export.php',
        'eightselect_admin_export_do'      => 'asign/8select/application/controllers/admin/eightselect_admin_export_do.php',
        'eightselect_admin_export_main'    => 'asign/8select/application/controllers/admin/eightselect_admin_export_main.php',
        'eightselect_admin_export_upload'  => 'asign/8select/application/controllers/admin/eightselect_admin_export_upload.php',

        // Models
        'eightselect_attribute'            => 'asign/8select/models/eightselect_attribute.php',
        'eightselect_attribute2oxid'       => 'asign/8select/models/eightselect_attribute2oxid.php',
        'eightselect_aws'                  => 'asign/8select/models/eightselect_aws.php',
        'eightselect_export'               => 'asign/8select/models/eightselect_export.php',
        'eightselect_log'                  => 'asign/8select/models/eightselect_log.php',
        'eightselect_export_abstract'      => 'asign/8select/models/export/eightselect_export_abstract.php',
        'eightselect_export_dynamic'       => 'asign/8select/models/export/eightselect_export_dynamic.php',
        'eightselect_export_static'        => 'asign/8select/models/export/eightselect_export_static.php',
    ],
    'events'      => [
        'onActivate'   => 'eightselect_events::onActivate',
        'onDeactivate' => 'eightselect_events::onDeactivate',
    ],
    'templates'   => [
        'eightselect_admin_attribute.tpl'      => 'asign/8select/application/views/admin/tpl/eightselect_admin_attribute.tpl',
        'eightselect_admin_attribute_main.tpl' => 'asign/8select/application/views/admin/tpl/eightselect_admin_attribute_main.tpl',
        'eightselect_admin_export.tpl'         => 'asign/8select/application/views/admin/tpl/eightselect_admin_export.tpl',
        'eightselect_admin_export_do.tpl'      => 'asign/8select/application/views/admin/tpl/eightselect_admin_export_do.tpl',
        'eightselect_admin_export_main.tpl'    => 'asign/8select/application/views/admin/tpl/eightselect_admin_export_main.tpl',
        'eightselect_admin_export_upload.tpl'  => 'asign/8select/application/views/admin/tpl/eightselect_admin_export_upload.tpl',
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
            'group' => 'eightselect_feed',
            'name'  => 'sEightSelectExportNrOfFeeds',
            'type'  => 'str',
            'value' => '3',
        ],
        [
            'group' => 'eightselect_feed',
            'name'  => 'sEightSelectVarSelectSize',
            'type'  => 'str',
            'value' => 'Größe',
        ],
        [
            'group' => 'eightselect_feed',
            'name'  => 'sEightSelectVarSelectColor',
            'type'  => 'str',
            'value' => 'Farbe',
        ],
        [
            'group' => 'eightselect_csv',
            'name'  => 'sEightSelectCsvDelimiter',
            'type'  => 'str',
            'value' => ';',
        ],
        [
            'group' => 'eightselect_csv',
            'name'  => 'sEightSelectCsvQualifier',
            'type'  => 'str',
            'value' => '"',
        ],
        [
            'group' => 'eightselect_csv',
            'name'  => 'sEightSelectCsvMultiDelimiter',
            'type'  => 'str',
            'value' => '|',
        ],
    ],
];
