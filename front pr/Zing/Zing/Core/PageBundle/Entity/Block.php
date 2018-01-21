<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_block")
 * @ORM\Entity
 */
class Block implements ZingEntityInterface
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
     * @ORM\ManyToOne(targetEntity="Zing\Core\PageBundle\Entity\BlockType", inversedBy="block")
     */
    private $block_type;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Core\PageBundle\Entity\PageBlock", mappedBy="block", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $block_rel;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Core\PageBundle\Entity\BlockContent", mappedBy="block", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $block_content;

    /**
     * @ORM\OneToOne(targetEntity="Zing\Core\PageBundle\Entity\BlockPosition", mappedBy="block", cascade={"persist" ,"remove"}, orphanRemoval=true)
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
    private $status = 0;

    public function __construct() {
        /** Default value for date modified */
        $this->date_modified = time();
        $this->block_content = new ArrayCollection();
        $this->block_rel = new ArrayCollection();
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
     * @param mixed $block_position
     * @return object Block;
     */
    public function setBlockPosition($block_position)
    {
        $this->block_position = $block_position;
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
     * @param mixed $block_content
     * @return object Block
     */
    public function setBlockContent($block_content)
    {
        $this->block_content[] = $block_content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlockContent()
    {
        return $this->block_content;
    }

    /**
     * @param mixed $block_rel
     * @return object Block
     */
    public function setBlockRel($block_rel)
    {
        $this->block_rel[] = $block_rel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBlockRel()
    {
        return $this->block_rel;
    }


    /**
     * @param int $id
     * @return object Block
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
     * @param string $block_type
     * @return object Block
     */
    public function setBlockType($block_type)
    {
        $this->block_type = $block_type;
        return $this;
    }

    /**
     * @return string
     */
    public function getBlockType()
    {
        return $this->block_type;
    }

    public function getContentByType($type, $parsed = true) {
        foreach ($this->getBlockContent() as $content) {
            if ($content->getLang() == $type) {
                if(!$parsed) {
                    return $content;
                }
                return $content->getExtractedContent();
            }
        }
    }



}
