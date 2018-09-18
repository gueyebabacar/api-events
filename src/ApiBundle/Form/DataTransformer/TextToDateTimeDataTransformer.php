<?php

namespace ApiBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TextToDateTimeDataTransformer implements DataTransformerInterface
{
    public function transform($datetime)
    {
        if (null === $datetime) {
            return '';
        }
    }

    public function reverseTransform($stringDate)
    {
        if (null === $stringDate) {
            return NULL;
        }

        if (!is_string($stringDate)) {
            throw new TransformationFailedException('Expected a string.');
        }
        $date = date_create_from_format('d/m/Y', $stringDate);

        if(false == $date){
            return $date;
        }

        return $date->format("d/m/Y H:i:s");
    }
}