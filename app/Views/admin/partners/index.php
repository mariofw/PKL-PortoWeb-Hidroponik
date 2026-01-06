<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Partner</h1>
        <a href="/admin/partners/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Partner
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Logo</th>
                            <th>Nama Partner</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($partners)): ?>
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data partner.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($partners as $key => $partner): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td>
                                        <img src="/<?= $partner['logo_path'] ?>" alt="<?= $partner['name'] ?>" height="50">
                                    </td>
                                    <td><?= $partner['name'] ?></td>
                                    <td>
                                        <a href="/admin/partners/edit/<?= $partner['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/partners/delete/<?= $partner['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus partner ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
