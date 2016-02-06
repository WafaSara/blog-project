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
}
