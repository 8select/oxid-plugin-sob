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
    'title'       => '8select CSE by A-SIGN GmbH',
    'description' => [
        'de' => 'Modul für die 8select Curated Shopping Engine (CSE)',
        'en' => 'Module for 8select Curated Shopping Engine (CSE)',
    ],
    'thumbnail'   => 'asign_logo.png',
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
            'block'    => 'base_js',
            'file'     => '/application/views/blocks/base_js.tpl',
        ],
        [
            'template' => 'page/details/inc/related_products.tpl',
            'block'    => 'details_relatedproducts_similarproducts',
            'file'     => '/application/views/blocks/page/details/inc/eightselect_sys-psv.tpl',
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
            'group'      => 'eightselect_main',
            'name'       => 'sEightSelectModus',
            'type'       => 'select',
            'value'      => 'prod',
            'constrains' => 'int|prod',
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
            'group' => 'eightselect_feed',
            'name'  => 'blEightSelectExportVars',
            'type'  => 'bool',
            'value' => 'true',
        ],
        [
            'group' => 'eightselect_feed',
            'name'  => 'blEightSelectExportMainVars',
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
            'name'  => 'sEightSelectExportMinStock',
            'type'  => 'str',
            'value' => '0',
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
