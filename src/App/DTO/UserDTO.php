<?php

namespace App\DTO;

readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ){}
}