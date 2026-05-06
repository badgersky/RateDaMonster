<?php

$variables = parse_ini_file('.env');

foreach ($variables as $key => $value) {
    define($key, $value);
}

define('USERNAME', POSTGRES_USER);
define('PASSWORD', POSTGRES_PASSWORD);
define('HOST', 'db');
define('DATABASE', POSTGRES_DB);