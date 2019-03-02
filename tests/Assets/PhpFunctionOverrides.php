<?php
/**
 * Override PHP namespaced functions into the Slim\App namespace.
 *
 * header() and headers_sent() are from Zend-Diactoros zend-diactoros/test/TestAsset/Functions.php and are
 * Copyright (c) 2015-2016 Zend Technologies USA Inc. (http://www.zend.com) and are licensed under the New BSD License
 * at https://github.com/zendframework/zend-diactoros/blob/master/LICENSE.md.
 *
 */
namespace Slim;

use Slim\Tests\Assets\HeaderStack;

/**
 * Have headers been sent?
 *
 * @return false
 */
function headers_sent()
{
    return false;
}

/**
 * Emit a header, without creating actual output artifacts
 *
 * @param string   $string
 * @param bool     $replace
 * @param int|null $statusCode
 */
function header($string, $replace = true, $statusCode = null)
{
    HeaderStack::push(
        [
            'header'      => $string,
            'replace'     => $replace,
            'status_code' => $statusCode,
        ]
    );
}

/**
 * Is a file descriptor writable
 *
 * @param $file
 * @return bool
 */
function is_readable($file)
{
    if (stripos($file, 'non-readable.cache') !== false) {
        return false;
    }
    return true;
}

/**
 * Is a path writable
 *
 * @param $path
 * @return bool
 */
function is_writable($path)
{
    if (stripos($path, 'non-writable-directory') !== false) {
        return false;
    }
    return true;
}
