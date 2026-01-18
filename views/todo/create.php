<?php $this->layout('layout/main');?>
<div class="createTodoForm">
    <form action="<?= urlGenerator()->generatePath('store_todo') ?>" method="POST">
        <input placeholder="Enter new todo" name="todo">
        <select name="status">
            <option ></option>
            <?php foreach(\App\Enum\TodoStatus::cases() as $case): ?>
                <option value="<?= $case->name ?>"><?= $case->value ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date">
        <button type="submit">Add</button>
    </form>
</div>