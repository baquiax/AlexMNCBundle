<?php

namespace Alex\Bundle\MNCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table(name="person")
 * @ORM\Entity
 */
class Person
{
    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=100, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastnames", type="string", length=100, nullable=false)
     */
    private $lastnames;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=250, nullable=false)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Alex\Bundle\MNCBundle\Entity\Job", inversedBy="user")
     * @ORM\JoinTable(name="job_rel",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="job_id", referencedColumnName="job_id")
     *   }
     * )
     */
    private $job;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->job = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastnames
     *
     * @param string $lastnames
     * @return Person
     */
    public function setLastnames($lastnames)
    {
        $this->lastnames = $lastnames;

        return $this;
    }

    /**
     * Get lastnames
     *
     * @return string 
     */
    public function getLastnames()
    {
        return $this->lastnames;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Person
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Person
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Add job
     *
     * @param \Alex\Bundle\MNCBundle\Entity\Job $job
     * @return Person
     */
    public function addJob(\Alex\Bundle\MNCBundle\Entity\Job $job)
    {
        $this->job[] = $job;

        return $this;
    }

    /**
     * Remove job
     *
     * @param \Alex\Bundle\MNCBundle\Entity\Job $job
     */
    public function removeJob(\Alex\Bundle\MNCBundle\Entity\Job $job)
    {
        $this->job->removeElement($job);
    }

    /**
     * Get job
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJob()
    {
        return $this->job;
    }
}
