<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_layout")
 * @ORM\Entity
 */
class Layout implements ZingEntityInterface
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
     * @ORM\Column(name="layout_file", type="string", length=150)
     */
    private $layout_file;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Core\PageBundle\Entity\PageLayout", mappedBy="layout", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $page_layout;

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
     * @var string
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = 0;

    public function __construct() {
        /** Default value for date modified */
        $this->date_modified = time();
        $this->page_layout = new ArrayCollection();
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
     * @param integer $date_modified
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
     * @param mixed $page_layout
     * @return object Layout
     */
    public function setPageLayout($page_layout)
    {
        $this->page_layout[] = $page_layout;
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
     * @param int $id
     * @return object Layout
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
     * @return object Layout
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
     * @param string $layout_file
     * @return object Layout
     */
    public function setLayoutFile($layout_file)
    {
        $this->layout_file = $layout_file;
        return $this;
    }

    /**
     * @return string
     */
    public function getLayoutFile()
    {
        return $this->layout_file;
    }

}
