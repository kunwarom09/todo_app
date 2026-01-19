<?php $this->layout('layout/main'); ?>
<?php
$errors = '';
function showError($errors, $field)
{
    if (empty($errors[$field]))
        return '';
    echo '<div class="errorMessage">' . htmlspecialchars($errors[$field]) . '</div>';
}

?>
<div class="updateTodoForm">
    <div class="form_container">
        <form action="<?= urlGenerator()->generatePath('update_todo',['id'=>$data['id']]) ?>" method="POST">
            <h2>Update todo</h2>
            <Label>Title:
                <input placeholder="Enter new todo" name="title"
                       value="<?= $data['title'] ?>"
                       style="<?= isset($errors['title']) ? 'border:1px solid red;' : '' ?>">
                <?php showError($errors, 'title') ?>
            </Label>
            <Label>Status:
                <select name="status" style="<?= isset($errors['status']) ? 'border:1px solid red;' : '' ?>">
                    <option>Choose a status</option>
                    <?php foreach (\App\Enum\TodoStatus::cases() as $case): ?>
                        <option value="<?= $case->value ?>"
                                <?= ($data['status'] === $case->value) ? 'selected' : '' ?>>
                            <?= $case->value ?></option>
                    <?php endforeach; ?>
                </select>
                <?php showError($errors, 'status') ?>
            </Label>
            <Label>Due Date:
                <input type="date" name="dueDate"
                       value="<?= $data['due_date'] ?>"
                       style="<?= isset($errors['dueDate']) ? 'border:1px solid red;' : '' ?>">
                <?php showError($errors, 'dueDate') ?>
            </Label>
            <button type="submit">Update</button>
        </form>
    </div>
</div>