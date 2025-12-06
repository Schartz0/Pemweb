<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>
<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Tambah Ruangan</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('admin/ruangan'); ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Ruangan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Ruangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ruangan as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td>
                                    <form class="d-flex" method="post" action="<?= base_url('admin/ruangan/' . $item['id_ruangan']); ?>">
                                        <input type="text" name="nama_ruangan" class="form-control me-2" value="<?= esc($item['nama_ruangan']); ?>" required>
                                        <button class="btn btn-sm btn-warning" type="submit">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="<?= base_url('admin/ruangan/' . $item['id_ruangan'] . '/delete'); ?>" method="post" onsubmit="return confirm('Hapus ruangan ini?');">
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

