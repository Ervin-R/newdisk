<?php

return [
    
    // File cache
    'file' => array(
        'driver' => 'file',
        'cache_dir' => APPPATH . 'cache',
        'default_expire' => 300,
        'ignore_on_delete' => array(
            '.gitignore',
            '.git',
        ),
    ),
];
