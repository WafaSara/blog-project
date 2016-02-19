<?php

namespace User\Entity;

use ZfcUser\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity 
 * @ORM\Table(name="my_user")
 */
class MyUser extends User
{
    
    /**
     * @var $updateDate datetime
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;
    
    /**
     * @var $updateDate datetime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="Blog\Entity\Post", mappedBy="author")
     */
    protected $posts;

    /**
     * @ORM\Column(name="is_super_admin", type="boolean")
     */
    protected $isSuperAdmin = 0;

    /**
     * @ORM\Column(name="mail_company", type="string", length=255)
     */
    protected $mailCompany;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->posts = new ArrayCollection();
    }

    /**
     * get creation date
     *
     * @return $createdAt
     **/
    public function getCreatedAt()
    {
       return $this->createdAt();
    }

    /**
     * get update date
     *
     * @return $updateAt
     **/
    public function getUpdatedAt()
    {
        return $this->updatedAt();
    }

    
    /**
     * set creation date
     *
     * @return void
     **/
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * set update date 
     *
     * @return void
     **/
    public function setUpdateAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

     /**
     * get Post created by myUser
     *
     * @return ArrayCollection posts
     **/
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Gets the value of isSuperAdmin.
     *
     * @return mixed
     */
    public function getIsSuperAdmin()
    {
        return $this->isSuperAdmin;
    }

    /**
     * Sets the value of isSuperAdmin.
     *
     * @param mixed $isSuperAdmin the is super admin
     *
     * @return self
     */
    protected function setIsSuperAdmin($isSuperAdmin)
    {
        $this->isSuperAdmin = $isSuperAdmin;

        return $this;
    }

    public function __toString()
    {
        return $this->username;
    }

     /**
     * Gets the value of mailCompany.
     *
     * @return mixed
     */
    public function getMailCompany()
    {
        return $this->mailCompany;
    }

    /**
     * Sets the value of mailCompany.
     *
     * @param mixed $mailCompany the mail company
     *
     * @return self
     */
    protected function setMailCompany($mailCompany)
    {
        $this->mailCompany = $mailCompany;

        return $this;
    }
}
