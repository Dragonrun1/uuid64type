<?php
declare(strict_types=1);
/**
 * Contains Bootstrap.
 *
 * PHP version 7.2+
 *
 */
/*
 * Nothing to do if Composer auto loader already exists.
 */
/** @noinspection ClassConstantCanBeUsedInspection */
if (\class_exists('\Composer\Autoload\ClassLoader', false)) {
    return 0;
}
/*
 * Find Composer auto loader after striping away any vendor path.
 */
$path = \str_replace('\\', '/', \dirname(__DIR__, 1));
$vendorPos = \strpos($path, 'vendor/');
if (false !== $vendorPos) {
    $path = \substr($path, 0, $vendorPos);
}
$path .= '/vendor/autoload.php';
/*
 * Turn off warning messages for the following include.
 */
$errorReporting = \error_reporting(E_ALL & ~E_WARNING);
/** @noinspection PhpIncludeInspection */
include_once $path;
\error_reporting($errorReporting);
unset($errorReporting, $path, $vendorPos);
/** @noinspection ClassConstantCanBeUsedInspection */
if (!\class_exists('\Composer\Autoload\ClassLoader', false)) {
    $mess = 'Could NOT find required Composer class auto loader. Aborting ...';
    if ('cli' === PHP_SAPI) {
        \fwrite(STDERR, $mess);
    } else {
        \fwrite(STDOUT, $mess);
    }
    unset($mess);
    exit(1);
}
