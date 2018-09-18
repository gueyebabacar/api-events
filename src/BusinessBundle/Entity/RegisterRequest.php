<?php

namespace BusinessBundle\Entity;

use JMS\Serializer\Annotation as JMS;


/**
 * RegisterRequest
 */
class RegisterRequest
{
    /**
     * @JMS\Groups(groups={"event"})
     * @var int
     */
    private $id;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $name;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $compagnyName;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $email;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $phoneNumber;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $city;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $country;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $reasonForAttending;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $status;

    private $event;

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
     * Set name
     *
     * @param string $name
     *
     * @return RegisterRequest
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set compagnyName
     *
     * @param string $compagnyName
     *
     * @return RegisterRequest
     */
    public function setCompagnyName($compagnyName)
    {
        $this->compagnyName = $compagnyName;

        return $this;
    }

    /**
     * Get compagnyName
     *
     * @return string
     */
    public function getCompagnyName()
    {
        return $this->compagnyName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return RegisterRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return RegisterRequest
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return RegisterRequest
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return RegisterRequest
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set reasonForAttending
     *
     * @param string $reasonForAttending
     *
     * @return RegisterRequest
     */
    public function setReasonForAttending($reasonForAttending)
    {
        $this->reasonForAttending = $reasonForAttending;

        return $this;
    }

    /**
     * Get reasonForAttending
     *
     * @return string
     */
    public function getReasonForAttending()
    {
        return $this->reasonForAttending;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return RegisterRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     * @return RegisterRequest
     */
    public function setEvent($event)
    {
        $this->event = $event;
        return $this;
    }
}

