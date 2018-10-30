<?php

namespace BusinessBundle\Entity;

use JMS\Serializer\Annotation as JMS;


/**
 * ValueList
 */
class ValueList
{
    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var int
     */
    private $id;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $domain;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $value;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $key;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var bool
     */
    private $enable;

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
     * Set domain
     *
     * @param string $domain
     *
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isEnable()
    {
        return $this->enable;
    }

    /**
     * @param bool $enable
     * @return $this
     */
    public function setEnable($enable)
    {
        $this->enable = $enable;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }
}

