<?php
/**
 * Ever Framework
 * 
 * General application settings
 */

/** 
 * Sets whether errors are displayed.
 * 1 = Enable errors
 * 0 = Disable errors
 */
define('DISPLAY_ERROR', 1);

/** 
 * Directory application root.
 *
 * This constant will get the name of the root directory, it is used to
 * Identify whether the application is running in a local environment,
 * May also be usuado for paths beginning with the application root.
 */
define('BASE_DIR', basename(dirname(APP_PATH)));

// Folder name of controllers
define('CONTROLLER_FOLDER', 'controllers');

// Controller name for error handling
define('ERROR_CONTROLLER', 'Error');

// Directory separator
define('DS', DIRECTORY_SEPARATOR);