<?php 

namespace Blog\Entity; 

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Cocur\Slugify\Slugify;

/** 
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\CategoryRepository")
 * @ORM\Table(name="category")
 * @ORM\HasLifecycleCallbacks
 */
class Category
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer")
	 * @var int id
	 */
	private $id;

	/**
	 * @ORM\Column(name="label",type="string",unique=true) 
	 * @var string label
	 */
	private $label; 

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
	private $deleted = 0;
	
    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category")
     */
    private $posts;

    /**
     * @ORM\Column(name="photo", type="string", nullable = true)
     */
    private $photo;

    /**
     * @ORM\Column(name="slug", type="string")
     */
    private $slug;

	function __construct()
	{
		$posts = new ArrayCollection();
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
     * @param int $id the id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Gets the value of label.
     *
     * @return string label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the value of label.
     *
     * @param string $label the label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

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
     * @param string $createdAt the created at date
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
     * @param string  $updatedAt the updated at date
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
     * @param boolean $deleted the deleted
     *
     * @return self
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Gets the value of posts.
     *
     * @return string posts
     */
    public function getPosts()
    {
        return $this->posts;
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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $slugify = new Slugify();
        $this->slug =  $slugify->slugify($slug);

        return $slug;
    }

    /** 
    * @ORM\PrePersist()
    * @ORM\PreUpdate() 
    */
    public function prePersist() {
        // $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        $this->setSlug($this->label);
    }

    /**
     * [getArrayCopy transforme un tableau en objet]
     * @return Category
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    /**
     * [populate set notre objet lors du bind]
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    public function populate($data = array())
    {
        $this->id = ( isset($data['id'])) ? $data['id'] : null;
        $this->label = (isset($data['category']['label'])) ? $data['category']['label'] : null;
    }
}

 ?>