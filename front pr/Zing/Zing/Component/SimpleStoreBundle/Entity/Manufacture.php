<?php

namespace Zing\Component\SimpleStoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Category
 *
 * @ORM\Table(name="zing_simplestore_manufacture")
 * @ORM\Entity
 */
class Manufacture implements ZingEntityInterface
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=150)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_order", type="integer")
     */
    private $category_order = 0;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\SimpleStoreBundle\Entity\ManufactureContent", mappedBy="manufacture", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $content;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\SimpleStoreBundle\Entity\Product", mappedBy="manufacture")
     */
    private $product;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_added", type="integer")
     */
    private $date_added;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_modified", type="integer")
     */
    private $date_modified;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = 0;


    public function __construct()
    {
        $this->content = new ArrayCollection();
    }

    /**
     * @param int $category_order
     */
    public function setCategoryOrder($category_order)
    {
        $this->category_order = $category_order;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryOrder()
    {
        return $this->category_order;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content[] = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int $date_added
     */
    public function setDateAdded($date_added)
    {
        $this->date_added = $date_added;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * @param int $date_modified
     */
    public function setDateModified($date_modified)
    {
        $this->date_modified = $date_modified;
        return $this;
    }

    /**
     * @return int
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
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }


    public function getContentByType($type, $object = false)
    {
        foreach ($this->getContent() as $content) {
            if ($content->getLang() == $type) {
                if($object) {
                    return $content;
                }
                return $content->getExtractedContent();
            }
        }
    }

}