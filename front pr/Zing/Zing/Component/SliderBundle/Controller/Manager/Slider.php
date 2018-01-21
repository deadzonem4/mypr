<?php
namespace Zing\Component\SliderBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SliderBundle\Entity\Slider as Entity;

/** Slider crud manager */
class Slider extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSliderBundle:Slider';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_slider_name' => array(
            'label'       => 'Name',
            'validation'  => 'a-zA-Z0-9_\s',
            'not_blank'   => true
        ),
        'zing_slider_width' => array(
            'label'       => 'Width',
            'validation'  => '0-9',
            'not_blank'   => true
        ),
        'zing_slider_height' => array(
            'label'       => 'Height',
            'validation'  => '0-9',
            'not_blank'   => true
        ),
        'zing_slider_status' => array(
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

    /** Prepare the slider object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareSlider($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare->setName($request['zing_slider_name'])
                       ->setSizeW($request['zing_slider_width'])
                       ->setSizeH($request['zing_slider_height'])
                       ->setStatus($request['zing_slider_status'])
                       ->setDateModified(time());

    }

    public function setLayout($slider, $layout) {
        $this->updateSliderObject($slider->setLayout($layout));
        return true;
    }

    public function setSliderLayout($slider, $slider_layout) {
        $this->updateSliderObject($slider->setSliderLayout($slider_layout));
        return true;
    }

    /** Set a new slider
     * @param array $request The form request for slider
     * @return object Slider
     */
    public function setSlider($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareSlider($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created slider
     * @param array $request The form request
     * @param int $slider_id The id of the slider that we want to update
     * @return object Slider
     */
    public function updateSlider($request, $slider_id)
    {
        $this->updateSliderObject($this->prepareSlider($request, $this->getSlider($slider_id)));
        return $this;
    }

    /** Update an slider object directly
     * @param $object Custom modified object
     * @return object Slider
     */
    public function updateSliderObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an slider object directly
     * @param $object Custom modified object
     * @return object Slider
     */
    public function setSliderObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an slider
     * @param $slider_id The id of the slider that we want to remove
     * @return object Slider
     */
    public function removeSlider($slider_id)
    {
        $slider = $this->getSlider($slider_id);

        /** If no slider is found */
        if($slider == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($slider);
        $manager->flush();
        return $this;
    }

    public function removeSliderObject($object) {
        /** If no slider is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an slider
     * @param int $slider_id The id of the slider that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested slider else null if is not found
     */
    public function getSlider($slider_id, $array = false)
    {
        $slider_id = (int)$slider_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :slider_id')
                ->setParameter('slider_id', $slider_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $sliders = $this->repository->findOneBy(array('id' => $slider_id));
        if ($sliders) {
            /** Return last build in json format */
            return $sliders;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllSliders()
    {
        $sliders = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($sliders) {
            /** Return last build in json format */
            return $sliders;
        }

        return array();
    }

    public function getSliderBy($by)
    {
        $slider = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($slider) {
            return $slider;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Slider
     */
    public function updateObjectFromTable($object) {
        return $this->updateSliderObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Slider
     */
    public function removeObjectFromTable($object) {
       return $this->removeSliderObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getSlider($object_id);
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