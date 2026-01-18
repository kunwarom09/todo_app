<?php

namespace App\Controller;

use App\DTO\CreateTodoDTO;
use App\Enum\TodoStatus;
use League\Plates\Engine;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TodoController
{

    use RenderTrait;

    public function __construct(
        protected Engine $templateEngine,
    )
    {
    }

    public function view(): void
    {
        echo $this->render('create',['status' => TodoStatus::cases()]);
    }
    public function store(): void
    {
        $createTodoDTO = new CreateTodoDTO($_POST['todo'],$_POST['status']);
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $errors = $validator->validate($createTodoDTO);
        var_dump((string)$errors);
        if(count($errors)>0){
            echo 'h';
        }
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
