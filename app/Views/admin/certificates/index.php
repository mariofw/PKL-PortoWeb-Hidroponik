<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Penghargaan</h1>
        <a href="/admin/certificates/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penghargaan
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
                            <th width="50">No</th>
                            <th width="100">Gambar</th>
                            <th>Judul</th>
                            <th width="300">Deskripsi</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($certificates)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data penghargaan.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($certificates as $key => $cert): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td class="text-center">
                                        <img src="/<?= $cert['image_path'] ?>" alt="<?= $cert['title'] ?>" height="50" class="img-thumbnail">
                                    </td>
                                    <td class="fw-bold"><?= $cert['title'] ?></td>
                                    <td>
                                        <div style="max-height: 60px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            <?= $cert['description'] ?>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/certificates/edit/<?= $cert['id'] ?>" class="btn btn-warning btn-sm me-1">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="/admin/certificates/delete/<?= $cert['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
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
