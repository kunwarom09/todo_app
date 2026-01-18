<div class="nav_bar_container">
    <div class="nav_bar">
        <div class="logo"><a href="<?= $baseUrl ?>">ToDo App</a></div>
        <div class="nav_links">
            <ul>
                <li><a href="<?= urlGenerator()->generatePath('home') ?>">Home</a></li>
                <li><a href="<?= urlGenerator()->generatePath('view') ?>">Create</a></li>

        </div>
    </div>
</div>

<div class="page_content">
    <?= $this->section('content') ?>
</div>
