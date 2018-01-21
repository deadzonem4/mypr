<?php
namespace Zing\Core\SettingBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\SettingBundle\Entity\Setting as Entity;
use Zing\Core\SettingBundle\Plugin\SettingParser;

class Setting extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCoreSettingBundle:Setting';
    /** @var object $repository Setting */
    private $repository;

    /**
     * @param object $doctrine. Doctrine object
    */
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entity = $this->_entity();
        $this->repository = $this->_repository();
    }

    /** Build a new setting list
     * @param array $request. Array in a structure array('MyBundle' => array('setting' => 'setting value'))
     * @param bool $flush. If flush is set to true, then the built will not be merged, it will be overwritten from the requested built
     * @return bool. True
     */
    public function build($request, $flush = false)
    {
        $setting_parser = new SettingParser();
        $this->setSetting($setting_parser->parse($this->lastBuilt(), $request, $flush));
        return true;
    }

    /** Roll back a bundle to default bundle setting built
     * @param string $type. Type of the bundle: Core or Component
     * @param string $bundle_name. Bundle name - use to get the default built
     * @return bool. True.
     */
    public function rollBackBundleSetting($type, $bundle_name)
    {
        $setting_parser = new SettingParser();
        $setting = $setting_parser->findOneBy($type, $bundle_name);
        $this->build(array($bundle_name => $setting['file_data']), true);

        return true;
    }

    /** Roll back an already created built
     * @param int $id. Id of the build
     * @return bool. True on success
     */
    public function rollBackBuilt($id)
    {
        $setting = $this->getSetting($id);
        if(!$setting) {
            return false;
        }
        $this->setSetting($setting->getSetting());
        return true;
    }

    public function getComponentsFromLastBuilt() {
        $last_built = $this->lastBuilt();

        if($last_built == null) {
            return array();
        }

        $settings = $this->decode_setting($this->lastBuilt());
        $components = array();

        foreach($settings as $setting) {
            if(isset($setting['type'])) {
                if($setting['type'] == 'Component') {
                    $components[] = $setting;
                }
            }
        }

        return $components;
    }

    /** Get built for a specific bundle
     * @param string $name. Name of the bundle
     * @return array. Built for the requested bundle
     */
    public function bundle($name)
    {
        $setting_parser = new SettingParser();
        return $setting_parser->getBundleFromBuilt((string)$this->lastBuilt(), $name);
    }
    public function allBuildings()
    {
        /** If no buildings are found return null */
        if(!$this->countBuildings() > 0) {
            return null;
        }

        $settings = $this->repository->findBy(array(), array('modify' => 'desc'));
        if ($settings) {
            /** Return last build in json format */
            return $settings;
        }

        /** If requested build is not found return null */
        return null;
    }
    /** Get last built setting list
     * @return string. Last modified built in json format.
     */
    public function lastBuilt()
    {
        /** If no buildings are found return null */
        if(!$this->countBuildings() > 0) {
            return null;
        }

        $setting = $this->repository->findOneBy(array(), array('modify' => 'desc'))->getSetting();
        if ($setting) {
            /** Return last build in json format */
            return $setting;
        }

        /** If requested build is not found return null */
        return null;
    }

    /** Count total buildings
     * @return int. Count of total buildings
     */
    public function countBuildings() {
        return $this->_doctrineManager()
                    ->createQueryBuilder()
                    ->select('count(c.id)')
                    ->from($this->repository_name, 'c')
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    /** Get a setting.
     * @param int $setting_id . Id of the setting.
     * @return object. Doctrine result.
     */
    public function getSetting($setting_id)
    {
        return $this->repository->findOneBy(array('id' => $setting_id));
    }

    /** Set a new setting.
     * @param string $value . Set a new setting.
     * @return object. Current manager object.
     */
    public function setSetting($value)
    {
        $manager = $this->_doctrineManager();
        $manager->persist(
            $this->entity->setSetting($value)
                ->setModify(time())
        );
        $manager->flush();
        return $this;
    }

    /** Encode built with json
     * @param array $setting
     * @return string. Json array
     */
    public function encode_setting($setting = array()) {
        return json_encode($setting, JSON_UNESCAPED_UNICODE);
    }

    /** Decode built from json
     * @param string. Json formated array
     * @return array. Parsed json string to array
     */
    public function decode_setting($setting) {
        return json_decode($setting, true);
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object
     */
    public function updateObjectFromTable($object) {
        return $object;
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object
     */
    public function removeObjectFromTable($object) {
        return $object;
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $object_id;
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