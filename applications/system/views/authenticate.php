<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * authenticate.php
 *
 * Requires PHP version 5.4
 *
 * LICENSE: This source file is subject to version 3.01 of the GNU/GPL License 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.txt  If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 * send a note to support@stonyhillshq.com so we can mail you a copy immediately.
 */

namespace Application\System\Views;

/**
 * Authentication views
 *
 * @category  Application
 * @package   View
 * @license   http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version   1.0.0
 * @since     Jan 14, 2012 4:54:37 PM
 * @author    Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * 
 */
class Authenticate extends \Platform\View {

    /**
     * The default member index view
     * @return void 
     */
    final public function display() {
        //The default method
    }

    /**
     * Displays the member login page
     * @return void
     */
    public function userLoginForm() {

        $this->output->setPageTitle("Login to account");
        //Here is how to add alternative login options to the login form
        $alternatives = array(
//            array(
//                "link" => "/somelink/to/login",
//                "title" => "login title something",
//                "uid" => "unique id"
//            )
        );
        $fields = array(); //Additional fields
        
        //@TODO Should we Allow onBeforeDispatch to modify $this->task?
        \Library\Event::trigger('beforeLoginFormDisplay', $alternatives, $fields);

        $this->output->set("alternatives", $alternatives);
        $this->output->set("fields", $fields );

        //The default installation box;
        //$this->output->setFormat("raw");
        $this->output->setLayout("signin");

        //$this->output->addToPosition("body",   $body);
    }

    /**
     * Displays the new account form
     * @return void
     */
    public function newUserAccountForm() {
        //To set the pate title use
        $this->output->setPageTitle("Create a new Account");

        //parse Layout Demo;
        $sidebar = $this->output->layout("index_sidebar", "system");
        $body = $this->output->layout("default_form_create");


        //The default installation box;
        //$this->output->setFormat("raw");
        $this->output->setLayout("signup");
    }

    /*
     * Returns an instance of the Index View
     * @return object Index
     */

    public static function getInstance() {
        static $instance;

        //If the class was already instantiated, just return it
        if (isset($instance))
            return $instance;

        $instance = new self();

        return $instance;
    }

}

