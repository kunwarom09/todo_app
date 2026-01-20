<?php

/** @var \App\DTO\TodoDTO $todo */


use App\Enum\TodoStatus;

$this->layout('layout/main'); ?>
<?php


function showError($errors, $field)
{
    if (empty($errors[$field]))
        return '';
    echo '<div class="errorMessage">' . htmlspecialchars($errors[$field]) . '</div>';
}

?>
<div class="updateTodoForm">
    <div class="form_container">
        <form action="<?= urlGenerator()->generatePath('update_todo',['id'=>$todo->id]) ?>" method="POST">
            <h2>Update todo</h2>
            <Label>Title:
                <input placeholder="Enter new todo" name="title"
                       value="<?= $old['title'] ?? $todo->title ?>"
                       style="<?= isset($errors['title']) ? 'border:1px solid red;' : '' ?>">
                <?php showError($errors, 'title') ?>
            </Label>
            <Label>Status:
                <select name="status" style="<?= isset($errors['status']) ? 'border:1px solid red;' : '' ?>">
                    <option>Choose a status</option>
                    <?php

                    foreach (\App\Enum\TodoStatus::cases() as $status):

                        if(isset($old['status'])) {
                            $todoStatus = TodoStatus::tryFrom($old['status']);
                        }else{
                            $todoStatus = $todo->status;
                        }

                    ?>
                        <option value="<?= $status->value ?>"
                                <?= ($todoStatus === $status) ? 'selected' : '' ?>>
                        <?=$status->getLabel()?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php showError($errors, 'status') ?>
            </Label>
            <Label>Due Date:
                <input type="date" name="dueDate"
                       value="<?= $old['due_date'] ?? $todo->getFormattedDueDate() ?>"
                       style="<?= isset($errors['dueDate']) ? 'border:1px solid red;' : '' ?>">
                <?php showError($errors, 'dueDate') ?>
            </Label>
            <button type="submit">Update</button>
        </form>
    </div>
</div>