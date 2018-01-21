<?php
namespace Zing\Component\SimpleStoreBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SimpleStoreBundle\Entity\Manufacture as Entity;

/** SimpleStore manufacture crud manager */
class Manufacture extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity SimpleStore manufacture entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSimpleStoreBundle:Manufacture';
    /** @var object $repository SimpleStore manufacture repository */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_manufacture_display_name' => array(
            'label'       => 'Name',
            'validation'  => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
            'not_blank'   => true
        ),
        'zing_manufacture_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_manufacture_url'  => array(
            'label'       => 'Url',
            'validation'  => false,
            'not_blank'   => true
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
        $this->_map();
    }

    private function _map()
    {
        foreach($this->activeLanguages() as $lang) {
            $lang = $lang['language'];

            $this->mapper[$lang]['name'] = array(
                'label'       => 'Name '.strtoupper($lang),
                'validation'  => 'а-яА-Яa-zA-Z0-9_|`&\-\s',
                'not_blank'   => true
            );
            $this->mapper[$lang]['description'] = array(
                'label'             => 'Description '.strtoupper($lang),
                'validation'        => false,
                'not_blank'         => true
            );
        }
    }

    /** Prepare the SimpleStore manufacture object
     * @param object $manufacture_object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareManufacture($request, $manufacture_object = null) {

        /** Assign manufacture object */
        $manufacture = $this->entity;

        /** If we have choosen manufacture object */
        if($manufacture_object != null) {

            /** Assign the choosen manufacture object */
            $manufacture = $manufacture_object;
        }

        /** Loop in the active languages */
        foreach($this->activeLanguages() as $lang) {

            /** Get current language */
            $lang = strtolower($lang['language']);

            /** If we got request with this language */
            if(isset($request[$lang])) {

                /** Call manufacture content manager */
                $manufacture_content_manager = $this->requestService('zing.component.simplestore.manufacture_content');

                /** Try to select an manufacture content */
                $manufacture_content = $manufacture_content_manager->getManufactureBy(array(
                    'manufacture' => $manufacture->getId(),
                    'lang'        => $lang
                ));

                /** If no manufacture content is found assign a new manufacture content object */
                if($manufacture_content == null) {
                    $manufacture_content = $manufacture_content_manager->prepareManufactureContent()->setDateAdded(time());
                }

                /** Set to manufacture content object a lang */
                $manufacture_content->setLang($lang);

                /** Set to manufacture contetnt object a content */
                $manufacture_content->setContent(json_encode($request[$lang], JSON_UNESCAPED_UNICODE));

                /** Set to manufacture object the manufacture content object */
                $manufacture->setContent($manufacture_content->setManufacture($manufacture));
            }
        }

        /** Assign the non lang manufacture fields */
        $manufacture   ->setName($request['zing_manufacture_display_name'])
                       ->setUrl($request['zing_manufacture_url'])
                       ->setStatus($request['zing_manufacture_status'])
                       ->setDateModified(time());

        return $manufacture;
    }

    /** Set a new SimpleStore manufacture
     * @param array $request The form request for menu
     * @return object Menu
     */
    public function setManufacture($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareManufacture($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created SimpleStore manufacture
     * @param array $request The form request
     * @param int $manufacture_id The id of the menu that we want to update
     * @return object Menu
     */
    public function updateManufacture($request, $manufacture_id)
    {
        $this->updateManufactureObject($this->prepareManufacture($request, $this->getManufacture($manufacture_id)));
        return $this;
    }

    /** Update an SimpleStore manufacture object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function updateManufactureObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Insert an manufacture object directly
     * @param $object Custom modified object
     * @return object Menu
     */
    public function insertManufactureObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an SimpleStore manufacture
     * @param $manufacture_id The id of the menu that we want to remove
     * @return object Menu
     */
    public function removeManufacture($manufacture_id)
    {
        $manufacture = $this->getManufacture($manufacture_id);

        /** If no menu is found */
        if($manufacture == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($manufacture);
        $manager->flush();
        return $this;
    }

    public function removeManufactureObject($object)
    {
        /** If no SimpleStore manufacture is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an SimpleStore manufacture
     * @param int $manufacture_id The id of the menu that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested menu else null if is not found
     */
    public function getManufacture($manufacture_id, $array = false)
    {
        $manufacture_id = (int)$manufacture_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :manufacture_id')
                ->setParameter('manufacture_id', $manufacture_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $manufacture = $this->repository->findOneBy(array('id' => $manufacture_id));
        if ($manufacture) {
            /** Return last build in json format */
            return $manufacture;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllManufactures($by = array(), $order = array('id' => 'asc'))
    {
        $categories = $this->repository->findBy($by, $order);
        if ($categories) {
            /** Get found categories */
            return $categories;
        }
        return array();
    }

    public function getMenuBy($by)
    {
        $menu = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($menu) {
            return $menu;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object SimpleStore manufacture
     */
    public function updateObjectFromTable($object) {
        return $this->updateMenuObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object SimpleStore manufacture
     */
    public function removeObjectFromTable($object) {
        return $this->removeMenuObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getMenu($object_id);
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