<?php

namespace App\Validator;

use CommitM\PDFRator\PdfDriverResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class DriverExistsValidator extends ConstraintValidator
{
    public function __construct(private readonly PdfDriverResolver $driverResolver)
    {}

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof DriverExists) {
            throw new UnexpectedTypeException($constraint, DriverExists::class);
        }

        if ($this->driverResolver->hasDriver($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ string }}', $value)
            ->addViolation();
    }
}