<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Articles</h3>
    <a href="/admin/articles/create" class="btn btn-primary">Add New</a>
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
            <td><?= substr($article['title'], 0, 30) . (strlen($article['title']) > 30 ? '...' : '') ?></td>
            <td><?= $article['author'] ?></td>
            <td><?= $article['created_at'] ?></td>
            <td style="min-width: 150px;">
                <a href="/admin/articles/edit/<?= $article['id'] ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                <form action="/admin/articles/delete/<?= $article['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
