<?php

namespace BusinessBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Event
 */
class Event
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $customerRef;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $detailedDescription;

    /**
     * @var string
     */
    private $webSite;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $typeOfEvent;

    /**
     * @var string
     */
    private $industry;

    /**
     * @var string
     */
    private $thematicTag;

    /**
     * @var string
     */
    private $nameOfOrganizer;

    /**
     * @var string
     */
    private $contactForm;

    /**
     * @var string
     */
    private $attachment;

    /**
     * @var array
     */
    private $socialMediaSharing;

    /**
     * @var string
     */
    private $status;

    private $visuel;

    /**
     * @var ArrayCollection
     */
    private $illustrations;

    /**
     * @var ArrayCollection
     */
    private $requestRegisters;


    public function __construct() {
        $this->illustrations = new ArrayCollection();
        $this->requestRegisters = new ArrayCollection();
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
     * Set customerRef
     *
     * @param string $customerRef
     *
     * @return Event
     */
    public function setCustomerRef($customerRef)
    {
        $this->customerRef = $customerRef;

        return $this;
    }

    /**
     * Get customerRef
     *
     * @return string
     */
    public function getCustomerRef()
    {
        return $this->customerRef;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Event
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set detailedDescription
     *
     * @param string $detailedDescription
     *
     * @return Event
     */
    public function setDetailedDescription($detailedDescription)
    {
        $this->detailedDescription = $detailedDescription;

        return $this;
    }

    /**
     * Get detailedDescription
     *
     * @return string
     */
    public function getDetailedDescription()
    {
        return $this->detailedDescription;
    }

    /**
     * Set webSite
     *
     * @param string $webSite
     *
     * @return Event
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * Get webSite
     *
     * @return string
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Event
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
     * Set location
     *
     * @param string $location
     *
     * @return Event
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Event
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
     * Set typeOfEvent
     *
     * @param string $typeOfEvent
     *
     * @return Event
     */
    public function setTypeOfEvent($typeOfEvent)
    {
        $this->typeOfEvent = $typeOfEvent;

        return $this;
    }

    /**
     * Get typeOfEvent
     *
     * @return string
     */
    public function getTypeOfEvent()
    {
        return $this->typeOfEvent;
    }

    /**
     * Set industry
     *
     * @param string $industry
     *
     * @return Event
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;

        return $this;
    }

    /**
     * Get industry
     *
     * @return string
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Set thematicTag
     *
     * @param string $thematicTag
     *
     * @return Event
     */
    public function setThematicTag($thematicTag)
    {
        $this->thematicTag = $thematicTag;

        return $this;
    }

    /**
     * Get thematicTag
     *
     * @return string
     */
    public function getThematicTag()
    {
        return $this->thematicTag;
    }

    /**
     * Set nameOfOrganizer
     *
     * @param string $nameOfOrganizer
     *
     * @return Event
     */
    public function setNameOfOrganizer($nameOfOrganizer)
    {
        $this->nameOfOrganizer = $nameOfOrganizer;

        return $this;
    }

    /**
     * Get nameOfOrganizer
     *
     * @return string
     */
    public function getNameOfOrganizer()
    {
        return $this->nameOfOrganizer;
    }

    /**
     * Set contactForm
     *
     * @param string $contactForm
     *
     * @return Event
     */
    public function setContactForm($contactForm)
    {
        $this->contactForm = $contactForm;

        return $this;
    }

    /**
     * Get contactForm
     *
     * @return string
     */
    public function getContactForm()
    {
        return $this->contactForm;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return Event
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    /**
     * Get attachment
     *
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set socialMediaSharing
     *
     * @param array $socialMediaSharing
     *
     * @return Event
     */
    public function setSocialMediaSharing($socialMediaSharing)
    {
        $this->socialMediaSharing = $socialMediaSharing;

        return $this;
    }

    /**
     * Get socialMediaSharing
     *
     * @return array
     */
    public function getSocialMediaSharing()
    {
        return $this->socialMediaSharing;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Event
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
    public function getVisuel()
    {
        return $this->visuel;
    }

    /**
     * @param mixed $visuel
     * @return Event
     */
    public function setVisuel($visuel)
    {
        $this->visuel = $visuel;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIllustrations()
    {
        return $this->illustrations;
    }

    /**
     * @param ArrayCollection $illustrations
     * @return Event
     */
    public function setIllustrations($illustrations)
    {
        $this->illustrations = $illustrations;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getRequestRegisters()
    {
        return $this->requestRegisters;
    }

    /**
     * @param ArrayCollection $requestRegisters
     * @return Event
     */
    public function setRequestRegisters($requestRegisters)
    {
        $this->requestRegisters = $requestRegisters;
        return $this;
    }

}

