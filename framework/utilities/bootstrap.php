<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * bootstrap.php
 *
 * Requires PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the GNU/GPL License 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.txt  If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 * send a note to support@stonyhillshq.com so we can mail you a copy immediately.
 *
 * @category   Utility
 * @author     Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * @copyright  1997-2012 Stonyhills HQ
 * @license    http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version    Release: 1.0.0
 * @link       http://stonyhillshq/documents/index/carbon4/utilities/boostrap
 * @since      Class available since Release 1.0.0 Jan 14, 2012 4:54:37 PM
 * 
 */
namespace Platform;

use Library;
use Platform;

/*
 * ------------------------------------------------------
 *  AutoLoad
 * ------------------------------------------------------
 */
require( FSPATH . 'framework' . DS .'utilities'.DS. 'loader' . EXT);
require( FSPATH . 'framework' . DS .'utilities'.DS. 'functions' . EXT);

spl_autoload_register(new Platform\Loader("Platform", array( FSPATH . 'framework'.DS.'utilities', FSPATH . 'vendors'.DS.'utilities' ) ));
spl_autoload_register(new Platform\Loader("Library", array( FSPATH . 'framework' . DS . 'libraries', FSPATH . 'vendors' . DS . 'libraries') ) );
spl_autoload_register(new Platform\Loader("Application", array( FSPATH . 'applications', FSPATH .'vendors'.DS. 'applications')));
/**
 * -----------------------------------------------------
 *  Set the default timezone
 * -----------------------------------------------------
 */
Library\Date::setDefaultTimeZone("UTC");

/*
 * ------------------------------------------------------
 *  Start the Debugging and Logging
 * ------------------------------------------------------
 */
Debugger::start();



/*
 * ------------------------------------------------------
 *  Set Exception 
 * ------------------------------------------------------
 */
set_error_handler(array("\Platform\Error", "handler"));
set_exception_handler(array("\Platform\Error", "exception"));


/*
 * ------------------------------------------------------
 *  Register Shutdown
 * ------------------------------------------------------
 */
register_shutdown_function(array("\Platform\Error", "shutdown"));

/*
 * ------------------------------------------------------
 *  Load all system hooks
 * ------------------------------------------------------
 */
\Library\Event::loadHooks();

/*
 * ------------------------------------------------------
 *  Start Session?
 * ------------------------------------------------------
 */
Library\Output::startBuffer(); //important order!! Must be called before session start
Library\Event::trigger('onStart');
Library\Session::start();


/*
 * ------------------------------------------------------
 *  Base Classes and Controllers
 * ------------------------------------------------------
 */
$Router = Library\Router::getInstance();
$Uri    = Library\Uri::getInstance();
$Output = Library\Output::getInstance();

/*
 * ------------------------------------------------------
 *  Output
 * ------------------------------------------------------
 */
$Output->recallAlerts();

/*
 * ------------------------------------------------------
 *  Execute & Redirect
 * ------------------------------------------------------
 */
$Dispatcher = Platform\Dispatcher::getInstance();

$Dispatcher->execute($Router->findRoute($Uri->getQuery(), $Uri->getQueryVariables()));
$Dispatcher->redirect();

/*
 * ------------------------------------------------------
 *  Stop Debugging and Logging then shutdown
 * ------------------------------------------------------
 */
Library\Event::trigger('onShutdown');
Debugger::stop();

//phpinfo();
