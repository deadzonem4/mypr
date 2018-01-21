<?php

namespace Zing\Component\SliderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_slider")
 * @ORM\Entity
 */
class Slider implements ZingEntityInterface
{
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
     * @ORM\Column(name="name", type="string", length=150)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\SliderBundle\Entity\Slide", mappedBy="slider", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $slide;

    /**
     * @var string
     *
     * @ORM\Column(name="size_w", type="integer")
     */
    private $size_w;

    /**
     * @var string
     *
     * @ORM\Column(name="size_h", type="integer")
     */
    private $size_h;


    /**
     * @var string
     *
     * @ORM\Column(name="date_added", type="integer")
     */
    private $date_added;

    /**
     * @var string
     *
     * @ORM\Column(name="date_modified", type="integer")
     */
    private $date_modified;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = 0;

    public function __construct()
    {
        $this->slide = new ArrayCollection();
    }


    /**
     * @param string $date_added
     */
    public function setDateAdded($date_added)
    {
        $this->date_added = $date_added;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * @param string $date_modified
     */
    public function setDateModified($date_modified)
    {
        $this->date_modified = $date_modified;
        return $this;
    }

    /**
     * @return string
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $size_h
     */
    public function setSizeH($size_h)
    {
        $this->size_h = $size_h;
        return $this;
    }

    /**
     * @return string
     */
    public function getSizeH()
    {
        return $this->size_h;
    }

    /**
     * @param string $size_w
     */
    public function setSizeW($size_w)
    {
        $this->size_w = $size_w;
        return $this;
    }

    /**
     * @return string
     */
    public function getSizeW()
    {
        return $this->size_w;
    }

    /**
     * @param mixed $slide
     */
    public function setSlide($slide)
    {
        $this->slide[] = $slide;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlide()
    {
        return $this->slide;
    }


    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

}
