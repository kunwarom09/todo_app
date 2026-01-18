<?php

namespace App\DTO;

use App\Enum\TodoStatus;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

readonly class CreateTodoDTO
{
    public function __construct(
        public string $todo,
        public string $status
    )
    {

    }


    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('todo', new Assert\NotBlank(message: 'Todo cannot be blank.'));
        $metadata->addPropertyConstraint('todo', new Assert\Length(
            min: 10,
            max: 10,
            minMessage: 'Todo must be at least {{ limit }} characters',
            maxMessage: 'Todo must be at most {{ limit }} characters'
        ));

        $metadata->addPropertyConstraint('status', new Assert\NotBlank(message: 'Status is required'));
        $metadata->addPropertyConstraint('status', new Assert\Choice(
            choices: TodoStatus::values(),
            message: 'Invalid status'
        ));
    }
}
