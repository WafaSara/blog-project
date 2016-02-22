<?php 

namespace Blog\Entity; 

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity(repositoryClass="Blog\Repository\CommentRepository")
 * @ORM\Table(name="comment")
 * @ORM\HasLifecycleCallbacks
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
	 * @ORM\Column(name="user_email", type="string", nullable = true)
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
     * @ORM\ManyToOne(targetEntity = "Post", inversedBy = "comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    /**
     * @ORM\Column(name="anonymous", type="string", length=255, nullable = true)
     */
    private $anonymous;

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
     * Gets the value of post.
     *
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Sets the value of post.
     *
     * @param mixed $post the post
     *
     * @return self
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

     /** 
     * @ORM\PrePersist
     * @return void
     */
    public function prePersist() {

        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /** 
     * @ORM\PreUpdate
     * @return void
     */
    public function preUpdate() {
        $this->setUpdatedAt(new \DateTime());

    }

     /**
     * Gets the value of anonymous.
     *
     * @return mixed
     */
    public function getAnonymous()
    {
        return $this->anonymous;
    }

    /**
     * Sets the value of anonymous.
     *
     * @param mixed $anonymous the anonymous
     *
     * @return self
     */
    public function setAnonymous($anonymous)
    {
        $this->anonymous = $anonymous;

        return $this;
    }
}

 ?>