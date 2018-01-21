<?php
namespace Zing\Component\SitemapBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Component\SitemapBundle\Entity\Sitemap as Entity;

/** Sitemap crud manager */
class Sitemap extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingComponentSitemapBundle:Sitemap';
    /** @var object $repository Setting */
    private $repository;

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

    /** Prepare the sitemap object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareSitemap($request, $object = null) {

        $prepare = $this->entity;
        if($object != null) {
            $prepare = $object;
        }

        return $prepare ->setSitemap($request['zing_sitemap'])
                        ->setStatus(0)
                        ->setDateModified(time());
    }

    /** Set a new sitemap
     * @param array $request The form request for sitemap
     * @return object Sitemap
     */
    public function setSitemap($request)
    {
        $manager = $this->_doctrineManager();
        $manager->persist($this->prepareSitemap($request)->setDateAdded(time()));
        $manager->flush();
        return $this;
    }

    /** Update a already created sitemap
     * @param array $request The form request
     * @param int $sitemap_id The id of the sitemap that we want to update
     * @return object Sitemap
     */
    public function updateSitemap($request, $sitemap_id)
    {
        $this->updateSitemapObject($this->prepareSitemap($request, $this->getGoogleMap($sitemap_id)));
        return $this;
    }

    /** Update an sitemap object directly
     * @param $object Custom modified object
     * @return object Sitemap
     */
    public function updateSitemapObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an sitemap object directly
     * @param $object Custom modified object
     * @return object Sitemap
     */
    public function setSitemapObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    public function removeSitemapObject($object) {
        /** If no sitemap is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an sitemap
     * @param int $sitemap_id The id of the sitemap that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested sitemap else null if is not found
     */
    public function getSitemap($sitemap_id, $array = false)
    {
        $sitemap_id = (int)$sitemap_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :sitemap_id')
                ->setParameter('sitemap_id', $sitemap_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
        }

        $sitemap = $this->repository->findOneBy(array('id' => $sitemap_id));
        if ($sitemap) {
            /** Return last build in json format */
            return $sitemap;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllSitemap()
    {
        $sitemap = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($sitemap) {
            /** Return last build in json format */
            return $sitemap;
        }

        return array();
    }

    public function getSitemapBy($by, $order = array('id' => 'desc'), $limit=null)
    {
        if($limit != null) {
            $sitemap = $this->repository->findBy($by, $order, $limit);
        } else {
            $sitemap = $this->repository->findBy($by, $order);
        }
        
        if ($sitemap) {
            return $sitemap;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object Sitemap
     */
    public function updateObjectFromTable($object) {
        return $this->updateSitemapObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object Sitemap
     */
    public function removeObjectFromTable($object) {
        return $this->removeSitemapObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getSitemap($object_id);
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