<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Services</h3>
    <a href="/admin/services/new" class="btn btn-primary">Add New</a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Icon</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($services as $service): ?>
        <tr>
            <td>
                <?php if($service['icon_image']): ?>
                <img src="/<?= $service['icon_image'] ?>" height="50">
                <?php endif; ?>
            </td>
            <td><?= $service['title'] ?></td>
            <td><?= substr($service['description'], 0, 50) ?>...</td>
            <td>
                <a href="/admin/services/edit/<?= $service['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <form action="/admin/services/delete/<?= $service['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
