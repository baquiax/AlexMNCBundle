<?php

namespace Alex\Bundle\MNCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attendance
 *
 * @ORM\Table(name="attendance", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Attendance
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="check_hour", type="datetime", nullable=false)
     */
    private $checkHour;

    /**
     * @var integer
     *
     * @ORM\Column(name="att_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $attId;

    /**
     * @var \Alex\Bundle\MNCBundle\Entity\Person
     *
     * @ORM\ManyToOne(targetEntity="Alex\Bundle\MNCBundle\Entity\Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;



    /**
     * Set checkHour
     *
     * @param \DateTime $checkHour
     * @return Attendance
     */
    public function setCheckHour($checkHour)
    {
        $this->checkHour = $checkHour;

        return $this;
    }

    /**
     * Get checkHour
     *
     * @return \DateTime 
     */
    public function getCheckHour()
    {
        return $this->checkHour;
    }

    /**
     * Get attId
     *
     * @return integer 
     */
    public function getAttId()
    {
        return $this->attId;
    }

    /**
     * Set user
     *
     * @param \Alex\Bundle\MNCBundle\Entity\Person $user
     * @return Attendance
     */
    public function setUser(\Alex\Bundle\MNCBundle\Entity\Person $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Alex\Bundle\MNCBundle\Entity\Person 
     */
    public function getUser()
    {
        return $this->user;
    }
}
