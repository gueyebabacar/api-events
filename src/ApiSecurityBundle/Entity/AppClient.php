<?php

namespace ApiSecurityBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation as JMS;


/**
 * AppClient
 */
class AppClient implements UserInterface
{
    /**
     * @JMS\Groups(groups={"app"})
     * @var int
     */
    private $id;

    /**
     * @JMS\Groups(groups={"app"})
     * @var bool
     */
    private $enable;

    /**
     * @JMS\Groups(groups={"app"})
     * @var string
     */
    private $login;

    /**
     * @JMS\Groups(groups={"app"})
     * @var string
     */
    private $pwd;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var array
     */
    private $roles;


    public function __construct() {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set enable
     *
     * @param boolean $enable
     *
     * @return AppClient
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * Get enable
     *
     * @return bool
     */
    public function getEnable()
    {
        return $this->enable;
    }

    public function getRoles() {

        return $this->roles;
    }

    /**
     * @param array $roles
     * @return AppClient
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }


    public function getPassword() {
        return $this->getPwd();
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getUsername() {
        return $this->getLogin();
    }

    public function eraseCredentials() {}

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return AppClient
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @param string $pwd
     * @return AppClient
     */
    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
        return $this;
    }

}

