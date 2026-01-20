<?php

namespace App\Hydrator;

use App\DTO\TodoDTO;
use App\DTO\UserDTO;
use App\Enum\TodoStatus;
use DateTime;

class TodoHydrator
{
    public static function make(array $data): TodoDTO
    {
        $user =  $data['user_id']
            ? new UserDTO(
                id: $data['user_id'],
                name: $data['name'],
                email: $data['email']
            )
            : null;



        return new TodoDTO(
            id: $data['id'],
            title: $data['title'],
            status: TodoStatus::tryFrom($data['status']) ?? TodoStatus::Pending,
            dueDate: new DateTime($data['due_date']),
            createdAt: new DateTime($data['created_date']),
            updatedAt: new DateTime($data['updated_date']),
            user: $user
        );
    }
}