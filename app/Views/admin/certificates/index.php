<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Sertifikat Uji Kompetensi</h1>
        <a href="/admin/certificates/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Sertifikat
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
                            <th>Sertifikat</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($certificates)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Belum ada sertifikat.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($certificates as $key => $cert): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td>
                                        <img src="/<?= $cert['image_path'] ?>" alt="<?= $cert['title'] ?>" height="50">
                                    </td>
                                    <td><?= $cert['title'] ?></td>
                                    <td><?= $cert['description'] ?></td>
                                    <td>
                                        <a href="/admin/certificates/edit/<?= $cert['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/admin/certificates/delete/<?= $cert['id'] ?>" method="post" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
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
