<?php
namespace Zing\Component\PollBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_question")
 * @ORM\Entity
 */
class Questions implements ZingEntityInterface {

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
     * @ORM\Column(name="question", type="string", length=500)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\PollBundle\Entity\VotedQuestions", mappedBy="question", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $voted_question;

    /**
     * @ORM\OneToMany(targetEntity="Zing\Component\PollBundle\Entity\QuestionsContent", mappedBy="question", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $content;

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

    public function __construct()
    {
        $this->voted_question = new ArrayCollection();
        $this->content = new ArrayCollection();
    }

    /**
     * @param string $date_added
     * @return Questions
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
     * @return Questions
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
     * @param int $id
     * @return Questions
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
     * @param string $status
     * @return Questions
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
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     * @return Questions
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @param mixed $voted_question
     * @return Questions
     */
    public function setVotedQuestion($voted_question)
    {
        $this->voted_question[] = $voted_question;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVotedQuestion()
    {
        return $this->voted_question;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return Questions
     */
    public function setContent($content)
    {
        $this->content[] = $content;
        return $this;
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
}