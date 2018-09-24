<?php

namespace BusinessBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


class ConstraintsRegisterRequestStatus  extends Constraint
{
    public $message = 'RegisterRequest\'s status not valid: request, approved, refused are permitted';

    public function validatedBy()
    {
        return 'status_register_request_not_valid';
    }
}