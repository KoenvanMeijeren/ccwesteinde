<?php

use App\services\core\Config;

/********
 * SET LOCALE DATE
 ********/
setlocale(LC_TIME, 'NL_nl');
setlocale(LC_ALL, 'nl_NL');
date_default_timezone_set('Europe/Amsterdam');

/********
 * DATABASE
 ********/
Config::set('databaseName', '');
Config::set('databaseUsername', '');
Config::set('databasePassword', '');
Config::set('databaseServer', 'mysql:host=localhost');
Config::set('databasePort', '3306');
Config::set('databaseCharset', 'utf8mb4');
Config::set('databaseOptions', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

/********
 * GOOGLE RECAPTCHA KEYS
 ********/
Config::set('recaptcha_public_key', '');
Config::set('recaptcha_secret_key', '');

/********
 * TINY MCE KEY
 ********/
Config::set('tinyMceKey', '');


/********
 * ENCRYPTION TOKEN
 ********/
Config::set('encryptionToken', '');

/**
 * SECRET KEY
 */
Config::set('secretKey', '');
