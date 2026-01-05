<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Sliders</h3>
    <a href="/admin/sliders/new" class="btn btn-primary">Add New</a>
</div>

<?php if(session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Order</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sliders as $slider): ?>
        <tr>
            <td><img src="/<?= $slider['image_path'] ?>" height="50"></td>
            <td><?= $slider['title'] ?></td>
            <td><?= $slider['order_index'] ?></td>
            <td>
                <a href="/admin/sliders/<?= $slider['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                <a href="/admin/sliders/<?= $slider['id'] ?>/delete" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
