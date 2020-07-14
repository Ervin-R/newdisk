<?php defined('SYSPATH') OR die('No direct access allowed.');

return [
    'default' => [
        'type' => 'MySQLi',
        'connection' => [
            'hostname' => 'localhost',
            'database' => 'nd',
            'username' => 'root',
            'password' => FALSE,
        ],
        'table_prefix' => '',
        'charset' => 'utf8mb4',
    ],
    
//    /**
//     * MySQLi driver config information
//     *
//     * The following options are available for MySQLi:
//     *
//     * string   hostname     server hostname, or socket
//     * string   database     database name
//     * string   username     database username
//     * string   password     database password
//     * boolean  persistent   use persistent connections?
//     * array    ssl          ssl parameters as "key => value" pairs.
//     *                       Available keys: client_key_path, client_cert_path, ca_cert_path, ca_dir_path, cipher
//     * array    variables    system variables as "key => value" pairs
//     *
//     * Ports and sockets may be appended to the hostname.
//     *
//     * MySQLi driver config example:
//     *
//     */
//    'alternate_mysqli' => [
//        'type' => 'MySQLi',
//        'connection' => [
//            'hostname' => 'localhost',
//            'database' => 'kohana',
//            'username' => FALSE,
//            'password' => FALSE,
//            'persistent' => FALSE,
//            'ssl' => NULL,
//        ],
//        'table_prefix' => '',
//        'charset' => 'utf8mb4',
//    ],
];
