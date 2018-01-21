<?php

namespace Zing\Component\SimpleStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * CategoryUrl
 *
 * @ORM\Table(name="zing_simplestore_product_url")
 * @ORM\Entity
 */
class ProductUrl implements ZingEntityInterface
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
     * @ORM\Column(name="url", type="string", length=150)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="lang", type="string")
     */
    private $lang;

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

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Component\SimpleStoreBundle\Entity\Product", inversedBy="url")
     */
    private $product;

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
     * @param int $lang
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return int
     */
    public function getLang()
    {
        return $this->lang;
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



}
