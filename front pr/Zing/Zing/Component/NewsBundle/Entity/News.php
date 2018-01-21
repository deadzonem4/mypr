<?php

namespace Zing\Component\NewsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * News
 *
 * @ORM\Table(name="zing_news")
 * @ORM\Entity
 */
class News implements ZingEntityInterface
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
     * @ORM\Column(name="author", type="string", length=150)
     */
    private $author;

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
     * @ORM\OneToMany(targetEntity="Zing\Component\NewsBundle\Entity\NewsUrl", mappedBy="news", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\NewsBundle\Entity\NewsContent", mappedBy="news", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Component\NewsBundle\Entity\Category", inversedBy="news")
     */
    private $category;


    public function __construct()
    {
        $this->content = new ArrayCollection();
        $this->url     = new ArrayCollection();
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
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