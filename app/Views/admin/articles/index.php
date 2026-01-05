<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Articles</h3>
    <a href="/admin/articles/new" class="btn btn-primary">Add New</a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Author</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($articles as $article): ?>
        <tr>
            <td>
                <?php if($article['image_path']): ?>
                <img src="/<?= $article['image_path'] ?>" height="50">
                <?php endif; ?>
            </td>
            <td><?= $article['title'] ?></td>
            <td><?= $article['author'] ?></td>
            <td><?= $article['created_at'] ?></td>
            <td>
                <a href="/admin/articles/<?= $article['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                <a href="/admin/articles/<?= $article['id'] ?>/delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
