<?php

namespace Zing\Component\SimpleStoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Category
 *
 * @ORM\Table(name="zing_simplestore_product")
 * @ORM\Entity
 */
class Product implements ZingEntityInterface
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
     * @ORM\Column(name="rating", type="decimal", precision=11, scale=2)
     */
    private $rating = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="votes", type="integer")
     */
    private $votes = 0;


    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=150)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="discount", type="decimal", precision=11, scale=2)
     */
    private $discount = 0.00;

    /**
     * @var string
     *
     * @ORM\Column(name="discount_used", type="decimal", precision=11, scale=2)
     */
    private $discount_used = 0.00;

    /**
     * @var string
     *
     * @ORM\Column(name="discount_type", type="string", length=150)
     */
    private $discount_type = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=150)
     */
    private $currency;

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
     * @ORM\Column(name="instock_status", type="boolean")
     */
    private $instock_status = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = 0;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\SimpleStoreBundle\Entity\ProductUrl", mappedBy="product", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\SimpleStoreBundle\Entity\ProductContent", mappedBy="product", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Component\SimpleStoreBundle\Entity\Manufacture", inversedBy="product")
     */
    private $manufacture;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Component\SimpleStoreBundle\Entity\Category", inversedBy="product")
     */
    private $category;


    public function __construct()
    {
        $this->content = new ArrayCollection();
        $this->url     = new ArrayCollection();
    }

    /**
     * @param string $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }



    /**
     * @return string
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param string $votes
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;
        return $this;
    }

    /**
     * @return string
     */
    public function getVotes()
    {
        return $this->votes;
    }


    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url[] = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
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
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
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
     * @param string $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    public function calculatePrice()
    {

        if($this->getDiscount()) {
            $price = $this->getPrice() - $this->getDiscount();
        } else {
            $price = $this->getPrice();
        }

        /** If the price is lower than 0 return 0 */
        if($price < 0) {return 0;}

        return $price;
    }

    /**
     * @param string $discount_type
     */
    public function setDiscountType($discount_type)
    {
        $this->discount_type = $discount_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountType()
    {
        return $this->discount_type;
    }

    /**
     * @param string $discount_used
     */
    public function setDiscountUsed($discount_used)
    {
        $this->discount_used = $discount_used;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountUsed()
    {
        return $this->discount_used;
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
     * @param mixed $manufacture
     */
    public function setManufacture($manufacture)
    {
        $this->manufacture = $manufacture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getManufacture()
    {
        return $this->manufacture;
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
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }


    /**
     * @param string $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $instock_status
     */
    public function setInstockStatus($instock_status)
    {
        $this->instock_status = $instock_status;
        return $this;
    }

    /**
     * @return int
     */
    public function getInstockStatus()
    {
        return $this->instock_status;
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

    public function getAverageRating()
    {
        if($this->getRating() == 0) {
            return 0;
        }
        return $this->getRating() / $this->getVotes();
    }

    public function getContentByType($type, $object = false) {
        foreach ($this->getContent() as $content) {
            if ($content->getLang() == $type) {
                if($object) {
                    return $content;
                }
                return $content->getExtractedContent();
            }
        }
    }

    public function getUrlByType($type, $object = false) {
        foreach ($this->getUrl() as $url) {
            if ($url->getLang() == $type) {
                if($object) {
                    return $url;
                }
                return $url->getUrl();
            }
        }
    }

}
