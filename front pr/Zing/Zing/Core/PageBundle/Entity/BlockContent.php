<?php

namespace Zing\Core\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_block_content")
 * @ORM\Entity
 */
class BlockContent implements ZingEntityInterface
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
     * @ORM\Column(name="lang", type="string", length=150)
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Zing\Core\PageBundle\Entity\Block", inversedBy="block_content")
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
     * @param string $block
     * @return object BlockContent
     */
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }

    /**
     * @return string
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param string $content
     * @return object BlockContent
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param int $id
     * @return object BlockContent
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
     * @param string $lang
     * @return object BlockContent
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    public function getExtractedContent() {
        return json_decode($this->getContent(), true);
    }

}
