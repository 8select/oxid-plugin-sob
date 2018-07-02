<?php
/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    'id'          => 'asign_8select',
    'title'       => '8select CSE by A-SIGN GmbH',
    'description' => array(
        'de' => 'Modul für die 8select Curated Shopping Engine (CSE)',
        'en' => 'Module for 8select Curated Shopping Engine (CSE)',
    ),
    'thumbnail'   => 'asign_logo.png',
    'version'     => '1.0.0',
    'author'      => 'A-SIGN GmbH',
    'url'         => 'https://www.a-sign.ch',
    'email'       => 'info@a-sign.ch',
    'extend'      => array(),
    'files'       => array(
        // Core
        'eightselect_events'               => 'asign/8select/core/eightselect_events.php',

        // Controllers
        'eightselect_admin_attribute'      => 'asign/8select/application/controllers/admin/eightselect_admin_attribute.php',
        'eightselect_admin_attribute_main' => 'asign/8select/application/controllers/admin/eightselect_admin_attribute_main.php',

        // Models
        'eightselect_attribute'            => 'asign/8select/models/eightselect_attribute.php',
        'eightselect_attribute2oxid'       => 'asign/8select/models/eightselect_attribute2oxid.php',
    ),
    'events'      => array(
        'onActivate'   => 'eightselect_events::onActivate',
        'onDeactivate' => 'eightselect_events::onDeactivate',
    ),
    'templates'   => array(
        'eightselect_admin_attribute.tpl'      => 'asign/8select/application/views/admin/tpl/eightselect_admin_attribute.tpl',
        'eightselect_admin_attribute_main.tpl' => 'asign/8select/application/views/admin/tpl/eightselect_admin_attribute_main.tpl',
    ),
    'blocks'      => array(),
    'settings'    => array(
        array(
            'group' => 'eightselect_main',
            'name'  => 'blEightSelectActive',
            'type'  => 'bool',
            'value' => 'false',
        ),
        array('group' => 'eightselect_main',
              'name'  => 'blEightSelectApiId',
              'type'  => 'str',
              'value' => '',
        ),
        array('group' => 'eightselect_main',
              'name'  => 'blEightSelectFeedId',
              'type'  => 'str',
              'value' => '',
        ),
    ),
);
