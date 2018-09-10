<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/opencart3/admin/');
define('HTTP_CATALOG', 'http://localhost/opencart3/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/opencart3/admin/');
define('HTTPS_CATALOG', 'http://localhost/opencart3/');

// DIR
define('DIR_APPLICATION', 'C:/wamp64/www/opencart3/admin/');
define('DIR_SYSTEM', 'C:/wamp64/www/opencart3/system/');
define('DIR_IMAGE', 'C:/wamp64/www/opencart3/image/');
define('DIR_STORAGE', 'C:/wamp64/www/opencart3/storage/');
define('DIR_CATALOG', 'C:/wamp64/www/opencart3/catalog/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'opencart3');
define('DB_PORT', '3306');
define('DB_PREFIX', '');

// OpenCart API
define('OPENCART_SERVER', 'https://www.opencart.com/');
//override setting ASM @4945
define('ABS_PATH', 'C:/wamp64/www/opencart3/');
define('DIR_APPLICATION_OVERRIDE', ABS_PATH.'storage/modification/admin/');
define('DIR_LANGUAGE_OVERRIDE', DIR_APPLICATION_OVERRIDE . 'language/');
define('DIR_TEMPLATE_OVERRIDE', DIR_APPLICATION_OVERRIDE . 'view/template/');
