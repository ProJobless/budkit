<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * path.php
 *
 * Requires PHP version 5.3
 *
 * 
 * LICENSE: This source file is subject to version 3.01 of the GNU/GPL License 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.txt  If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 * send a note to support@stonyhillshq.com so we can mail you a copy immediately.
 *
 *
 * @category   Library
 * @author     Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * @copyright  1997-2012 Stonyhills HQ
 * @license    http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version    Release: 1.0.0
 * @link       http://stonyhillshq/documents/index/carbon4/libraries/path
 * @since      Class available since Release 1.0.0 Jan 28, 2012 4:45:51 PM
 * 
 */
namespace Library\Folder\Files\Xml;

use Library\Folder;
use Library\Folder\Files as Files;

/**
 * What is the purpose of this class, in one sentence?
 *
 * How does this class achieve the desired purpose?
 *
 * @category   Libraries
 * @author     Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * @copyright  1997-2012 Stonyhills HQ
 * @license    http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version    Release: 1.0.0
 * @link       http://stonyhillshq/documents/index/carbon4/libraries/path
 * @since      Class available since Release 1.0.0 Jan 28, 2012 4:45:51 PM
 */
class Path extends Document{
    /*
     * @var object 
     */

    static $instance;

    /**
     * Defines the class constructor
     * Used to preload pre-requisites for the path class
     * 
     * @return object path
     */
    public function __constructor() {
        
    }

    /**
     * Returns and instantiated Instance of the path class
     * 
     * NOTE: As of PHP5.3 it is vital that you include constructors in your class
     * especially if they are defined under a namespace. A method with the same
     * name as the class is no longer considered to be its constructor
     * 
     * @staticvar object $instance
     * @property-read object $instance To determine if class was previously instantiated
     * @property-write object $instance 
     * @return object path
     */
    public static function getInstance() {

        if (is_object(static::$instance) && is_a(static::$instance, 'Path'))
            return static::$instance;

        static::$instance = new self();

        return static::$instance;
    }

}

