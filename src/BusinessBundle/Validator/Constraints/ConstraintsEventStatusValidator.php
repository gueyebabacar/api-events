<?php

namespace BusinessBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;


class ConstraintsEventStatusValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $status = ['draft', 'published', 'publishrequest', 'archived', 'cancelled'];
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