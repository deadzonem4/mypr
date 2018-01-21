<?php

namespace Zing\Core\SettingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="zing_setting")
 * @ORM\Entity
 */
class Setting {


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="setting", type="text")
     */
    private $setting;

    /**
     * @var string
     *
     * @ORM\Column(name="modify", type="integer", length=50)
     */
    private $modify;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $setting
     */
    public function setSetting($setting)
    {
        $this->setting = $setting;
        return $this;
    }

    /**
     * @return string
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * @param string $setting
     */
    public function setModify($modify)
    {
        $this->modify = $modify;
        return $this;
    }

    /**
     * @return string
     */
    public function getModify()
    {
        return $this->modify;
    }
}

