<?php

namespace BusinessBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class ConstraintsRegisterRequestStatusValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $status = ['request', 'approved', 'refused'];
        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!in_array($value, $status)) {

            $this->context->addViolation($constraint->message);
        }
    }
}