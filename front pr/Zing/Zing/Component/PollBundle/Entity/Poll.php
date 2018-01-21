<?php
namespace Zing\Component\PollBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Layout
 *
 * @ORM\Table(name="zing_poll")
 * @ORM\Entity
 */
class Poll implements ZingEntityInterface {

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
     * @ORM\Column(name="email", type="string", length=150)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=150)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=150)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="birth_year", type="integer")
     */
    private $birth_year;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=150)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=150, nullable=true)
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="positive_answers", type="integer")
     */
    private $positive_answers = 0;

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
     * @ORM\OneToMany(targetEntity="Zing\Component\PollBundle\Entity\VotedQuestions", mappedBy="poll", cascade={"persist" ,"remove"}, orphanRemoval=true)
     */
    private $voted_question;

    public function __construct()
    {
        $this->voted_question = new ArrayCollection();
    }

    /**
     * @param string $date_added
     * @return Poll
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
     * @return Poll
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
     * @param string $phone
     * @return Poll
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * @param string $email
     * @return Poll
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param int $id
     * @return Poll
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
     * @return Poll
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
     * @param string $name
     * @return Poll
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
     * @return string
     */
    public function getBirthYear()
    {
        return $this->birth_year;
    }

    /**
     * @param string $birth_year
     * @return Poll
     */
    public function setBirthYear($birth_year)
    {
        $this->birth_year = $birth_year;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Poll
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getPositiveAnswers()
    {
        return $this->positive_answers;
    }

    /**
     * @param string $positive_answers
     * @return Poll
     */
    public function setPositiveAnswers($positive_answers)
    {
        $this->positive_answers = $positive_answers;
        return $this;
    }

    /**
     * @param mixed $voted_question
     * @return Poll
     */
    public function setVotedQuestion($voted_question)
    {
        $this->voted_question->add($voted_question);
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
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Poll
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }
}