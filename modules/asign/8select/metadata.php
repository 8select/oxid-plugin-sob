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
    'title'       => 'A-SIGN GmbH - 8select CSE',
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
    'files'       => array(),
    'events'      => array(),
    'templates'   => array(),
    'blocks'      => array(),
    'settings'    => array(
        array(
            'group' => 'asign_8select_main',
            'name' => 'blASign8selectActive',
            'type' => 'bool',
            'value' => 'false',
        ),
        array('group' => 'asign_8select_main',
              'name' => 'blASign8selectApiId',
              'type' => 'str',
              'value' => '',
        ),
        array('group' => 'asign_8select_main',
              'name' => 'blASign8selectFeedId',
              'type' => 'str',
              'value' => '',
        ),
    ),
);
