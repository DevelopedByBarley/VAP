<?php
if (
    isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}

$url = $protocol . $_SERVER['HTTP_HOST'];

define('CURRENT_URL', $url);

define('MAILER_CONFIG', [
    "userName" => "",
    "password" => "",
    "host" => "owa.rufusz.hu",
    "setForm" => [
        "from" => "noreply@volunteerap.hu",
        "to" => "VAP Team - Noreply",
    ],
]);

define('MAINTENANCE_PERMISSION', 0);
