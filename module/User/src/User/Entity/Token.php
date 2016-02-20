<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="User\Repository\TokenRepository")
 * @ORM\Table(name="token")
 */
class Token
{
    /**
     * @var int id
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=50, unique=true)
     */
    private $token;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\MyUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire_at", type="datetime")
     */
    private $expireAt;

    public function __construct()
    {
        $this->token = uniqid(mt_rand(), true);
        $this->expireAt = new \DateTime();
        $this->expireAt->add(new \DateInterval('P1D'));
    }

    /**
     * @param int|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param MyUser $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return MyUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \DateTime $expireAt
     */
    public function setExpireAt($expireAt)
    {
        $this->expireAt = $expireAt;
    }

    /**
     * @return \DateTime
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    public function isValid()
    {
        $now = new \DateTime();

        return ($now < $this->getExpireAt()) ? true : false;
    }
}
