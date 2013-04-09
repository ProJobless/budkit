<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * xhtml.php
 *
 * Requires PHP version 5.3
 *
 * LICENSE: This source file is subject to version 3.01 of the GNU/GPL License
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.txt  If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 * send a note to support@stonyhillshq.com so we can mail you a copy immediately.
 *
 * @category   Library
 * @author     Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * @copyright  1997-2012 Stonyhills HQ
 * @license    http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version    Release: 1.0.0
 * @link       http://stonyhillshq/documents/index/carbon4/libraries/output/format/xhtml
 * @since      Class available since Release 1.0.0 Jan 14, 2012 4:54:37 PM
 *
 */

namespace Library\Output\Format;

//use Library;
//use Library\Output;

/**
 * What is the purpose of this class, in one sentence?
 *
 * How does this class achieve the desired purpose?
 *
 * @category   Library
 * @author     Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * @copyright  1997-2012 Stonyhills HQ
 * @license    http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version    Release: 1.0.0
 * @link       http://stonyhillshq/documents/index/carbon4/libraries/output/format/xhtml
 * @since      Class available since Release 1.0.0 Jan 14, 2012 4:54:37 PM
 */
class xHtml extends \Library\Output\Document {

    /**
     * Renders the output
     *
     * @param type $template
     * @param type $httpCode
     * @return xHtml
     */
    final public function render($template = "index", $httpCode = null, $headers = array()) {

        @header("HTTP/1.1 {$httpCode}");
        if (is_array($headers)) {
            foreach ($headers as $name => $value) {
                $this->unsetHeader($name);
                $this->setHeader($name, $value);
            }
        };
        $this->setHeaders("Content-type", "text/html");

        $template = empty($template) ? $this->output->layout : $template;

        //3.Determine which format of the index we are using
        $layout = FSPATH . 'public' . DS . $this->output->template . DS . $template . $this->output->layoutExt;



        //4. Include the main index file
        include_once( $layout );

        //echo $layout; die; 
        //parse the set layout as the final output;
        //5. Close and Flush buffer
        $output = $this->restartBuffer();

        //echo $output
        $string = $this->parse($output, $this);

        //$string = $document;

        $doc = new \DOMDocument();
        $doc->loadHTML($string); //Load XML here, if you use loadHTML the string will be wrapped in HTML tags. Not good.
        foreach ($doc->getElementsByTagName("html") as $node):
            $doc->saveHTML($node);
        endforeach;

        //$document = $string;
        //print_R(\Platform\Debugger::$log);
        //Print to client
        print( "<!DOCTYPE html>\n" . trim($string));
        //print_R($document);

        ob_flush();
        ob_end_flush();

        return $this;
    }

    /**
     * Gets an instance of the registry element
     *
     * @staticvar self $instance
     * @param type $name
     * @return self
     */
    final public static function getInstance() {

        static $instance;
        //If the class was already instantiated, just return it
        if (isset($instance))
            return $instance;

        $instance = new xHtml();

        return $instance;
    }

}