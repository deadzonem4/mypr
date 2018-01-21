<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * LayoutPosition
 *
 * @ORM\Table(name="zing_block_position")
 * @ORM\Entity
 */
class BlockPosition implements ZingEntityInterface
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
     * @ORM\Column(name="block_order", type="integer")
     */
    private $block_order;

    /**
     * @ORM\Column(name="layout_position", type="integer")
     */
    private $layout_position;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Core\PageBundle\Entity\PageLayout", inversedBy="block_position")
     */
    private $page_layout;

    /**
     * @ORM\OneToOne(targetEntity="Zing\Core\PageBundle\Entity\Block", inversedBy="block_position")
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
     * @return object BlockPosition
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
     * @param string $block_order
     * @return object BlockPosition
     */
    public function setBlockOrder($block_order)
    {
        $this->block_order = $block_order;
        return $this;
    }

    /**
     * @return string
     */
    public function getBlockOrder()
    {
        return $this->block_order;
    }

    /**
     * @param int $id
     * @return object BlockPosition
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
     * @return object BlockPosition
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
     * @param mixed $layout_position
     * @return object BlockPosition
     */
    public function setLayoutPosition($layout_position)
    {
        $this->layout_position = $layout_position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLayoutPosition()
    {
        return $this->layout_position;
    }



}
