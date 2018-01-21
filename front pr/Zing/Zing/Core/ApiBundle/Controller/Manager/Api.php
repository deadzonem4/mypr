<?php

namespace Zing\Core\ApiBundle\Controller\Manager;
use Zing\Core\CoreBundle\Controller\CoreManager;
use Zing\Core\CoreBundle\Plugin\CryptIT;

class Api extends CoreManager {

    /** Key for hashing in Api Manger */
    private $api_salt = 'aJHImoHSr949du9oE8eesBV9nMCOil6DvKfOKeySZHdMjW2QtSlRFH6lx7Bokjy';
    /** Key for CryptIT */
    private $api_crypt_salt = 'w45OQJ8ElzCZjxlTVWRl0Z3TV1nn6Z9vl2JEMNBtiSeD6DDmxAhmgwiEKuUBwUS';

    private $user_api_key = null;

    private $user_object = null;

    public function __construct($doctrine, $service_container) 
    {
        $this->doctrine = $doctrine;
        $this->container = $service_container;
        if(!$this->requestService('fos_user.user_manager')) {
            throw new \Exception('Api requires fos user manager service');
        }
    }

    public function createUserApiKeyFromUserObject($object) {
        /** Created user api key */
        $api_key = $this->_encryptApiKey($this->_prepareKey($object));

        $this->requestService('fos_user.user_manager')->updateUser(
            $object->setApiKey($api_key), true
        );
        return $api_key;
    }

    /** Create the user api key */
    public function createUserApiKey()
    {
        /** Created user api key */
        $api_key = $this->_encryptApiKey($this->_prepareKey());
        
        $this->requestService('fos_user.user_manager')->updateUser(
                $this->requestService('security.context')
                                ->getToken()
                                ->getUser()
                                ->setApiKey($api_key), true);
        return $api_key;
    }

    public function setUserRuntimeObject($user_object) {
        $this->user_object = $user_object;
        return $this;
    }

    public function getUserRuntimeObject() {
        return $this->user_object;
    }

    public function setUserRuntimeKey($key) {
        /** Set the user temp api key */
        $this->user_api_key = $key;
        return $this;
    }

    public function getUserRuntimeKey() {
        return $this->user_api_key;
    }

    /** Authenticate user by a given key
     * @param $key Requested key
     * @return mixed False if the key is not correct and if is correct return object - the found user from fos manager
     */
    public function authUserByApiKey($key) 
    {
       $decrypted_key = $this->_decryptApiKey($key);

       if(!$this->_match($decrypted_key, $key)) {
           return false;
       }

        $user_id = (int)$this->_decrypt($decrypted_key['id']);
        return $this->requestService('fos_user.user_manager')->findUserBy(array('id' => $user_id));
    }

    public function hasUserPermission($user, $roles) {
        if(!$user) {
            return false;
        }

        if(!count(array_intersect($roles, $user->getRoles())) > 0) {
           return false;
        }

        return true;
    }

    public function apiResponse($data = array()) {
        echo json_encode($data);exit;
    }

    private function _match($decrypted_key, $key)
    {

        /** Required fields for the key */
        if(!isset($decrypted_key['id'])) {
            return false;
        }
        if(!isset($decrypted_key['username'])) {
            return false;
        }
        if(!isset($decrypted_key['email'])) {
            return false;
        }
        if(!isset($decrypted_key['roles'])) {
            return false;
        }
        if(!isset($decrypted_key['salt'])) {
            return false;
        }
        if(!isset($decrypted_key['password'])) {
            return false;
        }

        /** Get user id from the requested key */
        $user_id = (int)$this->_decrypt($decrypted_key['id']);

        /** Try to find the user */
        $user = $this->requestService('fos_user.user_manager')->findUserBy(array('id' => $user_id));

        if($user == null || !$user) {
            return false;
        }

        /** Check if the given key is correct by the found user */
        if(
            $user->getApiKey() != $key                                                      ||
            $this->hashString($user->getUsername()) != $decrypted_key['username']           ||
            $this->hashString($user->getEmail()) != $decrypted_key['email']                 ||
            $this->hashString(json_encode($user->getRoles())) != $decrypted_key['roles']    ||
            $this->hashString($user->getSalt()) != $decrypted_key['salt']                   ||
            $this->hashString($user->getPassword()) != $decrypted_key['password']
        ) {
            return false;
        }

         return true;
    }

    /** Prepare the key with the user data */
    private function _prepareKey($object = false) {
        if($object) {
            $user = $object;
        } else {
            $user = $this->requestService('security.context')->getToken()->getUser();
        }
        return array(
            'id'        => $this->_encrypt($user->getId()),
            'username'  => $this->hashString($user->getUsername()),
            'email'     => $this->hashString($user->getEmail()),
            'roles'     => $this->hashString(json_encode($user->getRoles())),
            'salt'      => $this->hashString($user->getSalt()),
            'password'  => $this->hashString($user->getPassword())
        );
    }

    private function hashString($data) 
    {
        return hash_hmac('sha1', $data, $this->api_salt);
    }
    
    private function _decryptApiKey($data)
    {
       if(!strlen($data) > 0) {
           throw new \Exception('Api key is not an string');
       }
       return json_decode($this->_decrypt($data), true);
    }

    private function _encryptApiKey($data)
    {
        if(!is_array($data)) {
            throw new \Exception('Prepared api key is not an array');
        }
        return $this->_encrypt(json_encode($data));
    }

    private function _encrypt($data) {
        $crypt_it = new CryptIT();
        return $crypt_it->encrypt($data, $this->api_crypt_salt);
    }

    private function _decrypt($data) {
        $crypt_it = new CryptIT();
        return $crypt_it->decrypt($data, $this->api_crypt_salt);
    }

}