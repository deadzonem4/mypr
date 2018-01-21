<?php
namespace Zing\Core\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="zing_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="gravatar", type="text")
     */
    protected $gravatar = '';

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=150)
     */
    protected $language = 'gb';

    /**
     * @var string
     *
     * @ORM\Column(name="theme", type="string", length=150)
     */
    protected $theme = 'Default';

    /**
     * @var string
     *
     * @ORM\Column(name="user_full_name", type="string", length=150)
     */
    protected $user_full_name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_country", type="string", length=150)
     */
    protected $user_country = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_state", type="string", length=150)
     */
    protected $user_state = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_city", type="string", length=150)
     */
    protected $user_city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_sub_city", type="string", length=150)
     */
    protected $user_sub_city = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_street", type="string", length=150)
     */
    protected $user_street = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_street_num", type="string", length=150)
     */
    protected $user_street_num = '';

    /**
     * @var string
     *
     * @ORM\Column(name="user_phone", type="string", length=150)
     */
    protected $user_phone = '';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer")
     */
    protected $status = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="api_key", type="text")
     */
    protected $api_key = 'key';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $user_city
     */
    public function setUserCity($user_city)
    {
        $this->user_city = $user_city;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserCity()
    {
        return $this->user_city;
    }

    /**
     * @param string $user_country
     */
    public function setUserCountry($user_country)
    {
        $this->user_country = $user_country;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserCountry()
    {
        return $this->user_country;
    }

    /**
     * @param string $user_full_name
     */
    public function setUserFullName($user_full_name)
    {
        $this->user_full_name = $user_full_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserFullName()
    {
        return $this->user_full_name;
    }

    /**
     * @param string $user_phone
     */
    public function setUserPhone($user_phone)
    {
        $this->user_phone = $user_phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserPhone()
    {
        return $this->user_phone;
    }

    /**
     * @param string $user_state
     */
    public function setUserState($user_state)
    {
        $this->user_state = $user_state;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserState()
    {
        return $this->user_state;
    }

    /**
     * @param string $user_street
     */
    public function setUserStreet($user_street)
    {
        $this->user_street = $user_street;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserStreet()
    {
        return $this->user_street;
    }

    /**
     * @param string $user_street_num
     */
    public function setUserStreetNum($user_street_num)
    {
        $this->user_street_num = $user_street_num;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserStreetNum()
    {
        return $this->user_street_num;
    }

    /**
     * @param string $user_sub_city
     */
    public function setUserSubCity($user_sub_city)
    {
        $this->user_sub_city = $user_sub_city;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserSubCity()
    {
        return $this->user_sub_city;
    }

    public function getApiKey() {
        return $this->api_key;
    }

    public function setApiKey($api_key) {
        $this->api_key = $api_key;
        return $this;
    }

    /**
     * @param mixed $gravatar
     */
    public function setGravatar($gravatar)
    {
        $this->gravatar = $gravatar;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGravatar()
    {
        return $this->gravatar;
    }

    /**
     * @param mixed $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

}