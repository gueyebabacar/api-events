<?php

namespace ApiSecurityBundle\Entity;

/**
 * CustomerClient
 */
class CustomerClient
{
    /**
     * @var int
     */
    private $id;

    /** list of authorized role for a user
     */
    private $scopes;

    /**
     * @var bool
     */
    private $enable;

    /**
     * @var string
     */
    private $xCustomerRef;


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
     * @return CustomerClient
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

    /**
     * Set xCustomerRef
     *
     * @param string $xCustomerRef
     *
     * @return CustomerClient
     */
    public function setXCustomerRef($xCustomerRef)
    {
        $this->xCustomerRef = $xCustomerRef;

        return $this;
    }

    /**
     * Get xCustomerRef
     *
     * @return string
     */
    public function getXCustomerRef()
    {
        return $this->xCustomerRef;
    }

    /**
     * @return mixed
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     * @return CustomerClient
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
        return $this;
    }
}

