<?php
namespace Zing\Component\GoogleMapsBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\GoogleMapsBundle\Entity\GoogleMaps as Entity;

/** GoogleMaps crud manager */
class GoogleMaps extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentGoogleMapsBundle:GoogleMaps';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_map_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_\s',
            'not_blank'   => true
        ),
        'zing_map_width' => array(
            'label'       => 'Width',
            'validation'  => '0-9',
            'not_blank'   => true
        ),
        'zing_map_height' => array(
            'label'       => 'Height',
            'validation'  => '0-9',
            'not_blank'   => true
        ),
        'zing_map_type' => array(
            'label'       => 'Map type',
            'validation'  => 'a-zA-Z0-9',
            'not_blank'   => true
        ),
        'zing_map_default_zoom' => array(
            'label'       => 'Default zoom',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_map_max_zoom' => array(
            'label'       => 'Max zoom',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_map_min_zoom' => array(
            'label'       => 'Min Zoom',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_map_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        )
    );

    /**
     * @param object $doctrine. Doctrine object
     * @param object $service_container. Service container
    */
    public function __construct($doctrine, $service_container)
    {
        $this->doctrine = $doctrine;
        $this->entity = $this->_entity();
        $this->repository = $this->_repository();
        $this->container = $service_container;
    }

    public function getAddressCords($address)
    {
        $url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
            return $response['results'][0]['geometry']['location'];
    }

    /** Prepare the map object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareGoogleMaps($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setName($request['zing_map_name'])
                       ->setWidth($request['zing_map_width'])
                       ->setHeight($request['zing_map_height'])
                       ->setMapType($request['zing_map_type'])
                       ->setDefaultZoom($request['zing_map_default_zoom'])
                       ->setMinZoom($request['zing_map_min_zoom'])
                       ->setMaxZoom($request['zing_map_max_zoom'])
                       ->setAddresses($request['zing_map_addresses'])
                       ->setStatus($request['zing_map_status'])
                       ->setDateModified(time());

    }

    /** Set a new map
     * @param array $request The form request for map
     * @return object GoogleMaps
     */
    public function setGoogleMaps($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareGoogleMaps($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created map
     * @param array $request The form request
     * @param int $map_id The id of the map that we want to update
     * @return object GoogleMaps
     */
    public function updateGoogleMaps($request, $map_id)
    {
        $this->updateGoogleMapsObject($this->prepareGoogleMaps($request, $this->getGoogleMap($map_id)));
        return $this;
    }

    /** Update an map object directly
     * @param $object Custom modified object
     * @return object GoogleMaps
     */
    public function updateGoogleMapsObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an map object directly
     * @param $object Custom modified object
     * @return object GoogleMaps
     */
    public function setGoogleMapsObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an map
     * @param $map_id The id of the map that we want to remove
     * @return object GoogleMaps
     */
    public function removeGoogleMap($map_id)
    {
        $map = $this->getGoogleMap($map_id);

        /** If no map is found */
        if($map == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($map);
        $manager->flush();
        return $this;
    }

    public function removeGoogleMapsObject($object) {
        /** If no map is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an map
     * @param int $map_id The id of the map that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested map else null if is not found
     */
    public function getGoogleMap($map_id, $array = false)
    {
        $map_id = (int)$map_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :map_id')
                ->setParameter('map_id', $map_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $maps = $this->repository->findOneBy(array('id' => $map_id));
        if ($maps) {
            /** Return last build in json format */
            return $maps;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllGoogleMaps()
    {
        $maps = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($maps) {
            /** Return last build in json format */
            return $maps;
        }

        return array();
    }

    public function getGoogleMapBy($by)
    {
        $map = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($map) {
            return $map;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object GoogleMaps
     */
    public function updateObjectFromTable($object) {
        return $this->updateGoogleMapsObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object GoogleMaps
     */
    public function removeObjectFromTable($object) {
       return $this->removeGoogleMapsObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getGoogleMaps($object_id);
    }

    /** Call current manager entity.
     * @return object. Doctrine entity.
     */
    private function _entity()
    {
        return new Entity();
    }

    /** Get repository of setting manager.
     * @return object. Doctrine entity repository.
     */
    private function _repository()
    {
        return $this->doctrine->getRepository($this->repository_name);
    }

    /** Get doctrine manager,
     * @return object. Doctrine entity manager
     */
    private function _doctrineManager()
    {
        return $this->doctrine->getManager();
    }

}