<?php

namespace BusinessBundle\Entity;

use BusinessBundle\ValueObject\Media;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;


/**
 * Event
 */
class Event
{
    const DELETE_STATUS = "draft";

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
    private $title;

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
    private $venue;

    /**
     * @JMS\Groups(groups={"event"})
     * @var string
     */
    private $city;

    /**
     * @JMS\Groups(groups={"event"})
     * @JMS\Type("array<BusinessBundle\Entity\ValueList>")
     */
    private $typeOfEvent;

    /**
     * @JMS\Groups(groups={"event"})
     * @JMS\Type("array<BusinessBundle\Entity\ValueList>")
     */
    private $industries;

    /**
     * @JMS\Groups(groups={"event"})
     * @JMS\Type("array<BusinessBundle\Entity\ValueList>")
     */
    private $topic;

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
     * @var ArrayCollection
     */
    private $requestRegisters;


    private $visuel;

    /**
     * @JMS\Type("array< BusinessBundle\ValueObject\Media>")
     */
    private $illustrations;

    private $deletedAt;

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
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     * @return Event
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
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
     * @return mixed
     */
    public function getIndustries()
    {
        return $this->industries;
    }

    /**
     * @param mixed $industries
     * @return Event
     */
    public function setIndustries($industries)
    {
        $this->industries = $industries;
        return $this;
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
        if (null == $this->visuel){
            return null;
        }

        return new Media(json_decode($this->visuel, true));
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function setVisuel(Media $media)
    {

        $this->visuel =  str_replace('\\', '',(str_replace('\\', '', json_encode($media->toArray()))));

        return $this;
    }

    /**
     * @return string
     */
    public function getIllustrations()
    {
        if (null == $this->illustrations){
            return null;
        }

        return new Media(json_decode($this->illustrations, true));
    }

    /**
     * @param Media $media
     * @return $this
     */
    public function setIllustrations($illustrations)
    {
        $this->illustrations = str_replace('\\', '', json_encode($illustrations));

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getVenue()
    {
        return $this->venue;
    }

    /**
     * @param string $venue
     * @return Event
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
        return $this;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     * @return Event
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("visuel")
     * @JMS\Groups(groups={"event"})
     *
     * @return string|null
     */
    public function getVirtuelVisuel()
    {
        return $this->visuel;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("illustrations")
     * @JMS\Groups(groups={"event"})
     *
     * @return string|null
     */
    public function getIllustrationsVirtuel()
    {
        return $this->illustrations;
    }

}

