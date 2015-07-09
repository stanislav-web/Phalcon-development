<?php
/**
 * Startup app definitions
 */
defined('DOCUMENT_ROOT') || define('DOCUMENT_ROOT', (isset($_SERVER)) ? $_SERVER["DOCUMENT_ROOT"] : getenv('DOCUMENT_ROOT'));
defined('APP_PATH') || define('APP_PATH', DOCUMENT_ROOT . '/../Application');
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));