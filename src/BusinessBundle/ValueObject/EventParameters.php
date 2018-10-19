<?php

namespace BusinessBundle\ValueObject;

use JMS\Serializer\Annotation as JMS;


class EventParameters
{
    /** @var array */
    protected $industries;

    /** @var array */
    protected $eventType;

    /** @var array */
    protected $eventTopic;

    /** @var string */
    protected $venue;

    protected $sortBy;
    protected $sortDir;
    protected $eventDateFrom;
    protected $eventDateTo;

    /**
     * @return array
     */
    public function getIndustries()
    {
        return $this->industries;
    }

    /**
     * @param array $industries
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
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * @param mixed $sortBy
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
    }

    /**
     * @return mixed
     */
    public function getSortDir()
    {
        return $this->sortDir;
    }

    /**
     * @param mixed $sortDir
     */
    public function setSortDir($sortDir)
    {
        $this->sortDir = $sortDir;
    }

    /**
     * @return mixed
     */
    public function getEventDateFrom()
    {
        return $this->eventDateFrom;
    }

    /**
     * @param mixed $eventDateFrom
     * @return $this
     */
    public function setEventDateFrom($eventDateFrom)
    {
        $this->eventDateFrom = $eventDateFrom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEventDateTo()
    {
        return $this->eventDateTo;
    }

    /**
     * @param mixed $eventDateTo
     * @return $this
     */
    public function setEventDateTo($eventDateTo)
    {
        $this->eventDateTo = $eventDateTo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClosingDateTo()
    {
        return $this->closingDateTo;
    }

    /**
     * @param mixed $closingDateTo
     * @return $this
     */
    public function setClosingDateTo($closingDateTo)
    {
        $this->closingDateTo = $closingDateTo;
        return $this;
    }

    /**
     * @return array
     */
    public function getEventType()
    {
        return $this->eventType;
    }

    /**
     * @param array $eventType
     * @return $this
     */
    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @return array
     */
    public function getEventTopic()
    {
        return $this->eventTopic;
    }

    /**
     * @param array $eventTopic
     * @return $this
     */
    public function setEventTopic($eventTopic)
    {
        $this->eventTopic = $eventTopic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return array
     */
    public function toArray() {
        $data = [];

        $class_vars = get_object_vars($this);

        foreach ($class_vars as $name => $value) {
            if(!empty($value))
            {
                $data[$name] = $value;
            }
        }

        return $data;
    }
}