<?php $this->layout('layout/main');?>
<?php
function showError($errors, $field)
{
    if (empty($errors[$field]))
        return '';
    echo '<div class="errorMessage">' . htmlspecialchars($errors[$field]) . '</div>';
}
?>
<div class="createTodoForm">
    <div class="form_container">
        <form action="<?= urlGenerator()->generatePath('store_todo') ?>" method="POST">
           <h2>Enter new todo</h2>
            <Label>Title:
                <input placeholder="Enter new todo" name="title" style="<?= isset($errors['title']) ? 'border:1px solid red;' : '' ?>">
                <?php showError($errors, 'title') ?>
            </Label>
            <Label>Status:
                <select name="status" style="<?= isset($errors['status']) ? 'border:1px solid red;' : '' ?>">
                    <option>Choose a status</option>
                    <?php foreach(\App\Enum\TodoStatus::cases() as $case): ?>
                        <option value="<?= $case->value ?>"><?= $case->value ?></option>
                    <?php endforeach; ?>
                </select>
                <?php showError($errors, 'status') ?>
            </Label>
            <Label>Due Date:
                <input type="date" name="dueDate" style="<?= isset($errors['dueDate']) ? 'border:1px solid red;' : '' ?>">
                <?php showError($errors, 'dueDate') ?>
            </Label>
            <button type="submit">Add</button>
        </form>
    </div>
</div>