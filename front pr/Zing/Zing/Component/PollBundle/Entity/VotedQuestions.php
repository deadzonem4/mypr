<?php
namespace Zing\Component\PollBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_voted_questions")
 * @ORM\Entity
 */
class VotedQuestions implements ZingEntityInterface {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Component\PollBundle\Entity\Poll", inversedBy="voted_question")
     */
    private $poll;

    /**
     * @ORM\ManyToOne(targetEntity="Zing\Component\PollBundle\Entity\Questions", inversedBy="voted_question")
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="boolean")
     */
    private $answer = 0;

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
     * @param string $date_added
     * @return VotedQuestions
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
     * @return VotedQuestions
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
     * @return VotedQuestions
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
     * @return VotedQuestions
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
     * @return VotedQuestions
     */
    public function setQuestion($question)
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPoll()
    {
        return $this->poll;
    }

    /**
     * @param mixed $poll
     * @return VotedQuestions
     */
    public function setPoll($poll)
    {
        $this->poll = $poll;
        return $this;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return VotedQuestions
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }
}