<?php
/**
 * Use this file to override global defaults.
 *
 * See the individual environment DB configs for specific config information.
 */

return array(
  'active' => 'default',
 
/**
 * Base config, just need to set the DSN, username and password in env. config.
 */
  'default' => array(
    'type' => 'pdo',
    'connection' => array(
      'persistent' => false,
    ),
    'identifier' => '"',
    'table_prefix' => '',
    'charset' => NULL,
    'enable_cache' => true,
    'profiling' => false,
  ),
);