<?php

namespace App\Controller;

use App\Adapter\TodoAdapter;
use App\UrlGenerator;
use App\Validators\CreateTodoValidator;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\Request;
use App\Enum\TodoStatus;
use League\Plates\Engine;
use Symfony\Component\HttpFoundation\RedirectResponse;
use function urlGenerator as urlGeneratorAlias;

class TodoController
{
    use RenderTrait;

    public function __construct(
        protected Engine      $templateEngine,
        protected TodoAdapter $todoAdapter
    )
    {
    }

    function getInputs($request): array
    {
        return [
            'title' => strip_tags($request->request->get('title')),
            'status' => $request->request->get('status'),
            'dueDate' => $request->request->get('dueDate'),
        ];
    }

    function validateInputs(array $input): array
    {
        $violations = CreateTodoValidator::validate($input);
        $errors = [];
        if ($violations) {
            foreach ($violations as $index => $violation) {
                $key = trim($violation->getPropertyPath(), '[]');
                $message = $violation->getMessage();
                $errors[$key] = $message;
            }
        }
        return $errors;
    }

    public function store(Request $request): void
    {
        $errors = [];
        $input = $this->getInputs($request);
        if ($request->getMethod() === 'POST') {
            $errors = $this->validateInputs($input);
            if (empty($errors)) {
                $this->todoAdapter->store($input);
                $response = new RedirectResponse(urlGeneratorAlias()->generatePath('home'));
                $response->send();
            }
        }
            echo $this->render('create', [
            'errors' => $errors,
            'userInputs' => $input
        ]);
    }

        /* $input = array_filter($request->request->all(), function($key){
            return in_array($key, [
                'todo', 'status'
            ]);
        }, ARRAY_FILTER_USE_KEY);*/

    public function edit(int     $id,
                         Request $request,
    ): void
    {
        $todo = $this->todoAdapter->getById($id);
        $errors = [];
        if ($request->getMethod() === 'POST') {
            $toUpdateTodo = $this->todoAdapter->getById($id);
            if (empty($toUpdateTodo)) {
                throw new \Exception('Todo for given id' . ' ' . $id . ' ' . 'is not found');
            }
            $userInputs = $this->getInputs($request);
            $errors = $this->validateInputs($userInputs);
            $todo = array_merge($todo, $userInputs);
            if (empty($errors)) {
                $result = $this->todoAdapter->update($id, $userInputs);
                $response = new RedirectResponse(urlGeneratorAlias()->generatePath('home'));
                $response->send();
                exit();
            }
        }
        echo $this->render('edit', [
            'data' => $todo,
            'errors' => $errors
        ]);
    }

    public function delete(int $id, PageController $pageController): void
    {
        $result = $this->todoAdapter->delete($id);
        $pageController->index($this->todoAdapter);
    }

    public function clone(int $id)
    {
        $todo = $this->todoAdapter->getById($id);
        $data = [
            'title' => $todo['title'],
            'status' => $todo['status'],
            'dueDate' => $todo['due_date'],
        ];
        $this->todoAdapter->store($data);
        $response = new RedirectResponse(urlGeneratorAlias()->generatePath('home'));
        $response->send();
        exit();
    }
}
