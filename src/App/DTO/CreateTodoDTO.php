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
    {}
}
