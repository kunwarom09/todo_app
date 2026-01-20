<?php $this->layout('layout/main'); ?>

<div class="homeContainer">
    <table class="todoTable">
        <thead>
        <tr>
            <th>SN</th>
            <th>Title</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $sn = 1; ?>
        <?php
        /** @var \App\DTO\TodoDTO $todo */
        foreach ($todos as $todo): ?>
            <tr>
                <td><?= $todo->id ?></td>
                <td>
                    <?= $this->e($todo->title) ?>
                    <div style="font-size: 80%;">
                    <?=$todo->getUserDisplayName()?>
                    </div>
                </td>
                <td>
                    <span class="status-inline">
                        <?=$todo->status->getIcon()?>
                        <?=$todo->status->getLabel()?>
                    </span>
                </td>
                <td><?= $todo->getFormattedDueDate() ?></td>
                <td>
                    <div class="actionButtons">
                        <a href="<?= urlGenerator()->generatePath(
                            'edit_todo', [
                            'id' => $todo->id
                        ]) ?>">
                            <button class="editBtn">Edit</button>
                        </a>
                        <a href="<?= urlGenerator()->generatePath(
                            'clone_todo',
                            ['id' => $todo->id]
                        ) ?>">
                            <button class="cloneBtn">Clone</button>
                        </a>
                        <button class="deleteBtn"
                                onclick="showDeleteModal(<?= $todo->id?>,'<?= $this->e($todo->title) ?>')">
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div id="deleteModal" class="modal">
        <div class="modalContent">
            <h3>Delete Todo</h3>
            <p id="deleteMessage"></p>
            <form method="post" id="deleteForm">
                <button type="submit" class="btn-danger">
                    Yes, Delete
                </button>
                <button type="button" class="btn-secondary" onclick="hideDeleteModal()">
                    No, Cancel
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    const modal = document.getElementById('deleteModal');
    const message = document.getElementById('deleteMessage');
    const form = document.getElementById('deleteForm');

    function showDeleteModal(id, title) {
        console.log('hero');
        message.textContent = `Are you sure you want to delete "${title}"?`;
        let url = "<?= urlGenerator()->generatePath('delete_todo', ['id' => '__ID__']) ?>"
        url = url.replace('__ID__', id)
        form.action = url;
        modal.classList.add('show');
    }

    function hideDeleteModal() {
        modal.classList.remove('show');
    }
</script>

