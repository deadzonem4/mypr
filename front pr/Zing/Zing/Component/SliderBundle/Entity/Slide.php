<?php

namespace Zing\Component\SliderBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_slider_slide")
 * @ORM\Entity
 */
class Slide implements ZingEntityInterface
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
     * @ORM\ManyToOne(targetEntity="Zing\Component\SliderBundle\Entity\Slider", inversedBy="slide")
     */
    private $slider;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\SliderBundle\Entity\SlideContent", mappedBy="slide", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $content;

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

    /**
     * @var string
     *
     * @ORM\Column(name="slide_order", type="integer")
     */
    private $slide_order = 0;

    public function __construct()
    {
        $this->content = new ArrayCollection();
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
     * @param string $slide_order
     */
    public function setSlideOrder($slide_order)
    {
        $this->slide_order = $slide_order;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlideOrder()
    {
        return $this->slide_order;
    }

    /**
     * @param mixed $slider
     */
    public function setSlider($slider)
    {
        $this->slider = $slider;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlider()
    {
        return $this->slider;
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

    public function setContent($content)
    {
        $this->content[] = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getContentByType($type, $parsed = true) {
        foreach ($this->getContent() as $content) {
            if ($content->getLang() == $type) {
                if(!$parsed) {
                    return $content;
                }
                return $content->getExtractedContent();
            }
        }
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



}
