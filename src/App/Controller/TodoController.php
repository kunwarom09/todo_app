<?php

namespace App\Controller;

use App\Adapter\TodoAdapter;
use App\UrlGenerator;
use App\Validators\CreateTodoValidator;
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

    public function view(array $errors = [], array $userInputs = []): void
    {
        echo $this->render('create', ['status' => TodoStatus::cases(), 'errors' => $errors, 'userInputs' => $userInputs]);
    }
    public function store(Request $request): void
    {
        /* $input = array_filter($request->request->all(), function($key){
            return in_array($key, [
                'todo', 'status'
            ]);
        }, ARRAY_FILTER_USE_KEY);*/
        $input = $this->getInputs($request);
        $errors = $this->validateInputs($input);
        if (empty($errors)) {
            $result = $this->todoAdapter->store($input);
            $response = new RedirectResponse(urlGeneratorAlias()->generatePath('home'));
            $response->send();
        } else {
            $this->view($errors, $input);
        }
    }

    public function edit(int $id, array $errors = [], array $userInputs = [])
    {
        $todo = $this->todoAdapter->getById($id);
        echo $this->render('edit', ['data' => $todo, 'errors' => $errors, 'userInputs' => $userInputs]);
    }

    public function update(int $id, Request $request)
    {
        $input = $this->getInputs($request);
        $errors = $this->validateInputs($input);
        if (empty($errors)) {
            $result = $this->todoAdapter->update($id, $input);
            $response = new RedirectResponse(urlGeneratorAlias()->generatePath('home'));
            $response->send();
        } else {
            $this->edit($id, $errors, $input);
        }
    }

    public function delete(int $id,PageController $pageController): void
    {
        $result = $this->todoAdapter->delete($id);
        $pageController->index($this->todoAdapter);
    }
}
