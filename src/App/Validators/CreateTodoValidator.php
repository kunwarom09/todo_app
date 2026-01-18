<?php

namespace App\Validators;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class CreateTodoValidator
{
    public static function validate(array $input): ?ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();
        $constraint = new Assert\Collection(
            fields: [
                'todo' =>  [
                    new Assert\Length(min: 4,
                        //minMessage: "ke garerko,,,... yo !, you must write at least {{ limit }} characters"),
                    new Assert\NotBlank(),
                ], 'status' =>  [
                    //enum
                    new Assert\NotBlank(),
                ],
            ]
        );

        $violations = $validator->validate($input, $constraint);

        if(count($violations) === 0 ) return null;
        return $violations;
    }
}