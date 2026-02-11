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
            <th>Order</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sliders as $slider): ?>
        <tr>
            <td><img src="/<?= $slider['image_path'] ?>" height="50"></td>
            <td><?= $slider['order_index'] ?></td>
            <td>
                <a href="/admin/sliders/edit/<?= $slider['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <form action="/admin/sliders/delete/<?= $slider['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want todelete this item?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
