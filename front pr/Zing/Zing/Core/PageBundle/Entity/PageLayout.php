<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * LayoutPosition
 *
 * @ORM\Table(name="zing_page_layout")
 * @ORM\Entity
 */
class PageLayout implements ZingEntityInterface
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
     * @ORM\ManyToOne(targetEntity="Zing\Core\PageBundle\Entity\Layout", inversedBy="page_layout")
     */
    private $layout;

    /**
     * @ORM\OneToOne(targetEntity="Zing\Core\PageBundle\Entity\Page", inversedBy="page_layout")
     */
    private $page;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Core\PageBundle\Entity\BlockPosition", mappedBy="page_layout", cascade={"persist" ,"remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"block_order" = "ASC"})
     */
    private $block_position;

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
    private $status = 1;

    public function __construct() {
        /** Default value for date modified */
        $this->date_modified = time();
        $this->block_position = new ArrayCollection();
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
     * @param mixed $page
     * @return object LayoutPosition
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

    /**
     * @param int $id
     * @return object LayoutPosition
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
     * @param mixed $layout
     * @return object LayoutPosition
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param mixed $block_position
     * @return object LayoutPosition
     */
    public function setBlockPosition($block_position)
    {
        $this->block_position[] = $block_position;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlockPosition()
    {
        return $this->block_position;
    }

    /**
     * @return mixed
     */
    public function getBlockPositionByLayoutPositionAsKey()
    {
        $positions = array();
        foreach($this->block_position as $position) {
            $positions[$position->getLayoutPosition()][] = $position;
        }

        return $positions;
    }

    public function getActiveBlockPositionByLayoutPositionAsKey()
    {
        $positions = array();
        foreach($this->block_position as $position) {
            if($position->getBlock()->getBlockType()->getStatus()) {
                $positions[$position->getLayoutPosition()][] = $position;
            }
        }

        return $positions;
    }

    /**
     * @return mixed
     */
    public function getBlockPositionByLayoutPosition($pos)
    {
        $positions = array();
        foreach($this->block_position as $position) {
            $block_position = $position->getLayoutPosition();
            if($block_position == $pos) {
                $positions[$block_position][] = $position;
            }
        }

        return $positions;
    }

}
