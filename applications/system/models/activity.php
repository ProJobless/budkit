<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * activity.php
 *
 * Requires PHP version 5.4
 *
 * LICENSE: This source file is subject to version 3.01 of the GNU/GPL License 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/licenses/gpl.txt  If you did not receive a copy of
 * the GPL License and are unable to obtain it through the web, please
 * send a note to support@stonyhillshq.com so we can mail you a copy immediately.
 * 
 */

namespace Application\System\Models;

use Platform;
use Library;

/**
 * Activity stream object model
 *
 * In its simplest form, an activity consists of an actor, a verb, an an object, 
 * and a target. It tells the story of a person performing an action on or with 
 * an object -- "Geraldine posted a photo to her album" or "John shared a video". 
 * In most cases these components will be explicit, but they may also be implied.
 *
 * @category  Application
 * @package   Data Model
 * @license   http://www.gnu.org/licenses/gpl.txt.  GNU GPL License 3.01
 * @version   1.0.0
 * @since     Jan 14, 2012 4:54:37 PM
 * @author    Livingstone Fultang <livingstone.fultang@stonyhillshq.com>
 * 
 */
class Activity extends Platform\Entity {
    
    /**
     * Static array of default system verbs
     * @var array 
     */
    static $_verbs = array(
        "post"
    );

    /**
     * The activity stream model constructor. 
     * @return void
     */
    public function __construct() {

        parent::__construct();

        //"label"=>"","datatype"=>"","charsize"=>"" , "default"=>"", "index"=>TRUE, "allowempty"=>FALSE
        $this->definePropertyModel( array(
            "activity_published" => array("Published", "datetime", 50),
            "activity_content" => array("Content", "varchar", 1000),
            "activity_summary" => array("Summary", "mediumtext", 50, NULL),
            "activity_comment_status" => array("Allow Comments", "tinyint", 1, 0), //*
            "activity_parent" => array("Parent", "smallint", 10, 0), //*
            "activity_generator" => array("Generator", "mediumtext", 100),
            "activity_provider" => array("Provider", "mediumtext", 100),
            "activity_mentions" => array("Mentions", "varchar", 1000), //*
            "activity_actor" => array("Actor", "varchar", 1000),
            "activity_verb" => array("Verb", "mediumtext", 20, "post"),
            "activity_geotags" => array("Geotags", "varchar", 1000), //*
            "activity_object" => array("Object", "varchar", 1000),
            "activity_target" => array("Target", "varchar", 1000),
            "activity_permissions" => array("Permissions", "mediumtext", 50), //* //allo:{},deny:{}
        ), "activity");

        $this->defineValueGroup("activity");
    }

    /**
     * Returns all the published activity stories
     * @return array An array of activity stream objects see {@link Activity\Collecion}
     */
    public function getAll() {
        
        //Get the object list
        $objects = $this->getActivityObjectsList()->fetchAll();
        $items   = array();
        //Parse the activities;
        foreach ($objects as $object) {

            //1. Collections
            //2.0 THE ACTOR
            $actorObject = new Activity\Object;
            $actorName   = implode(' ', array($object['user_first_name'], $object['user_last_name']) );
            $actorObject->set("objectType", "user"); //@TODO Not only User objects can be actors! You will need to be able to allow other apps to be actors
            $actorObject->set("displayName", $actorName ); 
            $actorObject->set("id", $object['activity_actor']);
            $actorObject->set("uri", $object['user_name_id']);
            
            $actorImage  = new Activity\MediaLink;
            $actorImageURL = !empty($object['user_photo'])?"/system/object/{$object['user_photo']}/resize/50/50":"http://placeskull.com/50/50/999999";
            $actorImage->set("url", $actorImageURL);
            $actorImage->set("height", 50);
            $actorImage->set("width", 50);
            $actorObject->set("image", $actorImage::getArray());

            $object['activity_actor'] =  $actorObject::getArray();
            //Remove user model sensitive Data
            foreach( array_keys( $this->load->model("user","member")->getPropertyModel() ) as $private ):
                unset($object[$private]);
            endforeach;
            
             //Activity Object;
            //First get the nature of the activity object;
            $subjectEntity    = Platform\Entity::getInstance(); //An empty entity here because it is impossible to guess the properties of this object
            $activityObject   = $subjectEntity->loadObjectByURI($object['activity_object'], array()); //Then we load the object    
            $activityObjectURI = $activityObject->getObjectURI();
            
            if(!empty($activityObjectURI) ):
                //Create an activity object, and fire an event asking callbacks to complete the activity object
                $activitySubject     = new Activity\Object;
                $activityObjectType  = $activityObject->getObjecType();         
                //Fire the event, passing the activitySubject by reference
                //Although it looks stupid to need to find out the nature of the activity subject before trigger
                //It actually provides an extra exclusion for callback so not all callbacks go to the database
                //so for instance if we found an activity subject was a collection, callbacks can first check if the 
                //trigger is to model a collection before diving ing
                \Library\Event::trigger("onActivitySubjectModel",  $activitySubject, $activityObjectType , $activityObjectURI ); 
                //You never know what callbacks will do to your subject so we just check
                //that the activity subject is what we think it is, i.e an activity object
                
                if(is_object($activitySubject)&&  method_exists($activitySubject, "getArray")){ 
                    $object['activity_object'] =  $activitySubject::getArray(); //If it is then we can set the activity object output vars
                }
            endif;
            //CleanUp
            foreach( $object as $key=>$value):
                    $object[str_replace(array('activity_','object_'), '', $key)] = $value;
                    unset($object[$key]);
            endforeach; 
           
            $items[]    = $object; //add to the collection
            
            //print_R($items);
            
        }
        
        $activities = new Activity\Collection;
        
        $activities->set("items", $items); //update the collection
        $activities->set("totalItems", count($items) );
            
        $collection = $activities::getArray();
        
        return $collection;
    }

    /**
     * Prepares and executes a database query for fetching activity objects
     * @param interger $objectId
     * @param string $objectURI
     * @return object Database resultset
     */
    public function getActivityObjectsList($objectId = NULL, $objectURI = NULL) {
        //Join Query
        $objectType = 'activity';
        $query = "SELECT o.object_id, o.object_uri, o.object_type,";
        //If we are querying for attributes
        $_properties = $this->getPropertyModel();
        $properties = array_keys((array) $_properties);
        
        $count = count($properties);
        if (!empty($properties) || $count < 1):
            //Loop through the attributes you need
            $i = 0;
            foreach ($properties as $alias => $attribute):
                $alias = (is_int($alias)) ? $attribute : $alias;
                $query .= "\nMAX(IF(p.property_name = '{$attribute}', v.value_data, null)) AS {$alias}";
                if ($i + 1 < $count):
                    $query .= ",";
                    $i++;
                endif;
            endforeach;

            //Join the UserObjects Properties
            $_actorProperties = $this->load->model("profile", "member")->getPropertyModel();
            $actorProperties = array_diff(array_keys($_actorProperties), array("user_password", "user_api_key", "user_email"));
            $count = count($actorProperties);
            if (!empty($actorProperties) || $count < 1):
                $query .= ","; //after the last activity property   
                $i = 0;
                foreach ($actorProperties as $alias => $attribute):
                    $alias = (is_int($alias)) ? $attribute : $alias;
                    $query .= "\nMAX(IF(l.property_name = '{$attribute}', u.value_data, null)) AS {$alias}";
                    if ($i + 1 < $count):
                        $query .= ",";
                        $i++;
                    endif;
                endforeach;
            endif;

            //The data Joins
            $query .= "\nFROM ?activity_property_values v"
            . "\nLEFT JOIN ?properties p ON p.property_id = v.property_id"
            . "\nLEFT JOIN ?objects o ON o.object_id=v.object_id"
            //Join the UserObjects Properties tables on userid=actorid
            . "\nLEFT JOIN ?objects q ON q.object_id=v.value_data AND p.property_name ='activity_actor'"
            . "\nLEFT JOIN ?user_property_values u ON u.object_id=q.object_id"
            . "\nLEFT JOIN ?properties l ON l.property_id = u.property_id"
            ;

        else:
            $query .="\nFROM ?objetcs";
        endif;

        $withConditions = false;

        if (!empty($objectId) || !empty($objectURI) || !empty($objectType)):
            $query .="\nWHERE";
            if (!empty($objectType)):
                $query .= "\to.object_type='{$objectType}'";
                $withConditions = TRUE;
            endif;
            if (!empty($objectURI)):
                $query .= ($withConditions) ? "\t AND" : "";
                $query .= "\to.object_uri='{$objectURI}'";
                $withConditions = TRUE;
            endif;
            if (!empty($objectId)):
                $query .= ($withConditions) ? "\t AND \t" : "";
                $query .= "\to.object_id='{$objectId}'";
                $withConditions = TRUE;
            endif;
        endif;

        $query .="\nGROUP BY o.object_id";
        $query .= $this->setListOrderBy(array("o.object_updated_on"), "DESC")->getListOrderByStatement();

        return $this->database->prepare($query)->execute();
    }

    /**
     * Adds a new activity object to the database
     * @return boolean Returns true on save, or false on failure
     */
    public function addActivity() {

        $inputModel = $this->getPropertyModel();
        //

        foreach ($inputModel as $property => $definition):
            $value = $this->input->getVar($property);
            if (!empty($value)):
                $this->setPropertyValue($property, $value);
            endif;
        endforeach;

        //@TODO determine the user has permission to post;
        $this->setPropertyValue("activity_actor", $this->user->get("user_id"));
        $this->setPropertyValue("activity_published", \Library\Date\Time::stamp());


        //Search for media link
        $targetObject = Activity\Object::getInstance();
        $mediaLink = Activity\MediaLink::getInstance();
        $activityObject = null;
        
        //Look for attachedObjects;
        $attachments = $this->input->getArray("attachment");
        
        if(is_array($attachments) && !empty($attachments)){
            if(sizeof($attachments) > 1 ){
                //Create a collection and link to the object iD
                $collection = $this->load->model("collection");
                $collection->setPropertyValue("collection_items", implode(',', $attachments ));
                $collection->setPropertyValue("collection_size", count($attachments) );
                $collection->setPropertyValue("collection_owner", $this->user->get("user_name_id") );
                //Should we add the activity body to the collection description? there is really no need to, 
                //As every item will need to be described in details later
                if(!$collection->saveObject(null, "collection")){
                    $this->setError( "Could not save attached objects" );
                    $activityObject = NULL;
                }
                //If however we could save, then get the last saved object ID;
                $activityObject = $collection->getLastSavedObjectURI();
                unset($collection); //destroys the collection object?       
            }else{
                $oneobject = reset($attachments); //Validate. String only
                $activityObject = !$this->validate->alphaNumeric($oneobject) ? null : $oneobject; //Maybe a much harder validation
            }
           $this->setPropertyValue("activity_object", $activityObject);
        }
       
        //Determine the target
        if (!$this->saveObject(null, "activity")) {
            //There is a problem! the error will be in $this->getError();
            return false;
        }
        return true;
    }

    /**
     * Get's an instance of the activity model
     * @staticvar object $instance
     * @return object \Application\System\Models\Activity 
     */
    public static function getInstance() {

        static $instance;
        //If the class was already instantiated, just return it
        if (isset($instance))
            return $instance;
        $instance = new self;
        return $instance;
    }

    /**
     * Default display method for every model 
     * @return void;
     */
    public function display() {
        var_dump($this->propertyData); //@TODO Temporary just for testing
    }

}

