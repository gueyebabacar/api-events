<?php

namespace BusinessBundle\Entity;

use JMS\Serializer\Annotation as JMS;


/**
 * RegisterRequest
 */
class RegisterRequest
{
    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var int
     */
    private $id;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $name;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var integer
     */
    private $numberOfSeats;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $userId;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $compagnyName;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $email;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $phoneNumber;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $city;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $country;

    /**
     * @JMS\Groups(groups={"request_register","event"})
     * @var string
     */
    private $comments;

    private $deletedAt;

    /**
     * @var string
     */
    private $status;

    /**
     * @JMS\Groups(groups={"request_register"})
     */
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

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     * @return Event
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param string $comments
     * @return RegisterRequest
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfSeats()
    {
        return $this->numberOfSeats;
    }

    /**
     * @param int $numberOfSeats
     * @return RegisterRequest
     */
    public function setNumberOfSeats($numberOfSeats)
    {
        $this->numberOfSeats = $numberOfSeats;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}

