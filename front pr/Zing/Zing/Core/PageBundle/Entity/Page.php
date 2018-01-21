<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_page")
 * @ORM\Entity
 */
class Page implements ZingEntityInterface
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="Zing\Core\PageBundle\Entity\PageLayout", mappedBy="page", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $page_layout;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Core\PageBundle\Entity\PageBlock", mappedBy="page", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $page_rel;

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
     * @ORM\OneToMany(targetEntity="Zing\Core\PageBundle\Entity\PageContent", mappedBy="page", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $page_content;

    public function __construct() {
        /** Default value for date modified */
        $this->date_modified = time();
        $this->page_rel = new ArrayCollection();
        $this->page_content = new ArrayCollection();
    }

    /**
     * @param string $date_added
     * @return object This
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
     * @return object This
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
     * @param string $status
     * @return object This
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
     * @param mixed $page_rel
     * @return object Page
     */
    public function setPageRel($page_rel)
    {
        $this->page_rel[] = $page_rel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageRel()
    {
        return $this->page_rel;
    }

    /**
     * @param mixed $children
     * @return object Page
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param int $id
     * @return object Page
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
     * @param mixed $page_layout
     * @return object Page
     */
    public function setPageLayout($page_layout)
    {
        $this->page_layout = $page_layout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageLayout()
    {
        return $this->page_layout;
    }

    /**
     * @param string $name
     * @return object Page
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
     * @param mixed $parent
     * @return object Page
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param string $url
     * @return object Page
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
     * @param mixed $page_content
     */
    public function setPageContent($page_content)
    {
        $this->page_content[] = $page_content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPageContent()
    {
        return $this->page_content;
    }

    public function getContentByType($type, $parsed = true) {
        foreach ($this->getPageContent() as $content) {
            if ($content->getLang() == $type) {
                if(!$parsed) {
                    return $content;
                }
                return $content->getExtractedContent();
            }
        }
    }

}
