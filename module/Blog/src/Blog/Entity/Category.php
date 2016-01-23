<?php 

namespace Blog\Entity; 

use Doctrine\ORM\Mapping as ORM;
 
/** 
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="cat_id",type="integer")
	 * @var int id
	 */
	private $id; 

	/**
	 * @ORM\Column(name="cat_label",type="string",unique=true) 
	 * @var string label
	 */
	private $label; 

	/**
	 * @ORM\Column(name="cat_created_at", type="datetime") 
	 * @var string created at date
	 */
	private $createdAt;

	/**
	 * @ORM\Column(name="cat_updated_at", type="datetime")
	 * @var string updated at date
	 */
	private $updatedAt; 

	/**
	 * @ORM\Column(name="cat_deleted",type="boolean") 
	 * @var boolean deleted state
	 */
	private $deleted; 
	

	function __construct()
	{
		# code...
	}

	function __destruct()
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
}

 ?>