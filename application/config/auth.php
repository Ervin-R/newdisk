<?php defined('SYSPATH') OR die('No direct access allowed.');

return [
    'driver'       => 'ORM',
    'hash_method'  => 'sha256',
    'hash_key'     => 'test_app_hash_key_dfghfg', // The key to use when hashing the password
    'lifetime'     => Date::MONTH * 2,    // Lifetime for autologin token
    'session_type' => 'native',         // Stores sessions in a database using the Session_Database adapter
    'session_key'  => 'auth_user',
];
