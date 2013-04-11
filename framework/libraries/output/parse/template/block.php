<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * block.php
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
 * @link       http://stonyhillshq/documents/index/carbon4/libraries/layout
 * @since      Class available since Release 1.0.0 Feb 5, 2012 10:15:29 PM
 *
 */

namespace Library\Output\Parse\Template;

use Library;
use Library\Output;
use Library\Output\Parse;

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
 * @link       http://stonyhillshq/documents/index/carbon4/libraries/layout
 * @since      Class available since Release 1.0.0 Feb 5, 2012 10:15:29 PM
 */
class Block extends Parse\Template {
    /*
     * @var object
     */

    static $instance;

    /**
     * Defines the class constructor
     * Used to preload pre-requisites for the layout class
     *
     * @return object layout
     */
    public function __constructor() {
        
    }

    /**
     * Execute the layout
     * 
     * @param type $parser
     * @param type $tag
     * @return type
     */
    public static function execute($parser, $tag, $writer) {

        if (!isset($tag['DATA']))
            return null;

        $default = isset($tag['_DEFAULT']) ? $tag['_DEFAULT'] : null;
        $data = self::getData($tag['DATA'], $default); //echo $data;
        
        //if is array loop through each;
        if (!empty($data)) {
         
            //Are there any menus in this block add with Output::addMenuGroupToPosition?
            if (isset($data['menus'])&&is_array($data['menus']) && is_array($data['menus'])) {
                foreach ($data['menus'] as $blockMenu) {
                   
                    if (is_array($blockMenu) && isset($blockMenu["ID"])):
                        $menu = Menu::execute($parser, $blockMenu, $writer);
                    
                        \Library\Folder\Files\Xml\Parser::writeXML( $writer, $menu ); //Not nice but might be my only choice?
                        //$writer->writeRaw($menu); //Let's write the dynamic menu;
                        unset($data['menus']);
                    endif;
                }
            }

            //print_R($data);
            foreach ($data["data"] as $key => $block) {
                if (!is_array($block) || !isset($block['content'])) {
                    continue;
                }

                //process the callback
                $callback = isset($block['callback']) ? $block['callback'] : null;
                $string = isset($block['content']) ? $block['content'] : null;

                //Parse the block content!
                //Slows things down! Maybe check if block is parsable
                //$string = static::$document->parse( $string , static::$document); 
                //print_R($string);
                //@TODO Execute the callback after writing
                $writer->writeRaw($string);
            }
            return true; // Successfull
        }

        //Using default and return data
        if (isset($tag['RETURN']) && (bool) $tag['RETURN']) {
            if (isset($tag['CDATA']) && !empty($tag['CDATA'])):
                $writer->writeRaw($tag['CDATA']);
                return true;
            endif;

            if (isset($tag['CHILDREN']) && !empty($tag['CHILDREN'])):
                return $tag['CHILDREN'];
            endif;
        }
        return false;
    }

    /**
     * Returns and instantiated Instance of the layout class
     *
     * NOTE: As of PHP5.3 it is vital that you include constructors in your class
     * especially if they are defined under a namespace. A method with the same
     * name as the class is no longer considered to be its constructor
     *
     * @staticvar object $instance
     * @property-read object $instance To determine if class was previously instantiated
     * @property-write object $instance
     * @return object layout
     */
    public static function getInstance() {

        if (is_object(static::$instance) && is_a(static::$instance, 'Block'))
            return static::$instance;

        static::$instance = new self();

        return static::$instance;
    }

}

