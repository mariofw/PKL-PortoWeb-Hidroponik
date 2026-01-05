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
                <a href="/admin/services/<?= $service['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                <a href="/admin/services/<?= $service['id'] ?>/delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
