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
    'extend'      => [],
    'files'       => [
        // Core
        'eightselect_events'               => 'asign/8select/core/eightselect_events.php',

        // Controllers
        'eightselect_admin_attribute'      => 'asign/8select/application/controllers/admin/eightselect_admin_attribute.php',
        'eightselect_admin_attribute_main' => 'asign/8select/application/controllers/admin/eightselect_admin_attribute_main.php',
        'eightselect_admin_export'         => 'asign/8select/application/controllers/admin/eightselect_admin_export.php',
        'eightselect_admin_export_do'      => 'asign/8select/application/controllers/admin/eightselect_admin_export_do.php',
        'eightselect_admin_export_main'    => 'asign/8select/application/controllers/admin/eightselect_admin_export_main.php',

        // Models
        'eightselect_attribute'            => 'asign/8select/models/eightselect_attribute.php',
        'eightselect_attribute2oxid'       => 'asign/8select/models/eightselect_attribute2oxid.php',
        'eightselect_export'               => 'asign/8select/models/eightselect_export.php',
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
        'eightselect_admin_export_gen.tpl'     => 'asign/8select/application/views/admin/tpl/eightselect_admin_export_gen.tpl',
        'eightselect_admin_export_main.tpl'    => 'asign/8select/application/views/admin/tpl/eightselect_admin_export_main.tpl',
    ],
    'blocks'      => [],
    'settings'    => [
        [
            'group' => 'eightselect_main',
            'name'  => 'blEightSelectActive',
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
