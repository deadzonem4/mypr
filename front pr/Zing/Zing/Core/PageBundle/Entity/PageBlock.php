<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Template
 *
 * @ORM\Table(name="zing_page_block")
 * @ORM\Entity
 */
class PageBlock implements ZingEntityInterface
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
     * @ORM\ManyToOne(targetEntity="Zing\Core\PageBundle\Entity\Page", inversedBy="page_rel")
     */
    private $page;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Core\PageBundle\Entity\Block", inversedBy="block_rel")
     */
    private $block;

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


    public function __construct() {
        /** Default value for date modified */
        $this->date_modified = time();
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
     * @param mixed $block
     * @return object PageBlock
     */
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param int $id
     * @return object PageBlock
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
     * @param mixed $page
     * @return object PageBlock
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }



}
