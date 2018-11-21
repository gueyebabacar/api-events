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

    const PUBLIC_EVENT_STATUS_DISPLAY = [
        'published',
        'archived'
    ];

    const EDITOR_EVENT_STATUS_DISPLAY = [
        'draft',
        'published',
        'archived',
        'cancelled'
    ];

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var int
     */
    private $id;

    /**
     * @JMS\Groups(groups={"event","request_register"})
     * @var string
     */
    private $customerRef;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $title;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @var \DateTime
     */
    private $startDate;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("DateTime<'Y-m-d'>")
     * @var \DateTime
     */
    private $endDate;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("DateTime<'H:i:s'>")
     * @var \DateTime
     */
    private $startTime;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("DateTime<'H:i:s'>")
     * @var \DateTime
     */
    private $endTime;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var integer
     */
    private $availableSeats;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $description;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $website;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $country;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $venue;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $city;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("array<BusinessBundle\Entity\ValueList>")
     */
    private $eventType;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("array<BusinessBundle\Entity\ValueList>")
     */
    private $industries;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("array<BusinessBundle\Entity\ValueList>")
     */
    private $eventTopic;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $organizer;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $contactEmail;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $attachment;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("array<string>")
     */
    private $socialMediaSharing;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var string
     */
    private $status;

    /**
     * @JMS\Groups(groups={"event"})
     * @var ArrayCollection
     */
    private $requestRegisters;


    private $visuel;

    /**
     * @JMS\Type("array< BusinessBundle\ValueObject\Media>")
     */
    private $illustrations;

    private $deletedAt;

    /**
     * @JMS\Groups(groups={"event"})
     * @var \DateTime
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private $createdAt;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @var \DateTime
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     */
    private $updatedAt;

    /**
     * @JMS\Groups(groups={"event", "request_register"})
     * @JMS\Type("DateTime<'Y-m-d H:i:s'>")
     * @var \DateTime
     */
    private $publishedAt;

    /**
     * @JMS\Groups(groups={"event"})
     * @var ArrayCollection
     */
    private $agendas;

    public function __construct() {
        $this->requestRegisters = new ArrayCollection();
        $this->agendas = new ArrayCollection();
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * Set description
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return mixed
     */
    public function getIndustries()
    {
        return $this->industries;
    }

    /**
     * @param mixed $industries
     * @return $this
     */
    public function setIndustries($industries)
    {
        $this->industries = $industries;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param mixed $eventType
     * @return $this
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventTopic()
    {
        return $this->eventTopic;
    }

    /**
     * @param mixed $eventTopic
     * @return $this
     */
    public function setEventTopic($eventTopic)
    {
        $this->eventTopic = $eventTopic;
        return $this;
    }

    /**
     * Set organizer
     *
     * @param string $organizer
     *
     * @return $this
     */
    public function setOrganizer($organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    /**
     * Get organizer
     *
     * @return string
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * Set attachment
     *
     * @param string $attachment
     *
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function setVenue($venue)
    {
        $this->venue = $venue;
        return $this;
    }

    /**
     * @return int
     */
    public function getAvailableSeats()
    {
        return $this->availableSeats;
    }

    /**
     * @param int $availableSeats
     * @return $this
     */
    public function setAvailableSeats($availableSeats)
    {
        $this->availableSeats = $availableSeats;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     * @return $this
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     * @return $this
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        return $this;
    }


    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("visuel")
     * @JMS\Groups(groups={"event", "request_register"})
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
     * @JMS\Groups(groups={"event", "request_register"})
     *
     * @return string|null
     */
    public function getIllustrationsVirtuel()
    {
        return $this->illustrations;
    }

    /**
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * @param string $contactEmail
     * @return $this
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return $this
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return $this
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $publishedAt
     * @return $this
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
        return $this;
    }

    /**
     * @JMS\VirtualProperty()
     * @JMS\SerializedName("totalRegistration")
     * @JMS\Groups(groups={"event"})
     *
     * @return string|null
     */
    public function getTotalRegistration()
    {
        return count($this->requestRegisters);
    }

    /**
     * @return ArrayCollection
     */
    public function getAgendas()
    {
        return $this->agendas;
    }

    /**
     * @param ArrayCollection $agendas
     */
    public function setAgendas($agendas)
    {
        $this->agendas = $agendas;
    }
}

