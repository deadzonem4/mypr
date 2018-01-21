<?php
namespace Zing\Component\GoogleMapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_google_maps")
 * @ORM\Entity
 */
class GoogleMaps implements ZingEntityInterface {

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
     * @var string
     *
     * @ORM\Column(name="width", type="string", length=150)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="string", length=150)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="map_type", type="string", length=150)
     */
    private $map_type;

    /**
     * @var string
     *
     * @ORM\Column(name="addresses", type="text")
     */
    private $addresses;

    /**
     * @var string
     *
     * @ORM\Column(name="default_zoom", type="integer")
     */
    private $default_zoom;

    /**
     * @var string
     *
     * @ORM\Column(name="max_zoom", type="integer")
     */
    private $max_zoom;

    /**
     * @var string
     *
     * @ORM\Column(name="min_zoom", type="integer")
     */
    private $min_zoom;

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
     * @param string $addresses
     */
    public function setAddresses($addresses)
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddresses()
    {
        return $this->addresses;
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
     * @param string $default_zoom
     */
    public function setDefaultZoom($default_zoom)
    {
        $this->default_zoom = $default_zoom;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultZoom()
    {
        return $this->default_zoom;
    }

    /**
     * @param string $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param string $map_type
     */
    public function setMapType($map_type)
    {
        $this->map_type = $map_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getMapType()
    {
        return $this->map_type;
    }

    /**
     * @param string $max_zoom
     */
    public function setMaxZoom($max_zoom)
    {
        $this->max_zoom = $max_zoom;
        return $this;
    }

    /**
     * @return string
     */
    public function getMaxZoom()
    {
        return $this->max_zoom;
    }

    /**
     * @param string $min_zoom
     */
    public function setMinZoom($min_zoom)
    {
        $this->min_zoom = $min_zoom;
        return $this;
    }

    /**
     * @return string
     */
    public function getMinZoom()
    {
        return $this->min_zoom;
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

    /**
     * @param string $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }



}