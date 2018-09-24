<?php

namespace BusinessBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


class ConstraintsEventStatus  extends Constraint
{
    public $message = 'Event\'s status not valid: draft, published, publishRequest, archived are permitted';

    public function validatedBy()
    {
        return 'status_event_not_valid';
    }
}