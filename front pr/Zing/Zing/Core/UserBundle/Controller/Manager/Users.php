<?php
namespace Zing\Core\UserBundle\Controller\Manager;

use Zing\Core\CoreBundle\CoreInterface\ManagerInterface;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\UserBundle\Entity\User as Entity;

/** User crud manager */
class Users extends CoreManager implements ManagerInterface
{
    /** @var object $doctrine Doctrine object */
    private $doctrine;
    /** @var object $entity Setting entity */
    private $entity;
    /** @var string $repository_name Repository name */
    private $repository_name = 'ZingCoreUserBundle:User';
    /** @var object $repository Setting */
    private $repository;
    /** @var array $mapper Map form fields for validation */
    protected $mapper = array(
        'zing_user_name' => array(
            'label'       => 'Name',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_gravatar' => array(
            'label'       => 'Gravatar',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_email' => array(
            'label'       => 'Email',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_role' => array(
            'label'       => 'Role',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_language' => array(
            'label'       => 'Language',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_theme' => array(
            'label'       => 'Theme',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_status' => array(
            'label'       => 'Status',
            'validation'  => '0-9',
            'not_blank'   => false
        ),
        'zing_user_password' => array(
            'label'       => 'Password',
            'validation'  => false,
            'not_blank'   => true
        ),
        'zing_user_repassword' => array(
            'label'       => 'Repassword',
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
    }

    /** Prepare the user object
     * @param array $request The specific form request
     * @param object $object If you want to edit an already created object
     * @return object The updated object
     */
    public function prepareUser($request, $object = null) {

            if($object != null) {
                $user = $object;
            } else {
                $userManager = $this->requestService('fos_user.user_manager');
                $user = $userManager->createUser();
            }

            $user->setUsername($request['zing_user_name']);
            $user->setEmail($request['zing_user_email']);
            $user->setPlainPassword($request['zing_user_password']);
            $user->setEnabled(true);
            $user->setRoles(array($request['zing_user_role']));

            $user->setGravatar($request['zing_user_gravatar']);
            $user->setLanguage($request['zing_user_language']);
            $user->setTheme($request['zing_user_theme']);
            $user->setStatus($request['zing_user_status']);
            $user->setEnabled($request['zing_user_status']);
            //$userManager->updateUser($user, true);
        return $user;
    }

    public function userEdit($post_data)
    {
        $user_full_name         = $post_data['user_full_name'];
        $user_country           = $post_data['user_country'];
        $user_region            = $post_data['user_region'];
        $user_city              = $post_data['user_city'];
        $user_sub_city          = $post_data['user_sub_city'];
        $user_street            = $post_data['user_street'];
        $user_street_num        = $post_data['user_street_num'];
        $user_phone             = $post_data['user_phone'];

        if(!$this->getUser()) {return array('user_exists' => 'Requested user has not been found');}

        $errors = array();

        /** User name match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.]/ui', $user_full_name)) {
            $errors['user_full_name'] = $this->translate('validation_incorrect_field', array($this->translate('name')));
        }

        /** User country match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.]/ui', $user_country)) {
            $errors['user_country'] = $this->translate('validation_incorrect_field', array($this->translate('country')));
        }

        /** User region match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.]/ui', $user_region)) {
            $errors['user_region'] = $this->translate('validation_incorrect_field', array($this->translate('region')));
        }

        /** User city match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.\"\']/ui', $user_city)) {
            $errors['user_city'] = $this->translate('validation_incorrect_field', array($this->translate('city')));
        }

        /** User sub city match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.\"\']/ui', $user_sub_city)) {
            $errors['user_sub_city'] = $this->translate('validation_incorrect_field', array($this->translate('sub_city')));
        }

        /** User street match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.\"\']/ui', $user_street)) {
            $errors['user_street'] = $this->translate('validation_incorrect_field', array($this->translate('street')));
        }

        /** User street num match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.\"\']/ui', $user_street_num)) {
            $errors['user_street_num'] = $this->translate('validation_incorrect_field', array($this->translate('street_num')));
        }

        /** User street num match */
        if(preg_match('/[^а-яА-Яa-zA-Z0-9-_\s.+]/ui', $user_phone)) {
            $errors['user_phone'] = $this->translate('validation_incorrect_field', array($this->translate('phone')));
        }

        if(count($errors) > 0) {
            return $errors;
        }

        $user = $this->getUser();
        $user->setUserFullName(strip_tags($user_full_name));
        $user->setUserCountry(strip_tags($user_country));
        $user->setUserState(strip_tags($user_region));
        $user->setUserCity(strip_tags($user_city));
        $user->setUserSubCity(strip_tags($user_sub_city));
        $user->setUserStreet(strip_tags($user_street));
        $user->setUserStreetNum(strip_tags($user_street_num));
        $user->setUserPhone(strip_tags($user_phone));
        $userManager = $this->requestService('fos_user.user_manager');
        $userManager->updateUser($user);

        return array();
    }

    public function userChangePassword($post_data)
    {
        $old_password           = $post_data['old_password'];
        $new_password           = $post_data['new_password'];
        $new_password_again     = $post_data['new_password_again'];

        if(!$this->getUser()) {return array('user_exists' => 'Requested user has not been found');}

        $errors = array();

        if($new_password != $new_password_again) {
            $errors['new_password'] = $this->translate('password_match', array($this->translate('Password')));
            $errors['new_password_again'] = $this->translate('password_match', array($this->translate('Repeat Password')));
        }

        if(empty($new_password)) {
            $errors['new_password'] = $this->translate('validation_incorrect_field', array($this->translate('Password')));
        }

        if(empty($new_password_again)) {
            $errors['new_password_again'] = $this->translate('validation_incorrect_field', array($this->translate('Repeat password')));
        }

        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($this->getUser());
        $encoded_pass = $encoder->encodePassword($old_password, $this->getUser()->getSalt());

        if($encoded_pass != $this->getUser()->getPassword()) {
            $errors['old_password'] = $this->translate('password_match', array($this->translate('Password')));
        }

        if(count($errors) > 0) {
            return $errors;
        }

        $user = $this->getUser();
        $user->setPlainPassword($new_password);
        $userManager = $this->requestService('fos_user.user_manager');
        $userManager->updateUser($user);

        return array();
    }

    public function register($post_data)
    {

        $user_name          = $post_data['user_name'];
        $user_email         = $post_data['user_email'];
        $user_password      = $post_data['user_password'];
        $user_repassword    = $post_data['user_repassword'];
        $user_agree         = 0;
        if(isset($post_data['user_agree'])) {
            $user_agree     = $post_data['user_agree'];
        }

        if(!isset($_POST['user_name'])) {
            $errors['user_name'] = $this->translate('validation_empty_field', array($this->translate('User name')));
        }

        if(!isset($_POST['user_email'])) {
            $errors['user_email'] = $this->translate('validation_empty_field', array($this->translate('User email')));
        }

        if(!isset($_POST['user_password'])) {
            $errors['user_password'] = $this->translate('validation_empty_field', array($this->translate('User password')));
        }

        if(!isset($_POST['user_repassword'])) {
            $errors['user_repassword'] = $this->translate('validation_empty_field', array($this->translate('User repassword')));
        }

        $errors = array();

        if(!strlen($user_name) > 4) {
            $errors['user_name'] = $this->translate('validation_incorrect_field', array($this->translate('User name')));
        }

        /** User name match */
        if(preg_match('/[^a-zA-Z0-9-_]/ui', $user_name)) {
            $errors['user_name'] = $this->translate('validation_incorrect_field', array($this->translate('User name')));
        }

        /** User email match */
        if(!preg_match('/^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$/', $user_email)) {
            $errors['user_email'] = $this->translate('validation_incorrect_field', array($this->translate('User email')));
        }

        if(empty($user_password)) {
            $errors['user_password'] = $this->translate('validation_empty_field', array($this->translate('User password')));
        }
        if($user_password != $user_repassword) {
            if(empty($user_password)) {
                $errors['user_password'] = $this->translate('validation_password_compare', array($this->translate('User password compare')));
            }
        }

        if($user_agree != 1) {
            $errors['user_agree'] = $this->translate('validation_user_agree', array($this->translate('User agree')));
        }

        if(!count($errors) > 0) {

            if($this->getFosUserBy(array('username' => $user_name)) != null) {
                return array('username' => $this->translate('validation_username_exists', array($this->translate('Current username is already registered'))));
            }

            if($this->getFosUserBy(array('email' => $user_email)) != null) {
                return array('email' => $this->translate('validation_email_exists', array($this->translate('Current email is already registered'))));
            }

            $this->setUser(
                array(
                    'zing_user_name'        => $user_name,
                    'zing_user_email'       => $user_email,
                    'zing_user_password'    => $user_password,
                    'zing_user_role'        => 'ROLE_USER',
                    'zing_user_gravatar'    => '',
                    'zing_user_language'    => $this->defaultLanguage()['language'],
                    'zing_user_theme'       => 'default',
                    'zing_user_status'      => 1
                )
            );

            $this->zing_mail(
                $user_email,
                'Успешна регистрация в '.$this->currentHttpHost(),
                array(
                    'user'      => $user_name,
                    'domein'    => $this->currentProtocol().'://'.$this->currentHttpHost()
                ),
                'ZingCoreUserBundle:Default/mail:register_mail.html.twig'
            );

        }
        return $errors;
    }

    public function setLayout($user, $layout) {
        $this->updateUserObject($user->setLayout($layout));
        return true;
    }

    public function setUserLayout($user, $user_layout) {
        $this->updateUserObject($user->setUserLayout($user_layout));
        return true;
    }

    /** Set a new user
     * @param array $request The form request for user
     * @return object User
     */
    public function setUser($request)
    {
        $userManager = $this->requestService('fos_user.user_manager');
        $userManager->updateUser($this->prepareUser($request), true);
        return $this;
    }

    /** Update a already created user
     * @param array $request The form request
     * @param int $user_id The id of the user that we want to update
     * @return object User
     */
    public function updateUser($request, $user_id)
    {
        $userManager = $this->requestService('fos_user.user_manager');
        $userManager->updateUser($this->prepareUser($request, $this->getFosUser($user_id)), true);
        return $this;
    }

    /** Update an user object directly
     * @param $object Custom modified object
     * @return object User
     */
    public function updateUserObject($object) {
        $manager = $this->_doctrineManager();
        $manager->merge($object);
        $manager->flush();
        return $this;
    }

    /** Update an user object directly
     * @param $object Custom modified object
     * @return object User
     */
    public function setUserObject($object) {
        $manager = $this->_doctrineManager();
        $manager->persist($object);
        $manager->flush();
        return $this;
    }

    /** Remove an user
     * @param $user_id The id of the user that we want to remove
     * @return object User
     */
    public function removeUser($user_id)
    {
        $user = $this->getFosUser($user_id);

        /** If no user is found */
        if($user == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($user);
        $manager->flush();
        return $this;
    }

    public function removeUserObject($object) {
        /** If no user is found */
        if($object == null) {
            return false;
        }

        $manager = $this->_doctrineManager();
        $manager->remove($object);
        $manager->flush();
        return $this;
    }

    /** Get an user
     * @param int $user_id The id of the user that we want to get
     * @param bool $array, If we want the returned result to be an array set True else set false(by default) for returing object
     * @return mixed The requested user else null if is not found
     */
    public function getFosUser($user_id, $array = false)
    {
        $user_id = (int)$user_id;

        /** If we want the returned result to be an array */
        if($array) {

            $result = $this->_doctrineManager()
                ->createQueryBuilder()
                ->select('c')
                ->from($this->repository_name, 'c')
                ->where('c.id = :user_id')
                ->setParameter('user_id', $user_id)
                ->getQuery();
            $result->setMaxResults(1);

            $result = $result->getArrayResult();

            if(isset($result[0])) {
                return $result[0];
            }

            return null;
         }

        $users = $this->repository->findOneBy(array('id' => $user_id));
        if ($users) {
            /** Return last build in json format */
            return $users;
        }
        return null;
    }

    /** Get all saved layouts
     * @return array The found layouts else an empty array
     */
    public function getAllUsers()
    {
        $users = $this->repository->findBy(array(), array('id' => 'asc'));
        if ($users) {
            /** Return last build in json format */
            return $users;
        }

        return array();
    }

    public function getFosUserBy($by)
    {
        $user = $this->repository->findOneBy($by, array('id' => 'desc'));
        if ($user) {
            return $user;
        }

        return null;
    }

    /** Update an object, used for table action
     * @param object $object The object to update
     * @return object User
     */
    public function updateObjectFromTable($object) {
        return $this->updateUserObject($object);
    }

    /** Remove an object, used for table action
     * @param object $object The object to remove
     * @return object User
     */
    public function removeObjectFromTable($object) {
       return $this->removeUserObject($object);
    }

    /** Update and object, used for table action
     * @param int $object_id The object to get
     * @return object The found object if not returns null
     */
    public function getObjectFromTable($object_id) {
        return $this->getFosUser($object_id);
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