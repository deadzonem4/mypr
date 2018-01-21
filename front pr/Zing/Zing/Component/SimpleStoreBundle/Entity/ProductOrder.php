<?php

namespace Zing\Component\SimpleStoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zing\Core\CoreBundle\CoreInterface\ZingEntityInterface;

/**
 * Category
 *
 * @ORM\Table(name="zing_simplestore_orders")
 * @ORM\Entity
 */
class ProductOrder implements ZingEntityInterface
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
     * @ORM\ManyToOne(targetEntity="Zing\Core\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    private $user = null;

    /**
     * @var string
     *
     * @ORM\Column(name="checkout_cart", type="text")
     */
    private $checkout_cart;

    /**
     * @var string
     *
     * @ORM\Column(name="user_data", type="text")
     */
    private $userdata;

    /**
     * @var string
     *
     * @ORM\Column(name="user_calculation", type="text")
     */
    private $user_calculation;

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
     * Status - rejected
     * Status - waiting
     * Status - done
     *
     *
     * @var integer
     *
     * @ORM\Column(name="status", type="string", length=150)
     */
    private $status = 'waiting';

    /**
     * @param mixed $user_calculation
     */
    public function setUserCalculation($user_calculation)
    {
        $this->user_calculation = $user_calculation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserCalculation($parsed = true)
    {
        if($parsed) {
            return json_decode($this->user_calculation, true);
        }
        return $this->user_calculation;
    }


    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $checkout_cart
     */
    public function setCheckoutCart($checkout_cart)
    {
        $this->checkout_cart = $checkout_cart;
        return $this;
    }

    /**
     * @return string
     */
    public function getCheckoutCart($parsed = true)
    {
        if($parsed) {
            return json_decode($this->checkout_cart, true);
        }
        return $this->checkout_cart;
    }

    /**
     * @param int $date_added
     */
    public function setDateAdded($date_added)
    {
        $this->date_added = $date_added;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateAdded()
    {
        return $this->date_added;
    }

    /**
     * @param int $date_modified
     */
    public function setDateModified($date_modified)
    {
        $this->date_modified = $date_modified;
        return $this;
    }

    /**
     * @return int
     */
    public function getDateModified()
    {
        return $this->date_modified;
    }

    /**
     * @param int $id
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
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $userdata
     */
    public function setUserdata($userdata)
    {
        $this->userdata = $userdata;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserdata($parsed = true)
    {
        if($parsed) {
            return json_decode($this->userdata, true);
        }
        return $this->userdata;
    }

}
