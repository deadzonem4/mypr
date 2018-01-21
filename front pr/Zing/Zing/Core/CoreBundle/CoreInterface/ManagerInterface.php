<?php
namespace Zing\Core\CoreBundle\CoreInterface;

interface ManagerInterface {

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object
     */
    public function updateObjectFromTable($object);

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object
     */
    public function removeObjectFromTable($object);

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id);

}