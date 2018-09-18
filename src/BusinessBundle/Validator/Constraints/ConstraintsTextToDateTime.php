<?php

namespace BusinessBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


class ConstraintsTextToDateTime  extends Constraint
{
    public $message = 'Date format is not valid, d/m/Y format is required';

    public function validatedBy()
    {
        return 'format_date_event_not_valid';
    }
}