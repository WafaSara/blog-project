<?php 

namespace Blog\Entity; 

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class Comment
{

	/**
	 * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer")
	 * @var int id
	 */
	private $id;

	/**
	 * @ORM\Column(name="user_email", type="string")
	 * @var string user email
	 */
	private $userEmail; 

	/**
	 * @ORM\Column(name="comment",type="text") 
	 * @var string comment content
	 */
	private $comment; 

	/**
	 * @ORM\Column(name="created_at", type="datetime") 
	 * @var string created at date
	 */
	private $createdAt; 

	/**
	 * @ORM\Column(name="updated_at", type="datetime") 
	 * @var string updated at date 
	 */
	private $updatedAt; 

	/**
	 * @ORM\Column(name="deleted",type="boolean")
	 * @var boolean deleted state
	 */
	private $deleted; 

    /**
     * @ORM\ManyToOne(targetEntity = "Post", inversedBy = "comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
     private $post;

    function __construct()
    {
        # code...
    }
    /**
     * Gets the value of id.
     *
     * @return int id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the value of id.
     *
     * @param int id $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of userEmail.
     *
     * @return string user email
     */
    public function getUserEmail()
    {
        return $this->userEmail;
    }

    /**
     * Sets the value of userEmail.
     *
     * @param string user email $userEmail the user email
     *
     * @return self
     */
    public function setUserEmail($userEmail)
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * Gets the value of comment.
     *
     * @return string comment content
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the value of comment.
     *
     * @param string comment content $comment the comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Gets the value of createdAt.
     *
     * @return string created at date
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the value of createdAt.
     *
     * @param string created at date $createdAt the created at
     *
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Gets the value of updatedAt.
     *
     * @return string updated at date
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Sets the value of updatedAt.
     *
     * @param string updated at date $updatedAt the updated at
     *
     * @return self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Gets the value of deleted.
     *
     * @return boolean deleted state
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Sets the value of deleted.
     *
     * @param boolean deleted state $deleted 
     *
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }
}

 ?>