<?php

namespace App\Validators;
use App\Enum\TodoStatus;
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
                'title' =>  [
                    new Assert\Length(
                        min: 10,
                        max: 100,
                        minMessage: 'Title must be at least {{ limit }} characters',
                        maxMessage: 'Title must be at most {{ limit }} characters'                        ),
                    new Assert\NotBlank(
                        message: 'Title cannot be blank.'
                    ),
                    new Assert\Regex([
                        'pattern' => '/^[\p{L}\p{N}\s.,!?\'"-]+$/u',
                        'message' => 'Title must be plain text only. No HTML, JS, PHP, or other code allowed.',
                    ]),
                ],
                'status' =>  [
                    new Assert\NotBlank(
                        message: 'Status cannot be blank.'
                    ),
                    new Assert\Choice(
                        choices: array_map(
                            fn (TodoStatus $status) => $status->value,
                            TodoStatus::cases()
                        ),
                        message: 'Invalid status'
                    )
                ],
                'dueDate' =>  [
                    new Assert\NotBlank(
                        message: 'Due Date cannot be blank.'
                    )
                ]
            ]
        );
        $violations = $validator->validate($input, $constraint);
        if(count($violations) === 0 ) return null;
        return $violations;
    }
}