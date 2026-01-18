<?php

namespace App\Controller;

use App\Validators\CreateTodoValidator;
use Symfony\Component\HttpFoundation\Request;

use App\DTO\CreateTodoDTO;
use App\Enum\TodoStatus;
use League\Plates\Engine;


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
    public function store(Request $request): void
    {
        /* $input = array_filter($request->request->all(), function($key){
            return in_array($key, [
                'todo', 'status'
            ]);
        }, ARRAY_FILTER_USE_KEY);*/

        $input = [
            'todo' => $request->request->get('todo'),

            //create enum from post data
            'status' => $request->request->get('status'),
        ];

        $violations = CreateTodoValidator::validate($input);
        if($violations){
            foreach ($violations as $index => $violation) {
                //$key = array_keys($violation->getRoot())[$index];
                //var_dump($key);
                var_dump($violation->getMessage());
            }
        }





        /*
        $todoViolations = $validator->validate(
            $request->request->get('todo'),
            [
                new Assert\Length(min: 10),
                new Assert\NotBlank(),
            ]
        );

        foreach ($todoViolations as $violation) {
            var_dump($violation);
            var_dump($violation->getMessage());
        }*/



        die();


        /*
        $createTodoDTO = new CreateTodoDTO($_POST['todo'],$_POST['status']);
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $errors = $validator->validate($createTodoDTO);
        var_dump((string)$errors);
        if(count($errors)>0){
            echo 'h';
        }
        */
    }

    public function edit()
    {

    }

    public function delete()
    {

    }
}
