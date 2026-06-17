<?php
require_once dirname(__DIR__) . '/shared-ui/bootstrap.php';

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

    $host = strtolower(curriculum_request_host());
    if ($host === 'localhost'
        || strpos($host, 'localhost:') === 0
        || strpos($host, '127.0.0.1') === 0
        || strpos($host, '[::1]') === 0
        || $host === '::1') {
        return 'http';
    }

    return 'https';
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

function curriculum_public_origin()
{
    $envOrigin = getenv('AR_PUBLIC_ORIGIN');
    if ($envOrigin) {
        return function_exists('shared_auth_normalize_origin')
            ? shared_auth_normalize_origin($envOrigin)
            : rtrim(trim($envOrigin), '/');
    }

    return curriculum_request_origin();
}

function curriculum_shared_auth_broker_path()
{
    $envPath = getenv('AR_SHARED_AUTH_BROKER_PATH');
    if ($envPath && is_file($envPath)) {
        return $envPath;
    }

    $documentRoot = rtrim((string) ($_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $candidates = array_filter(array(
        dirname(__DIR__) . '/sharedAuth/broker.php',
        dirname(__DIR__, 2) . '/sharedAuth/broker.php',
        $documentRoot !== '' ? $documentRoot . '/Web/sharedAuth/broker.php' : null,
        $documentRoot !== '' ? $documentRoot . '/sharedAuth/broker.php' : null,
    ));

    foreach ($candidates as $candidate) {
        if (is_file($candidate)) {
            return $candidate;
        }
    }

    throw new RuntimeException(
        'Unable to locate sharedAuth/broker.php. Set AR_SHARED_AUTH_BROKER_PATH or place the file in a supported location.'
    );
}

function curriculum_current_path()
{
    return strtok($_SERVER['REQUEST_URI'] ?? '/index.php', '?') ?: '/index.php';
}

function curriculum_remove_auth_params(array $params)
{
    unset($params['login'], $params['logout'], $params['ticket'], $params['auth']);
    return $params;
}

function curriculum_current_url_without_auth_params()
{
    $path = curriculum_current_path();
    $params = curriculum_remove_auth_params($_GET);
    $query = http_build_query($params);

    return curriculum_public_origin() . $path . ($query ? ('?' . $query) : '');
}

function curriculum_clear_session_user()
{
    unset($_SESSION['auth_user']);
}

function curriculum_destroy_session()
{
    curriculum_clear_session_user();

    if (session_status() === PHP_SESSION_ACTIVE) {
        $cookieParams = session_get_cookie_params();
        $_SESSION = array();

        if (!headers_sent()) {
            setcookie(
                session_name(),
                '',
                time() - 3600,
                $cookieParams['path'] ?? '/',
                $cookieParams['domain'] ?? '',
                !empty($cookieParams['secure']),
                !empty($cookieParams['httponly'])
            );
        }

        session_destroy();
    }
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
