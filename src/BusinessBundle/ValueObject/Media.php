<?php

namespace BusinessBundle\ValueObject;

use JMS\Serializer\Annotation as JMS;


class Media
{
    protected $type;
    protected $uri;

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param mixed $uri
     * @return $this
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
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

