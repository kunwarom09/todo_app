<?php

namespace App\DTO;

use App\Enum\TodoStatus;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

readonly class TodoDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public TodoStatus $status,
        public DateTime $dueDate,
        public DateTime $createdAt,
        public DateTime $updatedAt,

        public ?UserDTO $user = null
    )
    {}

    public function getUserDisplayName(): string
    {
        return $this->user?->name ?? '';
    }

    public function getFormattedDueDate(): string
    {
        return $this->dueDate->format('Y-m-d');
    }

    public function __toArray(): array
    {
        $data = get_object_vars($this);
        $data['due_date'] = $this->getFormattedDueDate();
        return $data;
    }
}
