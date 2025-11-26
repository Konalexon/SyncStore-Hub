<?php
$env = file_get_contents('.env');
if (strpos($env, 'APP_KEY=') !== false && strpos($env, 'APP_KEY=base64') === false) {
    $key = 'base64:' . base64_encode(random_bytes(32));
    $env = str_replace('APP_KEY=', 'APP_KEY=' . $key, $env);
    file_put_contents('.env', $env);
    echo "Key set successfully.";
} else {
    echo "Key already set or APP_KEY not found.";
}
