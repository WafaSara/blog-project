<?php
 
namespace Blog\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/** @ORM\Entity */
class Post {
 
    /**
     * @var int id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
 
    /** 
     * @var string title of the post
     * @ORM\Column(type="string") 
     */
    private $title;

    /** 
     * @var string content description
     * @ORM\Column(type="text") 
     */
    private $content; 

     /**
     * @var  Category post's category
     * @ORM\OneToOne(targetEntity="Category")
     */
    private $category;

    /**
     * @var  MyUser post's author
     * @ORM\OneToOne(targetEntity="User\Entity\MyUser")
     * @ORM\JoinColumn(name="author", referencedColumnName="user_id")
     */
    private $author;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @var string updated at date
     */
    private $updatedAt; 

    /** 
     * @ORM\Column(name="created_at", type="datetime")
     * @var string created at date
     */
    private $createdAt; 
 
    /** 
     * @ORM\Column(type="boolean")
     * @var boolean deleted state
     */
    private $deleted;
  

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
     * Gets the value of title.
     *
     * @return string title of the post
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the value of title.
     *
     * @param string title of the post $title the title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the value of content.
     *
     * @return string content description
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the value of content.
     *
     * @param string content description $content the content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Gets the value of author.
     *
     * @return  MyUser post's author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the value of author.
     *
     * @param  MyUser post's author $author the author
     *
     * @return self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Gets the value of category.
     *
     * @return  Category post's category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Sets the value of category.
     *
     * @param  Category post's category $category the category
     *
     * @return self
     */
    public function setCategory($category)
    {
        $this->category = $category;

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
     * @param boolean deleted state $deleted the deleted
     *
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }
}