<?php

namespace BusinessBundle\ValueObject;

use JMS\Serializer\Annotation as JMS;


class ValueListParameters
{
    /** @var string */
    protected $domain;

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
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