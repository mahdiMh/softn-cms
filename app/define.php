<?php

/**
 * Modulo: Constantes de la aplicación.
 */
/** Versión actual de la aplicación. */
define('VERSION', '0.4-alfa');

/** Nombre del indice para el identificador del usuario en $_SESSION */
define('SESSION_USER', 'usernameID');
define('SESSION_MESSAGES', 'sessionMessages');

/** Nombre del indice para el identificador del usuario en $_COOKIE */
define('COOKIE_USER_REMEMBER', 'userRememberMe');

/** Nombre del indice usado en "Router::getDATA()"  */
define('SITE_URL', 'siteUrl');

/** Nombre del indice usado en "Router::getDATA()"  */
define('SITE_TITLE', 'siteTitle');

/** Nombre de la variable que contiene los datos de la URL. */
define('URL_GET', 'url');

/** Espacio de nombre de la aplicación. */
define('APP_NAMESPACE', 'SoftnCMS\\');

/** Espacio de nombre de los controladores. */
define('NAMESPACE_CONTROLLERS', APP_NAMESPACE . 'controllers\\');

/** Ruta de los modulos de controladores. */
define('CONTROLLERS', ABSPATH . 'controllers' . DIRECTORY_SEPARATOR);

/** Ruta de los modulos de modelos. */
define('MODELS', ABSPATH . 'models' . DIRECTORY_SEPARATOR);

/** Ruta de los modulos de vista. */
define('VIEWS', ABSPATH . 'views' . DIRECTORY_SEPARATOR);

/** Ruta de los temas de la aplicación. */
define('THEMES', ABSPATH . 'themes' . DIRECTORY_SEPARATOR);

/** Directorio de los temas de la aplicación. */
define('APP_THEMES', 'app' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR);

define('REPLACE_SQL_SITE_URL', '#{SITE_URL}');
define('REPLACE_SQL_PREFIX', '#{PREFIX}');

define('OPTION_TITLE', 'optionTitle');
define('OPTION_DESCRIPTION', 'optionDescription');
define('OPTION_PAGED', 'optionPaged');
define('OPTION_SITE_URL', 'optionSiteUrl');
define('OPTION_THEME', 'optionTheme');
define('OPTION_EMAIL_ADMIN', 'optionEmailAdmin');
define('OPTION_MENU', 'optionMenu');
