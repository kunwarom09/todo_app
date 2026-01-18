<?php $this->layout('layout/main');?>
<div class="createTodoForm">
    <form action="<?= urlGenerator()->generatePath('store_todo') ?>" method="POST">
        <input placeholder="Enter new todo" name="todo">
        <select name="status">
            <?php foreach($status as $case): ?>
                <option value="<?= $case->value ?>"><?= $case->name ?></option>
            <?php endforeach; ?>
        </select>
        <input type="date">
        <button type="submit">Add</button>
    </form>
</div>