<?php

namespace Alex\Bundle\MNCBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job", indexes={@ORM\Index(name="immediate", columns={"immediate"})})
 * @ORM\Entity
 */
class Job
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="salary", type="decimal", precision=6, scale=2, nullable=true)
     */
    private $salary;

    /**
     * @var integer
     *
     * @ORM\Column(name="job_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $jobId;

    /**
     * @var \Alex\Bundle\MNCBundle\Entity\Person
     *
     * @ORM\ManyToOne(targetEntity="Alex\Bundle\MNCBundle\Entity\Person")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="immediate", referencedColumnName="user_id")
     * })
     */
    private $immediate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Alex\Bundle\MNCBundle\Entity\Person", mappedBy="job")
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set description
     *
     * @param string $description
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set salary
     *
     * @param string $salary
     * @return Job
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary
     *
     * @return string 
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Get jobId
     *
     * @return integer 
     */
    public function getJobId()
    {
        return $this->jobId;
    }

    /**
     * Set immediate
     *
     * @param \Alex\Bundle\MNCBundle\Entity\Person $immediate
     * @return Job
     */
    public function setImmediate(\Alex\Bundle\MNCBundle\Entity\Person $immediate = null)
    {
        $this->immediate = $immediate;

        return $this;
    }

    /**
     * Get immediate
     *
     * @return \Alex\Bundle\MNCBundle\Entity\Person 
     */
    public function getImmediate()
    {
        return $this->immediate;
    }

    /**
     * Add user
     *
     * @param \Alex\Bundle\MNCBundle\Entity\Person $user
     * @return Job
     */
    public function addUser(\Alex\Bundle\MNCBundle\Entity\Person $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Alex\Bundle\MNCBundle\Entity\Person $user
     */
    public function removeUser(\Alex\Bundle\MNCBundle\Entity\Person $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUser()
    {
        return $this->user;
    }
}
