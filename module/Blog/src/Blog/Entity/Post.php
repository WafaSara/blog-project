<?php
 
namespace Blog\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @ORM\Entity(repositoryClass="Blog\Repository\PostRepository")
 * @ORM\Table(name="post")
 * @ORM\HasLifecycleCallbacks
 */
class Post {
 
    /**
     * @var int id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer")
     */
    private $id;
 
    /** 
     * @var string title of the post
     * @ORM\Column(name="title",type="string") 
     */
    private $title;

    /** 
     * @var string content description
     * @ORM\Column(name="content",type="text") 
     */
    private $content;


    /**
     * @var Category post's category
     * @ORM\ManyToOne(targetEntity="Category", inversedBy = "posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id" )
     */
    private $category;

    /**
     * @var  MyUser post's author
     * @ORM\ManyToOne(targetEntity="User\Entity\MyUser", inversedBy = "posts")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="user_id")
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
     * @ORM\Column(name="deleted",type="boolean")
     * @var boolean deleted state
     */
    private $deleted;

    /**
     * @ORM\Column(name="photo", type="string", nullable = true)
     */
    private $photo;

    /**
     * @ORM\Column(name="photo_real_name", type="string", nullable = true)
     */
    private $photoRealName;

    /**
     * @ORM\Column(name="photo_extension", type="string", nullable = true)
     */
    private $photoExtension;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;

    /**
     * @var  MyUser post's update
     * @ORM\ManyToOne(targetEntity="User\Entity\MyUser")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="user_id")
     */
    private $updatedBy;

    public $file;

    function __construct()
    {
        $this->comments = new ArrayCollection();
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

     /**
     * Gets the value of comments.
     *
     * @return boolean comments state
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Gets the value of photo.
     *
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Sets the value of photo.
     *
     * @param mixed $photo the photo
     *
     * @return self
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

      /**
     * Gets the value of file.
     *
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets the value of file.
     *
     * @param mixed $file the file
     *
     * @return self
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Gets the value of photoRealName.
     *
     * @return mixed
     */
    public function getPhotoRealName()
    {
        return $this->photoRealName;
    }

    /**
     * Sets the value of photoRealName.
     *
     * @param mixed $photoRealName the photoRealName
     *
     * @return self
     */
    public function setPhotoRealName($photoRealName)
    {
        $this->photoRealName = $photoRealName;

        return $this;
    }

     /**
     * Gets the value of photoExtension.
     *
     * @return mixed
     */
    public function getPhotoExtension()
    {
        return $this->photoExtension;
    }

    /**
     * Sets the value of photoExtension.
     *
     * @param mixed $photoExtension the photoExtension
     *
     * @return self
     */
    public function setPhotoExtension($photoExtension)
    {
        $this->photoExtension = $photoExtension;

        return $this;
    }
    /** 
     * @ORM\PrePersist
     * @return void
     */
    public function prePersist() {
       /* if (empty($this->author)) {
            $this->setAuthor($this->getAuthenticationService()->getIdentity());
        }*/

        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
   /*     $this->setAuthor($this->getAuthenticationService()->getIdentity());
        $this->setUpdatedBy($this->getAuthenticationService()->getIdentity());*/
    }

    /** 
     * @ORM\PreUpdate
     * @return void
     */
    public function preUpdate() {
        $this->setUpdatedAt(new \DateTime());
  /*      $this->setAuthor($this->getAuthenticationService()->getIdentity());
        $this->setUpdatedBy($this->getAuthenticationService()->getIdentity());*/
    }

    /**
     * Gets the value of updatedBy.
     *
     * @return  MyUser post's updatedBy
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Sets the value of updatedBy.
     *
     * @param  MyUser post's updatedBy $updatedBy the updatedBy
     *
     * @return self
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function isDeleted()
    {
        return ($this->deleted) ? true : false;
    }

    public function getWebPath()
    {
        return null === $this->photo
             ? null
             : $this->getUploadDir().'/'.$this->photo;
    }

    public function getUploadDir() {
        
        return 'upload/posts';
    }
    public function getAbsoluteUploadDir() {
        
        return "./data/upload/posts";
    }
}