<?php

namespace BusinessBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

/**
 * Event
 */
class Event
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
    private $customerRef;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $name;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $date;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $detailedDescription;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $website;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $country;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $location;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $city;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $typeOfEvent;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $industry;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $thematicTag;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $nameOfOrganizer;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $contactForm;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $attachment;

    /**
     * @JMS\Groups(groups={"event"})
     * @JMS\Type("array<string>")
     */
    private $socialMediaSharing;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $status;

    /**
     * @JMS\Groups(groups={"event"})
     * @var ArrayCollection
     */
    private $requestRegisters;

    /**
     * @JMS\Groups(groups={"event"})
     * @JMS\Type("array<string>")
     * @var string
     */
    private $visuel;

    /**
     * @JMS\Groups(groups={"event"})
     * @JMS\Type("array<string>")
     */
    private $illustrations;

    public function __construct() {
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
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Event
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
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

    /**
     * @return string
     */
    public function getVisuel()
    {
        return $this->visuel;
    }

    /**
     * @param string $visuel
     * @return Event
     */
    public function setVisuel($visuel)
    {
        $this->visuel = $visuel;
        return $this;
    }

    /**
     * @return string
     */
    public function getIllustrations()
    {
        return $this->illustrations;
    }

    /**
     * @param string $illustrations
     * @return Event
     */
    public function setIllustrations($illustrations)
    {
        $this->illustrations = $illustrations;
        return $this;
    }
}

