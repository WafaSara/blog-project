<?php

namespace User\Entity;

use ZfcUser\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use BjyAuthorize\Provider\Role\ProviderInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="my_user")
 */
class MyUser extends User implements ProviderInterface
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

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="User\Entity\Role")
     * @ORM\JoinTable(name="user_role_linker",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    /**
     * @ORM\OneToMany(targetEntity="Blog\Entity\Comment", mappedBy="author")
     */
    protected $comments;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->posts = new ArrayCollection();
        $this->roles = new ArrayCollection();
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

    /**
     * Get role.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * Add a role to the user.
     *
     * @param Role $role
     *
     * @return void
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }

    public function getComments()
    {
        return $this->comments;
    }
}
