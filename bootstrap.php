<?php
function curriculum_request_scheme()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        $values = explode(',', $_SERVER['HTTP_X_FORWARDED_PROTO']);
        return strtolower(trim($values[0])) === 'https' ? 'https' : 'http';
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_PROTOCOL'])) {
        $values = explode(',', $_SERVER['HTTP_X_FORWARDED_PROTOCOL']);
        return strtolower(trim($values[0])) === 'https' ? 'https' : 'http';
    }

    if (!empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower((string) $_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
        return 'https';
    }

    if (!empty($_SERVER['HTTPS']) && strcasecmp((string) $_SERVER['HTTPS'], 'off') !== 0) {
        return 'https';
    }

    return 'http';
}

function curriculum_request_host()
{
    if (!empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        $hosts = explode(',', $_SERVER['HTTP_X_FORWARDED_HOST']);
        $host = trim($hosts[0]);
        if ($host !== '') {
            return $host;
        }
    }

    if (!empty($_SERVER['HTTP_HOST'])) {
        return $_SERVER['HTTP_HOST'];
    }

    if (!empty($_SERVER['SERVER_NAME'])) {
        return $_SERVER['SERVER_NAME'];
    }

    return 'localhost';
}

function curriculum_request_origin()
{
    return curriculum_request_scheme() . '://' . curriculum_request_host();
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params(array(
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => curriculum_request_scheme() === 'https',
        'httponly' => true,
        'samesite' => 'Lax',
    ));
    session_start();
}
